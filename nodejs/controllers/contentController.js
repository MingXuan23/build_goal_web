require("dotenv").config();

const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV])

const axios = require('axios');

/**
 * Fetches collection details from the API.
 */


const HOST_URL = process.env.VECTOR_HOST;// Replace with your actual host URL
const API_KEY = process.env.VECTOR_API_KEY;

const getContentByVector = async (values, m_id) => {
    const parseValues = typeof values === 'string' ? JSON.parse(values || '{}') : values;


    // Function to create a filter object
    const createCommonFilter = (limit) => ({
        vector: parseValues,
        limit,
        filter:{ must_not: [{ key: "type", "match": { "value": m_id } }] }
       // ...(Object.keys(filter).length > 0 && { filter })
    });
    
    const createPaidFilter = (limit) => ({
        vector: parseValues,
        limit,
        filter: {
            must: [
                { key: "reach_score", range: { gte: 1.0 } },
              
            ]
        }
    });
    

    const createLearningFilter = (limit) => ({
        vector: parseValues,
        limit,
        filter:{ must: [{ key: "type", "match": { "value": m_id} }] }
       // ...(Object.keys(filter).length > 0 && { filter })
    });
    
    // Define the filters
    const filters = [
        createPaidFilter(3),
        createCommonFilter(10),
    ];

    const microLearningFilter =[createLearningFilter(5)];
    //console.log(filters,microLearningFilter);

    try {
        // Send both regular filters and micro-learning filters concurrently
        const [regularResponse, microLearningResponse] = await Promise.all([
            axios.post(`${HOST_URL}/collections/content_collection/points/search/batch`, { searches: filters }, {
                headers: {
                    'api-key': API_KEY,
                    'Content-Type': 'application/json'
                }
            }),
            axios.post(`${HOST_URL}/collections/content_collection/points/search/batch`, { searches: microLearningFilter }, {
                headers: {
                    'api-key': API_KEY,
                    'Content-Type': 'application/json'
                }
            })
        ]);

        let content_ids = new Set();

        // Process regular filter results
        regularResponse.data?.result?.forEach((list) => {
            list.forEach((item) => {
                if (item.id && content_ids.size < 10) {
                    content_ids.add(item.id);
                }
            });
        });
        
        // Process micro-learning results, adding more IDs if there's room
        microLearningResponse.data?.result?.forEach((list) => {
            list.forEach((item) => {
                if (item.id ) {
                   
                    content_ids.add(item.id);
                }
            });
        });
        console.log( microLearningResponse.data?.result,content_ids )
        return Array.from(content_ids);
        
    } catch (error) {
       // console.error('Error fetching content:', error);
        throw error;  // Rethrow or handle the error as needed
    }
};

const getContents = async (req, res) => {
    try {
        const user = req.user;

        const user_vector = await knex('user_vector').select('*').where({ 'user_id': user.id }).first();
        const m_id = await knex('content_types').where('type','MicroLearning Resource').first()

        const content_ids = await getContentByVector(user_vector.values, m_id.id);


        const contentList = await knex('contents').whereIn('id', content_ids);

         
        contentList.forEach((content) =>  content.link = content.link || 'https://xbug.online/');
                          

        return res.status(200).json({contentList:contentList.sort(() => Math.random() - 0.5), microlearning_id: m_id.id});

    } catch (error) {
        console.error(error);
        return res.status(500).json(error);
    }
};




module.exports = {
    getContents,
    getContentByVector
};