require("dotenv").config();


const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV])
const axios = require('axios');
const { Transform } = require('stream');

const { getContentByVector } = require('../controllers/contentController');

const HOST_URL = process.env.GPT_HOST;// Replace with your actual host URL
const model = process.env.GPT_MODEL;
const node_env = process.env.NODE_ENV;

const fastResponse = async (req, res, next) => {
  const { prompt, estimate_word, information, tone, chat_history, use_content } = req.body;
  const user = req.user;

  if (!prompt || !information) {
    console.error('Prompt or Inforamtion is missing');
    return res.status(400).json({ error: 'Prompt is required' });
  }

  const estimateWords = estimate_word === undefined || estimate_word === null ? 10 : estimate_word;
  const toneMsg = tone ?? '';

  let final_prompt = '';
  if (estimateWords == -1) {
    final_prompt = `${prompt}. Response as short as possible.`;
  } else if (estimateWords == -2) {
    final_prompt = `${prompt}. Try to no reply too long if not related to financial domain.`;
  } else {
    final_prompt = `${prompt}. Response in ${estimateWords} words.`;
  }

  const user_vector = await knex('user_vector').select('*').where({ 'user_id': user.id }).first();

  let contentList = [];
  if (user_vector || !use_content) {
    const content_ids = await getContentByVector(user_vector.values);


    contentList = await knex('contents').select('name', 'place', 'enrollment_price', 'first_date').whereIn('id', content_ids);
  }

  

  let messagesBody = [
    {
      role: 'system',
      content: `Your name is Jan, an experienced financial advisor in the "Build Growth" Mobile App, who always giving practical solution to financial issues, uses RM (Ringgit Malaysia) as the main currency and responds using English. If the user asks for financial advice, ${toneMsg}.` +
        `You have read and understood the user's financial information as stated below: ${JSON.stringify(information)}.` +
        (contentList.length >= 1
          ? ` You may suggest the user to involve themselves in these courses and events as the solution to increase their income: ${JSON.stringify(contentList)}.`
          : ` You may suggest the user to take a look at the "Content" section in the app for more entrepreneurship and self-investment opportunities.`),
    },
  ];
  

  console.log(contentList.length, contentList, contentList.length >= 1 )
  // Check if chat_history exists and is a non-empty array
  if (Array.isArray(chat_history) && chat_history.length > 0) {
    messagesBody.push(...chat_history); // Spread the chat_history array into messagesBody
  }

  // Add the user message to the messagesBody
  messagesBody.push({ role: 'user', content: final_prompt });


  try {
    const apiResponse = await axios.post(`${HOST_URL}/api/chat`, {
      model: model, // Replace with your actual model name
      messages: messagesBody,
      options: {
        temperature: 0.5,
        num_ctx: 4096,
        repeat_last_n: -1
      },
    }, {
      headers: { 'Content-Type': 'application/json' },
      responseType: 'stream', // Important for streaming responses
    });

    console.log(apiResponse);
    if (apiResponse.status !== 200) {
      console.error(`API error: ${apiResponse.status}`);
      return res.status(apiResponse.status).json({ error: 'API error' });
    }

    // Set up response headers for streaming
    res.setHeader('Content-Type', 'text/event-stream');
    res.setHeader('Cache-Control', 'no-cache');
    res.setHeader('Connection', 'keep-alive');

    // Transform and forward the API response
    const transformStream = new Transform({
      transform(chunk, encoding, callback) {
        const data = chunk.toString().trim();
        if (data) {
          try {
            const jsonData = JSON.parse(data);
            const content = jsonData?.message?.content;
            //  console.log(content);
            if (content) {
              // Send content immediately to the client
              res.write(`${content}`);
            }
          } catch (e) {
            console.error('Error parsing chunk:', e, data);
          }
        }
        callback();
      },
    });

    apiResponse.data.pipe(transformStream);

    apiResponse.data.on('end', () => {
      console.log('Streaming completed');
      res.end();
    });

  } catch (error) {
    console.error('Error in /fast-response:', error);
    res.status(500).json({ error: 'Internal Server Error' });
  }

}


const slowResponse = async (req, res) => {
  let { prompt, estimate_word, information, tone } = req.body;

  if (!prompt || !information) {
    return res.status(400).json({ error: 'Prompt is required' });
  }

  estimate_word = estimate_word ?? 10;
  const toneMsg = tone ?? '';

  const final_prompt = `${prompt}. Response in ${estimate_word} words with simple language.`;

  try {
    const apiResponse = await axios.post(`${HOST_URL}/api/chat`, {
      model: model,
      messages: [
        { role: 'system', content: `Your name is Moon, a experienced financial advisor who using RM(Ringgit Malaysia) as the main currency. If the user ask for financial advise, ${toneMsg}. Please read and analyze user financial information and upcoming event.` },
        { role: 'assistant', content: `I have read and understand your financial status as stated as below ${information}` },
        { role: 'assistant', content: `If you are asking my advice, I may suggest these event/content as below ${['Flutter Helper Class', 'Car boot Sale']}` }

        , { role: 'user', content: final_prompt }],
      options: {
        temperature: 0.5,
        num_predict: 32,
      },
      stream: false
    });
    //res.status(500).json({ error: apiResponse.data });
    const content = apiResponse.data?.message?.content;

    if (!content) {
      return res.status(500).json({ error: 'Failed to retrieve content from API response' });
    }

    res.status(200).json({ content });
  } catch (error) {
    console.error('Error in /slow-response:', error.message);
    res.status(500).json({ error: 'Internal Server Error' });
  }
};

const loadModel = async (req, res) => {
  try {
    const apiResponse = await axios.post(`${HOST_URL}/api/generate`, {
      model: model,
      keep_alive: "30m"
    });

    const statusCode = apiResponse.status;

    console.log('Modal started', statusCode)
    res.status(statusCode).json({
      message: `The request is ${statusCode}`,
    });

  } catch (error) {
    console.error('Error in load Model:', error.message);
    res.status(500).json({ error: error });
  }
};

const pullModel = async (req, res) => {
  try {

    if (node_env == 'production') {
      return res.status(404).json('Not Found');
    }

    try {
      const validateResponse = await axios.post(`${HOST_URL}/api/show`, {
        model: model,

      });
      const statusCode = validateResponse.status;
      res.status(statusCode).json({
        message: `Pulled Already`,
      });
    } catch {
      const apiResponse = await axios.post(`${HOST_URL}/api/pull`, {
        model: model,
        stream: false
      });

      const statusCode = apiResponse.status;

      res.status(statusCode).json({
        message: `${apiResponse.toString()}`,
      });
    }






  } catch (error) {
    console.error('Error in load Model:', error.message);
    res.status(500).json({ error: error });
  }
};


module.exports = { fastResponse, slowResponse, loadModel, pullModel };