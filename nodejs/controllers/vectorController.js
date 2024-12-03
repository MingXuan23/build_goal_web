require("dotenv").config();

const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV])

const axios = require('axios');

const { getContents } = require('../controllers/contentController');


/**
 * Fetches collection details from the API.
 */


const HOST_URL = process.env.VECTOR_HOST;// Replace with your actual host URL
const API_KEY = process.env.VECTOR_API_KEY;

const createCollection = async (collectionName) => {
    try {
        console.log(`Creating ${collectionName}...`);
        const createResponse = await axios.put(`${HOST_URL}/collections/${collectionName}`, {
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

const getContentCollection = async (req, res) => {
    try {
        // Check and create Content Collection
        try {
            await axios.get(`${HOST_URL}/collections/content_collection`, {
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
            await axios.get(`${HOST_URL}/collections/user_collection`, {
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

        res.status(200).json('User collection and content collection are ready!');
    } catch (error) {
        console.error('Error:', error.message);
        res.status(error.response?.status || 500).json({
            error: 'Failed to fetch or create collections',
            details: error.response?.data || error.message
        });
    }
};


// Function to calculate the sum of two arrays element-wise
const getSum = (targetValues, sourceValues) => {
    return targetValues.map((val, index) => val + (sourceValues[index] || 0));
};

// Function to flatten values based on weight
const flattenValues = (values, weight) => {
    const totalSum = values.reduce((sum, v) => sum + v, 0);
    const average = totalSum / values.length || 0;

    return values.map((v) => {
        let val = 0;
        if (totalSum === 0 || v === 0) {
            val = 0;
        } else {
            val = (v / totalSum) * weight;
        }

        if (v >= average) {
            val *= 1.5;
        } else if (v < average * 0.2) {
            val *= 0.8;
        }

        return Math.min(val, 0.999);
    });
};


const calVectorByLabel = async (req, res) => {
    const { values } = req.query;

    const labelIds = JSON.parse(values);

    const initialValues = Array(8).fill(0);
    let firstLabel = [...initialValues];
    let secondLabel = [...initialValues];

    const firstIndex = parseInt(labelIds.length / 2);

    const selectedList = await Promise.all(
        labelIds.map(async (item) => {
            const label = await knex('labels').select('values').where('id', item).first();
            return label;
        })
    );


    for (let i = 0; i < firstIndex; i++) {
        console.log(i);

        firstLabel = getSum(firstLabel, selectedList[i].values);

    }

    for (let i = firstIndex; i < selectedList.length; i++) {
        console.log(i);

        secondLabel = getSum(secondLabel, selectedList[i].values);
    }

    firstLabel = flattenValues(firstLabel, 1.5);
    secondLabel = flattenValues(secondLabel, 1.0);

    let finalLabel = [...initialValues];
    finalLabel = getSum(finalLabel, firstLabel);
    finalLabel = getSum(finalLabel, secondLabel);

    finalLabel = flattenValues(finalLabel, 2.5);

    return res.status(200).json({
        weight: `[${finalLabel.map((v) => v.toFixed(3)).join(",")}]`,
        reference: `0.Education and Self Improvement ` +
                   `1.Entertainment and Health Fitness ` +
                   `2.Financial and business ` +
                   `3.Technology and digital ` +
                   `4.fashion and art ` +
                   `5.production and construction ` +
                   `6.transportationa and logistics ` +
                   `7.social and personal services`
    });

}

const fetchVectorContent = async (req, res, next) => {
    try {
        const user = req.user;

        const user_vector = await knex('user_vector').select('*').where({ 'user_id': user.id }).first();

        if (!user_vector) {


            var random_vector = Array(8)
                .fill(0)
                .map(() => parseFloat((Math.random() * (0.8 - 0.3) + 0.3).toFixed(2))); // Limit to 2 decimal places

            console.log(random_vector);
            const response = await axios.post(`${HOST_URL}/collections/content_collection/points/search`, {
                vector: random_vector,
                limit: 5
            },
                {
                    headers: {
                        'api-key': API_KEY,
                        'Content-Type': 'application/json'
                    }
                });

            return res.status(201).json(response.data);


        } else {
            next();
        }

    } catch (error) {

        if (error.response) {
            console.error('API Error:', error.response.data);
            return res.status(error.response.status).json({
                error: 'Error',
                details: error.response.data
            });
        } else if (error.request) {
            console.error('No response from API:', error.request);
            return res.status(500).json('No response from API');
        } else {
            console.error('Unexpected Error:', error.message);
            return res.status(500).json('Unexpected error: ' + error.message);
        }
    }

}
const addPointUserCollection = async (req, res) => {
    const { id } = req.params;
    await addPointToCollection('user_collection', id, res);
}

const addPointContentCollection = async (req, res) => {
    const { id } = req.params;
    await deletePointFromCollection('content_collection', id);
    console.log('adding');
    await addPointToCollection('content_collection', id, res);
}

const deletePointFromCollection = async (collectionName, id, res) => {
    try {
        // Make the API call to delete points

        const response = await axios.post(
            `${HOST_URL}/collections/${collectionName}/points/delete`,
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

        if (error.response) {
            console.error('API Error:', error.response.data);
            return res.status(error.response.status).json({
                error: 'Error deleting points from collection',
                details: error.response.data
            });
        } else if (error.request) {
            console.error('No response from API:', error.request);
            return res.status(500).json('No response from API');
        } else {
            console.error('Unexpected Error:', error.message);
            return res.status(500).json('Unexpected error: ' + error.message);
        }
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



const addPointToCollection = async (collectionName, id, res) => {

    let pointData = {};
    if (collectionName == 'user_collection') {
        // Example Usage

        var user = await knex('user_vector as uv')
            .join("users as u", "uv.user_id", "u.id")
            .select("u.state", "uv.*")
            .where('uv.user_id', id)
            .first();

        if (!user) {
            return res.status(400).json('Id not found');
        }

        pointData = {
            id: parseInt(id), // Replace with your desired ID
            payload: {
                state: [user.state]
            },
            vector: user.values // Replace with your actual vector data
        };

    } else {
        var content = await knex('contents as c')
            //.join("users as u","uv.user_id","u.id")
            .where('c.id', id)
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
            return res.status(400).json('Id not found');
        }

        pointData = {
            id: parseInt(id), // Replace with your desired ID
            payload: {
                state: content.state,
                reach_score: reach_score
            },
            vector: content.category_weight // Replace with your actual vector data
        };



    }

    try {
        const response = await axios.put(`${HOST_URL}/collections/${collectionName}/points`, {

            points: [pointData]
        }, {
            headers: {
                'api-key': API_KEY,
                'Content-Type': 'application/json'
            }
        });

        return res.status(200).json(response.data)
        //console.log('Point added successfully:', response.data);
    } catch (error) {

        console.error(error);
        if (error.response) {
            console.error('API Error:', error.response.data); // Log the response
            return res.status(error.response.status).json({
                error: 'Error adding point to collection',
                details: error.response.data, // Include detailed server response
            });
        } else if (error.request) {
            console.error('No response from API:', error.request);
            return res.status(500).json('No response from API');
        } else {
            console.error('Unexpected Error:', error.message);
            return res.status(500).json('Unexpected error: ' + error.message);
        }

    }
};




module.exports = {
    getContentCollection,
    addPointContentCollection,
    addPointUserCollection,
    fetchVectorContent,
    calVectorByLabel
};