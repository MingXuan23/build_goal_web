require("dotenv").config();

const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV])

const axios = require('axios');

const { getContents } = require('../controllers/contentController');
const { configDotenv } = require("dotenv");


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

const saveUserVectorTest = async (req, res) => {
    const { like_content_ids, dislike_content_ids } = req.body;

    try {
        // Validate if the arrays are provided
        if (!Array.isArray(like_content_ids) || !Array.isArray(dislike_content_ids)) {
            return res.status(400).json({ message: 'Invalid input, arrays are required' });
        }

        const user = req.user;
        const user_vector = await knex('user_vector').select('*').where({ 'user_id': user.id }).first();

        if (user_vector) {
            return res.status(403).json({ message: 'Test Submitted' });

        }

        const initialValues = Array(8).fill(0);

        let like_list = await Promise.all(
            like_content_ids.map(async (x) => {
                const result = await knex('contents').select('category_weight').where('id', x).first();
                if (result) {
                    return typeof result.category_weight === 'string' ? JSON.parse(result.category_weight || '{}') : result.category_weight;

                } else {
                    return null;
                }
            })
        );

        let dislike_list = await Promise.all(
            dislike_content_ids.map(async (x) => {
                const result = await knex('contents').select('category_weight').where('id', x).first();


                if (result) {
                    return typeof result.category_weight === 'string' ? JSON.parse(result.category_weight || '{}') : result.category_weight;

                } else {
                    return null;
                }


            })
        );

        like_list = like_list.filter(z => z !== null);
        dislike_list = dislike_list.filter(z => z !== null);

        let vector = initialValues;

        dislike_list = dislike_list.map(item => {
            if (Array.isArray(item)) {
                return item.map(value => 1 - value); // If item is an array, map over it
            } else {
                return 1 - item; // If it's a number, just subtract from 1
            }
        });



        vector = calUserVector(vector, like_list, 1, 2);
        console.log(vector);

        vector = calUserVector(vector, dislike_list, 0.2, 2);


        vector = Array.from(vector);

        if (vector.length == 0) {
            res.status(400).json({ success: false, message: "Vector Value wrong", vector: vector });
        }


        // Call the Qdrant API with the like and dislike content IDs
        // const response = await axios.post(
        //     `${HOST_URL}/collections/content_collection/points/recommend`,
        //     {

        //         positive: like_content_ids,
        //         negative: dislike_content_ids,
        //         limit: 1,
        //         with_vector: true
        //     },
        //     {
        //         headers: {
        //             'api-key': API_KEY,
        //             'Content-Type': 'application/json'
        //         }
        //     }
        // );

        // console.log('hello',response.data);
        // // Extract the vector from the response
        // const vector = response.data.result[0].vector;


        //console.log(vector);
        var result = await knex('user_vector').insert({
            user_id: user.id,
            values: JSON.stringify(vector),
            created_at: knex.fn.now(),
            updated_at: knex.fn.now(),
        });

        // Send the vector as the response
        await addPointToCollection('user_collection', user.id, res);

    } catch (error) {
        console.error(error);
        if (error.response) {
            console.error('API Error:', error.response.data);
            return res.status(error.response.status).json({
                message: 'Error',
                details: error.response.data
            });
        } else if (error.request) {
            console.error('No response from API:', error.request);
            return res.status(500).json({ message: 'No response from API' });
        } else {
            console.error('Unexpected Error:', error.message);
            return res.status(500).json({ message: 'Unexpected error: ' + error.message });
        }
    }


}

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

        return parseFloat(Math.max(Math.min(val, 0.999), 0).toFixed(3));
    });
};

const calUserVector = (origin, contents, learning_rate, weight) => {

    let newValue = origin

    if (contents.length == 0) {
        return origin;
    }
    contents.forEach(c => {
        newValue = getSum(newValue, c);
    });

    newValue = flattenValues(newValue, learning_rate);

    origin = getSum(origin, newValue)
    origin = flattenValues(origin, weight);

    return Array.from(origin);

}


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


        firstLabel = getSum(firstLabel, selectedList[i].values);

    }

    for (let i = firstIndex; i < selectedList.length; i++) {


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

            const rows = await knex('contents')
                .orderByRaw('RAND()') // Use 'RANDOM()' for PostgreSQL
                .limit(7);

            let contents = [];

            for (const item of rows) {
                const content = await knex('contents')
                    .select('id', 'name', 'desc', 'link', 'image')
                    .where({ id: item.id, status: 1 })
                    .first();

                if (content) {
                    // Use fallback image if content.image is null
                    content.image = content.image || 'https://xbug.online/assets/images/landing-page/3.png';
                    // Use fallback link if content.link is null
                    content.link = content.link || 'https://xbug.online/';
                    contents.push(content);
                }
            }



            return res.status(201).json(contents);

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
            return res.status(400).json({ message: 'Id not found' });
        }

        pointData = {
            id: parseInt(id), // Replace with your desired ID
            payload: {
                state: [user.state]
            },
            vector: (typeof user.values === 'string' ? JSON.parse(user.values || '{}') : user.values),

        };

    } else {
        const content = await knex('contents as c')
            .where({ 'c.id': id, 'c.status': 1 })
            .whereNotNull('c.image')
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
            return res.status(400).json({ message: 'Id not found or Content Missing Crucial Information' });
        }

        pointData = {
            id: parseInt(id), // Replace with your desired ID
            payload: {
                state: (typeof content.state === 'string' ? JSON.parse(content.state || '{}') : content.state),
                reach_score: reach_score,
                type: content.content_type_id
            },
            vector: (typeof content.category_weight === 'string' ? JSON.parse(content.category_weight || '{}') : content.category_weight),
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

        return res.status(200).json({ message: "Submit Successfully" })
        //console.log('Point added successfully:', response.data);
    } catch (error) {

        console.error(error);
        if (error.response) {
            console.error('API Error:', error.response.data); // Log the response
            return res.status(error.response.status).json({
                message: 'Error adding point to collection',
                details: error.response.data, // Include detailed server response
            });
        } else if (error.request) {
            console.error('No response from API:', error.request);
            return res.status(500).json({ message: 'No response from API' });
        } else {
            console.error('Unexpected Error:', error.message);
            return res.status(500).json({ message: 'Unexpected error: ' + error.message });
        }

    }
};




module.exports = {
    getContentCollection,
    addPointContentCollection,
    addPointUserCollection,
    fetchVectorContent,
    calVectorByLabel,
    saveUserVectorTest
};