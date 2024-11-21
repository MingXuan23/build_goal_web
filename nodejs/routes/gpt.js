var express = require('express');
var router = express.Router();
const axios = require('axios');
const { Transform } = require('stream');

const HOST_URL = 'http://gpt_serivce:11434';// Replace with your actual host URL


// Streaming route
router.post('/fast-response', async (req, res, next) => {
    let { prompt, estimate_word } = req.body;

  if (!prompt) {
    return res.status(400).json({ error: 'Prompt is required' });
  }

  if (estimate_word === undefined || estimate_word === null) {
    estimate_word = 10;
  }

  var final_prompt = `${prompt}. Repsonse in ${estimate_word} words.`;

  try {
    const apiResponse = await axios.post(`${HOST_URL}/api/chat`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        model: 'benevolentjoker/the_economistmini',
        messages: [{ role: 'user', content: final_prompt }],
        options: {
          temperature: 0.5,
          num_predict: 32,
        },
      }),
    });

    if (!apiResponse.ok) {
      throw new Error(`API responded with status ${apiResponse.status}`);
    }

    // Set response headers for streaming
    res.setHeader('Content-Type', 'text/event-stream');
    res.setHeader('Cache-Control', 'no-cache');
    res.setHeader('Connection', 'keep-alive');

    // Transform the streaming response from the external API
    const transformStream = new Transform({
      transform(chunk, encoding, callback) {
        const parts = chunk.toString().split('\n');
        parts.forEach((part) => {
          if (part.trim()) {
            try {
              const jsonData = JSON.parse(part);
              const content = jsonData?.message?.content;
              if (content) {
                this.push(`data: ${content}\n\n`);
              }
            } catch (e) {
              console.error('Error parsing chunk:', e);
            }
          }
        });
        callback();
      },
    });

    apiResponse.body.pipe(transformStream).pipe(res);

    apiResponse.body.on('end', () => res.end());
  } catch (error) {
    console.error('Error in /fast-response:', error);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

router.post('/slow-response', async (req, res) => {
    let { prompt, estimate_word } = req.body;
  
    if (!prompt) {
      return res.status(400).json({ error: 'Prompt is required' });
    }
  
    estimate_word = estimate_word ?? 10;
  
    const final_prompt = `${prompt}. Response in ${estimate_word} words with simple language.`;
  
    try {
      const apiResponse = await axios.post(`${HOST_URL}/api/chat`, {
        model: 'benevolentjoker/the_economistmini',
        messages: [{ role: 'user', content: final_prompt }],
        options: {
          temperature: 0.5,
          num_predict: 32,
        },
        stream:false
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
  });

module.exports = router;
