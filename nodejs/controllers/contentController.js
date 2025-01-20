require("dotenv").config();

const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV])

const axios = require('axios');

/**
 * Fetches collection details from the API.
 */


const HOST_URL = process.env.VECTOR_HOST;// Replace with your actual host URL
const API_KEY = process.env.VECTOR_API_KEY;


function getTopAttributes(values, topCount = 3) {
    // Create an array of indices and values
    const reference = new Map([
        [0, "Education and Self Improvement"],
        [1, "Entertainment and Health Fitness"],
        [2, "Financial and Business"],
        [3, "Technology and Digital"],
        [4, "Fashion and Art"],
        [5, "Production and Construction"],
        [6, "Transportation and Logistics"],
        [7, "Social and Personal Services"]
    ]);

    console.log(values);
    const indexedValues = values.map((value, index) => ({ index, value }));

    // Sort the array in descending order of values
    indexedValues.sort((a, b) => b.value - a.value);

    // Extract the top attributes based on the sorted values
    const topAttributes = indexedValues
        .slice(0, topCount) // Get the top `topCount` items
        .map(item => reference.get(item.index)); // Map indices to category names

    return topAttributes;
}

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
    const paidfilters = [
        createPaidFilter(3),
        
    ];

    const filters = [
        createCommonFilter(7),
    ]

    const microLearningFilter = [createLearningFilter(5)];
    //console.log(filters,microLearningFilter);

    try {
        // Send both regular filters and micro-learning filters concurrently
        const [paidResponse, regularResponse, microLearningResponse] = await Promise.all([
            axios.post(`${HOST_URL}/collections/content_collection/points/search/batch`, { searches: paidfilters }, {
                headers: {
                    'api-key': API_KEY,
                    'Content-Type': 'application/json'
                }
            }),
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

        paidResponse.data?.result?.forEach((list) => {
            list.forEach((item) => {
                if (item.id) {

                    content_ids.add(item.id);
                }
            });
        });

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

       

        const contentIdsArray = Array.from(content_ids);

        // Fetch additional random rows from the database
        const rows = await knex('contents')
            .whereNotIn('id', contentIdsArray) // Ensure column name matches your table schema
            .orderByRaw('RAND()') // Use 'RANDOM()' for PostgreSQL
            .limit(5);
        
        // Combine IDs from the API responses and database query
        const finalContentIds = [ ...contentIdsArray,...rows.map(row => row.id)];
        
        // Return the final list of content IDs
        return finalContentIds;

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

      
        const learning_appurl = 'https://xbug.online/view-content-link/';
        contentList.forEach((content) => {
            content.link = learning_appurl + content.id + '/' + content.name.replace(/ /g, '~');
        });

        var values =  typeof user_vector.values === 'string' ? JSON.parse(user_vector.values || '{}') : user_vector.values;
        //console.log(values,user_vector.values)
        const recommendations = getTopAttributes(values);

        return res.status(200).json({ contentList: contentList, microlearning_id: m_id.id ,recommendations:recommendations });

    } catch (error) {
        console.error(error);
        return res.status(500).json(error);
    }
};

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
            const content = await knex('contents')
            .select('id','link','name')
            .where('id', card.content_id)
            .first();
            const learning_appurl = 'https://xbug.online/view-content-link/';
            content.link = learning_appurl + content.id + '/' + content.name.replace(/ /g, '~');
            // If the record already exists, handle accordingly (e.g., return a response or message)
            return res.status(200).json({ message: 'Enrollment already exists', link:content.link });
        }

        // Proceed to insert the new record if no existing record is found
        var insert = await knex('user_content').insert({
            'user_id': user.id,
            'interaction_type_id': 3,
            'content_id': card.content_id,
            'ip_address': req.ip,
            'verification_code': verification_code,
        });

        const result = await knex('contents')
        .select('category_weight')
        .where('id', card.content_id)
        .first();
    
        const like_list = [];
        if (result) {
            const value = typeof result.category_weight === 'string' 
                ? JSON.parse(result.category_weight || '{}') 
                : result.category_weight;
        
            // Use `push` to add the value to the array (not `add`, which is not valid for arrays)
            like_list.push(value);
        }
    
       
        const user_vector = await knex('user_vector').select('*').where({ 'user_id': user.id }).first();
        const values = user_vector.values;
        const parseValues = typeof values === 'string' ? JSON.parse(values || '{}') : values;

        let vector = calUserVector(parseValues, like_list, 0.5, 2);
        await knex('user_vector').where({ 'user_id': user.id }).update({
            'values': JSON.stringify(vector)
        });

        const content = await knex('contents')
        .select('id','link','name')
        .where('id', card.content_id)
        .first();

        const learning_appurl2 = 'https://xbug.online/view-content-link/';
        
        content.link = learning_appurl2 + content.id + '/' + content.name.replace(/ /g, '~');
    

        return res.status(201).json({ message: 'Enrollment inserted successfully', url:content.link  });

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
            .select('user_content.created_at as enrolled_at', 'contents.link', 'contents.name', 'contents.desc', 'contents.id','user_content.updated_at') // Select all fields from both tables
            .where({
                'user_content.user_id': user.id,
                'user_content.interaction_type_id': 3,
            }).orderBy('user_content.updated_at','desc')
            .limit(30);


        return res.status(200).json({ 'history': result });
    } catch (error) {
        console.error(error)
        return res.status(500).json(error);
    }

}

