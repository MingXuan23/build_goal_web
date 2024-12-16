require("dotenv").config();

const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV])

const axios = require('axios');

/**
 * Fetches collection details from the API.
 */


const HOST_URL = process.env.VECTOR_HOST;// Replace with your actual host URL
const API_KEY = process.env.VECTOR_API_KEY;

const getContentByVector = async (values) => {
    const parseValues = typeof values === 'string' ? JSON.parse(values || '{}') : values;

    // Function to create a filter object
    const createFilter = (limit, must = [], should = [], mustNot = []) => ({
        vector: parseValues,
        limit,
        filter: {
            must,
            should,
            must_not: mustNot
        }
    });

    // Define the filters
    const filters = [
        createFilter(2, [{ key: "reach_score", range: { "gte": 5.0 } }], [], [{ key: "type", value: 1 }]),
        createFilter(3, [{ key: "reach_score", range: { "gte": 2 } }], [{ key: "state", match: { "any": ["Melaka"] } }], [{ key: "type", value: 1 }]),
        createFilter(20, [], [], [{ key: "type", value: 1 }])
    ];

    const microLearningFilter = createFilter(7, [{ key: "type", value: 1 }]);

    try {
        // Send both regular filters and micro-learning filters concurrently
        const [regularResponse, microLearningResponse] = await Promise.all([
            axios.post(`${HOST_URL}/collections/content_collection/points/search/batch`, { searches: filters }, {
                headers: {
                    'api-key': API_KEY,
                    'Content-Type': 'application/json'
                }
            }),
            axios.post(`${HOST_URL}/collections/content_collection/points/search/batch`, { searches: [microLearningFilter] }, {
                headers: {
                    'api-key': API_KEY,
                    'Content-Type': 'application/json'
                }
            })
        ]);

        // Create a Set to store unique content IDs
        const content_ids = new Set();

        // Process regular filter results
        regularResponse.data?.result?.forEach(list => {
            list.forEach(item => {
                if (item.id) {
                    content_ids.add(item.id);
                }
            });
        });

        // Process micro-learning results
        microLearningResponse.data?.result?.forEach(list => {
            list.forEach(item => {
                if (item.id) {
                    content_ids.add(item.id);
                }
            });
        });

        // Return the first 10 content IDs
        return Array.from(content_ids).slice(0, 10);
    } catch (error) {
        console.error('Error fetching content:', error);
        throw error;  // Rethrow or handle the error as needed
    }
};

const getContents = async (req, res) => {
    try {
        const user = req.user;

        const user_vector = await knex('user_vector').select('*').where({ 'user_id': user.id }).first();

        const content_ids = await getContentByVector(user_vector.values);


        const contentList = await knex('contents').whereIn('id', content_ids);

         
        contentList.forEach((content) =>  content.link = content.link || 'https://xbug.online/');
                          

        return res.status(200).json(contentList.sort(() => Math.random() - 0.5));

    } catch (error) {
        console.error(error);
        return res.status(500).json(error);
    }
};




module.exports = {
    getContents,
    getContentByVector
};