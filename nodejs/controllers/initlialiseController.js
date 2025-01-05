require("dotenv").config();


const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV])

const init_key = process.env.INIT_KEY;
const axios = require('axios');


const createCollection = async (collectionName) => {
    try {
        console.log(`Creating ${collectionName}...`);
        const createResponse = await axios.put(`${V_HOST_URL}/collections/${collectionName}`, {
            vectors: {
                size: 8, // Define the size of the vector
                distance: "Dot" // Use "Dot" for the distance metric
            }
        }, {
            headers: {
                'api-key': API_KEY,
                'Content-Type': 'application/json'
            }
        });

        console.log(`${collectionName} created successfully!`);
    } catch (error) {
        console.error(`Failed to create ${collectionName}:`, error.message);
        throw new Error(`Failed to create ${collectionName}`);
    }
};


const deleteAllPointsFromCollection = async (collectionName) => {
    try {
        // Make the API call to delete all points
        const response = await axios.post(
            `${V_HOST_URL}/collections/${collectionName}/points/delete`,
            {
                filter: {} // Empty filter to delete all points
            },
            {
                headers: {
                    'api-key': API_KEY,
                    'Content-Type': 'application/json'
                }
            }
        );

        // Respond with success
       
    } catch (error) {
        console.error('Error deleting points:', error);
        
    }
};


const deletePointFromCollection = async (collectionName, id, res) => {
    try {
        // Make the API call to delete points

        const response = await axios.post(
            `${V_HOST_URL}/collections/${collectionName}/points/delete`,
            {
                points: [parseInt(id)] // List of IDs to delete
            },
            {
                headers: {
                    'api-key': API_KEY,
                    'Content-Type': 'application/json'
                }
            }
        );



        // Respond with success

    } catch (error) {

       console.log(error);
    }
};

const calculateReachScore = (content_promotion) => {
    const {
        estimate_reach,
        views,
        clicks,
        enrollment
    } = content_promotion;

    // Step 1: Calculate the expression
    let value = estimate_reach - views - clicks * 2 - enrollment * 4;

    // Step 2: Get the max between this value and 1
    value = Math.max(value, 1);

    // Step 3: Compute the base-10 logarithm
    const logValue = Math.log10(value);

    return logValue;
};



const addPointToCollection = async (collectionName, id) => {

    let pointData = {};
    if (collectionName == 'user_collection') {
        // Example Usage

        var user = await knex('user_vector as uv')
            .join("users as u", "uv.user_id", "u.id")
            .select("u.state", "uv.*")
            .where('uv.user_id', id)
            .first();

        if (!user) {
            return
        }

        pointData = {
            id: parseInt(id), // Replace with your desired ID
            payload: {
                state: [user.state]
            },
            vector: user.values // Replace with your actual vector data
        };

    } else {
        const content = await knex('contents as c')
            .where({ 'c.id': id, 'c.status': 1 })
            .whereNotNull('c.link')
            .whereNotNull('c.category_weight')
            .first();



        var content_promotion = await knex('content_promotion as c')
            //.join("users as u","uv.user_id","u.id")
            .where('c.content_id', id)
            .first();

        var reach_score = -1;

        if (content_promotion) {
            //console.log(content_promotion);
            reach_score = calculateReachScore(content_promotion);
        }

        if (!content) {
          return;
        }

        pointData = {
            id: parseInt(id), // Replace with your desired ID
            payload: {
                state: (typeof content.state === 'string' ? JSON.parse(content.state || '{}') : content.state),

                reach_score: reach_score,
                type: content.content_type_id
            },
            vector: (typeof content.category_weight === 'string' ? JSON.parse(content.category_weight || '{}') : content.category_weight),// Replace with your actual vector data
        };



    }

    try {
        const response = await axios.put(`${V_HOST_URL}/collections/${collectionName}/points`, {

            points: [pointData]
        }, {
            headers: {
                'api-key': API_KEY,
                'Content-Type': 'application/json'
            }
        });

       console.log(id, "Success")
    } catch (error) {

        console.error(error);
      

    }
};

const G_HOST_URL = process.env.GPT_HOST;// Replace with your actual host URL
const model = process.env.GPT_MODEL;

const V_HOST_URL = process.env.VECTOR_HOST;// Replace with your actual host URL
const API_KEY = process.env.VECTOR_API_KEY;

const intialise = async (req, res) => {
    try {

        console.log(init_key);
        if (init_key != 1) {
            return res.status(404).json({ message: 'No found.' });
        }

        //check seeder
        const states = await knex('states');
        if (!states || states.length <= 0) {
            return res.status(404).json({ message: 'Seeder no run yet.' });
        }

        //check model

        try {
            const validateResponse = await axios.post(`${G_HOST_URL}/api/show`, {
                model: model,

            });
            const statusCode = validateResponse.status;
            console.log('Model Pulled', statusCode)
        } catch {
            const apiResponse = await axios.post(`${G_HOST_URL}/api/pull`, {
                model: model,
                stream: false
            });

            const statusCode = apiResponse.status;

            console.log(`${apiResponse.toString()}`)

        }


        //vector

        try {
            await axios.get(`${V_HOST_URL}/collections/content_collection`, {
                headers: {
                    'api-key': API_KEY
                }
            });
        } catch (error) {
            if (error.response?.status === 404) {
                await createCollection('content_collection');
            } else {
                throw error;
            }
        }

        // Check and create User Collection
        try {
            await axios.get(`${V_HOST_URL}/collections/user_collection`, {
                headers: {
                    'api-key': API_KEY
                }
            });
        } catch (error) {
            if (error.response?.status === 404) {
                await createCollection('user_collection');
            } else {
                throw error;
            }
        }

        //update the content vector

        // Fetch contents from the 'content' table
        var contents = await knex('contents');
        deleteAllPointsFromCollection('content_collection');
        // Use a for...of loop to handle async operations correctly
        for (let content of contents) {
            try {
                // Delete the point from the collection
                await deletePointFromCollection('content_collection', content.id);

                // Add the point to the collection
                await addPointToCollection('content_collection', content.id);
            } catch (error) {
                // Handle errors (log or whatever you prefer)
                console.error(`Error processing content with ID ${content.id}:`, error);
            }
        }

    return res.status(200).json("Success");





    } catch (error) {
        console.log(error);
        return res.status(403).json({ error: error.message });
    }
};


module.exports = { intialise };