const getClickedContent = async (req, res) => {

    try {
        const user = req.user;

        var type = await knex('interaction_type').where('type', 'clicked').first();
        const result = await knex('user_content')
            .join('contents', 'user_content.content_id', '=', 'contents.id')
            .select(
                'user_content.created_at as enrolled_at',
                'contents.link',
                'contents.name',
                'contents.desc',
                'contents.id',
                'user_content.updated_at'
            )
            .where({
                'user_content.user_id': user.id,
                'user_content.interaction_type_id': type.id,
            })
            .orderBy('user_content.updated_at', 'desc') // Explicitly specify the sort direction
            .limit(30);

            const learning_appurl = 'https://xbug.online/view-content-link/';
            result.forEach((content) => {
                content.link = learning_appurl + content.id + '/' + content.name.replace(/ /g, '~');
            });


        return res.status(200).json({ 'clicked_list': result });

    } catch (error) {
        console.error(error)
        return res.status(500).json(error);
    }

}

const updateUserContent = async (req, res) => {
    try {
        const user = req.user;
        const { content_id, action } = req.body;

        const interaction = await knex('interaction_type').where('type', action).first();
        const content = await knex('contents').where('id', content_id).where('status', 1).first();

        if (!interaction) {
            return res.status(400).json({ 'message': 'Invalid Action' });
        }
        if (!content_id) {
            return res.status(400).json({ 'message': 'Invalid Action' });
        }

        const exist = await knex('user_content').where('user_id', user.id).where('content_id', content.id).where('interaction_type_id', interaction.id).where('status', 1).first();
        //console.log(exist, !exist);
        if (!exist) {
            await knex('user_content').insert({
                'user_id': user.id,
                'content_id': content_id,
                'interaction_type_id': interaction.id,
                'ip_address': req.ip || req.connection.remoteAddress
            });
            console.log(action);
            if(action == 'clicked'){
                const result = await knex('contents')
                .select('category_weight')
                .where('id', content_id)
                .first();
            
                const like_list = [];
                if (result) {
                    const value = typeof result.category_weight === 'string' 
                        ? JSON.parse(result.category_weight || '{}') 
                        : result.category_weight;
                
                    // Use `push` to add the value to the array (not `add`, which is not valid for arrays)
                    like_list.push(value);
                }
            
               
                const user_vector = await knex('user_vector').select('*').where({ 'user_id': user.id }).first();
                const values = user_vector.values;
                const parseValues = typeof values === 'string' ? JSON.parse(values || '{}') : values;
        
                let vector = calUserVector(parseValues, like_list, 0.1, 2);
                await knex('user_vector').where({ 'user_id': user.id }).update({
                    'values': JSON.stringify(vector)
                });

                console.log(vector);
            }
            return res.status(201).json({
                'message': 'Success'
            })
        } else {

            await knex('user_content').where({
                'user_id': user.id,
                'content_id': content_id,
                'interaction_type_id': interaction.id,

            }).update({

                'desc': new Date()

            });

        }

        return res.status(200).json({
            'message': 'Duplicated Request'
        })


    } catch (error) {
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