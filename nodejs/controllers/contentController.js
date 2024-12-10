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
    const content_ids = new Set();

    const filters = [
        {
            vector: values,
            limit: 2,
            filter: {
                must: [
                    {
                        key: "reach_score",
                        range: {
                            "gte": 5.0
                        }
                    }
                ]
            }
        },
        {
            vector: values,
            limit: 3,
            filter: {
                should: [
                    {
                        key: "reach_score",
                        range: {
                            "gte": 2
                        }
                    },
                    {
                        key: "state",
                        match: {
                            "any": ["Melaka"]
                        }
                    }
                ]
            }
        },
        {
            vector: values,
            limit: 20
        }
    ];

    const response = await axios.post(`${HOST_URL}/collections/content_collection/points/search/batch`, {
        searches: filters
    }, {
        headers: {
            'api-key': API_KEY,
            'Content-Type': 'application/json'
        }
    });


    response.data?.result?.forEach(list => {
        list.forEach(item =>{
            if (item.id) {
                content_ids.add(item.id);
            }
        })
        
    });


    const list =  Array.from(content_ids).slice(0, 10);

 

    // Return as an array
    return Array.from(list);
    //return Array.from(content_ids);
}

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