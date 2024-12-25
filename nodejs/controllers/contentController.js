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
        filter: { must_not: [{ key: "type", "match": { "value": m_id } }] }
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
        filter: { must: [{ key: "type", "match": { "value": m_id } }] }
        // ...(Object.keys(filter).length > 0 && { filter })
    });

    // Define the filters
    const filters = [
        createPaidFilter(3),
        createCommonFilter(10),
    ];

    const microLearningFilter = [createLearningFilter(5)];
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
                if (item.id) {

                    content_ids.add(item.id);
                }
            });
        });
        console.log(microLearningResponse.data?.result, content_ids)
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
        const m_id = await knex('content_types').where('type', 'MicroLearning Resource').first()

        const content_ids = await getContentByVector(user_vector.values, m_id.id);


        const contentList = await knex('contents').whereIn('id', content_ids);


        contentList.forEach((content) => content.link = content.link || 'https://xbug.online/');


        return res.status(200).json({ contentList: contentList.sort(() => Math.random() - 0.5), microlearning_id: m_id.id });

    } catch (error) {
        console.error(error);
        return res.status(500).json(error);
    }
};

const saveContentEnrollment = async (req, res) => {

    try {
        const { card_id, verification_code } = req.body; // Extract card_id and user_id from the request body
        const user = req.user;
        const card = await knex('content_card as cc')
            .join('contents as c', 'c.id', 'cc.content_id')
            .leftJoin('transactions as t', 't.id', 'cc.transaction_id')
            .where('t.status', 'Success')
            .where('cc.status', 1)
            .where('cc.verification_code', verification_code)
            .where('c.status', 1)
            .where('cc.card_id', card_id)
            .whereRaw('DATE(cc.startdate) <= CURRENT_DATE')
            .whereRaw('DATE(cc.enddate) >= CURRENT_DATE')
            .select('cc.*')
            .first();

        // If no valid card found, return an error
        if (!card) {
            return res.status(400).json({ message: 'Invalid or expired card.' });
        }

        const existingRecord = await knex('user_content')
            .where({
                'user_id': user.id,
                'interaction_type_id': 3,
                'content_id': card.content_id
            })
            .first();  // This will return the first matching record or null if not found

        if (existingRecord) {
            // If the record already exists, handle accordingly (e.g., return a response or message)
            return res.status(200).json({ message: 'Enrollment already exists' });
        }

        // Proceed to insert the new record if no existing record is found
        var res = await knex('user_content').insert({
            'user_id': user.id,
            'interaction_type_id': 3,
            'content_id': card.content_id,
            'ip_address': req.ip,
            'verification_code': verification_code,
        });

        return res.status(201).json({ message: 'Enrollment inserted successfully' });

    } catch (error) {
        console.error(error)
        return res.status(500).json({ 'message': error })
    }

}

const getContentEnrollment = async (req, res) => {

    try {
        const user = req.user;

        var result = await knex('user_content')
            .join('contents', 'user_content.content_id', '=', 'contents.id')
            .select('user_content.created_at as enrolled_at', 'contents.link', 'contents.name', 'contents.desc', 'contents.id') // Select all fields from both tables
            .where({
                'user_content.user_id': user.id,
                'user_content.interaction_type_id': 3,
            });


        return res.status(200).json({ 'history': result });
    } catch (error) {
        console.error(error)
        return res.status(500).json(error);
    }

}

const getClickedContent = async (req, res) => {

    try {
        const user = req.user;

        var result = await knex('user_content')
            .join('contents', 'user_content.content_id', '=', 'contents.id')
            .select('user_content.created_at as enrolled_at', 'contents.link', 'contents.name', 'contents.desc', 'contents.id') // Select all fields from both tables
            .where({
                'user_content.user_id': user.id,
                'user_content.interaction_type_id': 2,
            });



        return res.status(200).json({ 'clicked_list': result });

    } catch (error) {
        console.error(error)
        return res.status(500).json(error);
    }

}

const updateUserContent = async (req, res) =>{
    try{
        const user = req.user;
        const { content_id, action } = req.body; 

        const interaction = await knex('interaction_type').where('type',action).first();
        const content = await knex('contents').where('id',content_id).where('status',1).first();

        if(!interaction){
            return res.status(400).json({'message':'Invalid Action'});
        }
        if(!content_id){
            return res.status(400).json({'message':'Invalid Action'});
        }

        const exist = await knex('user_content').where('user_id',user.id).where('content_id',content.id).where('interaction_type_id',interaction.id).where('status',1).first();
        console.log(exist, !exist);
        if(!exist){
            await knex('user_content').insert({
                    'user_id': user.id,
                    'content_id': content_id,
                    'interaction_type_id': interaction.id,
                    'ip_address': req.ip || req.connection.remoteAddress
                });

            return res.status(201).json({
                'message': 'Success'
            })
        }

        return res.status(200).json({
            'message': 'Duplicated Request'
        })

        
    }catch(error){
        return res.status(500).json(error);
    }
}



module.exports = {
    getContents,
    getContentByVector,
    saveContentEnrollment,
    getContentEnrollment,
    getClickedContent,
    updateUserContent
};