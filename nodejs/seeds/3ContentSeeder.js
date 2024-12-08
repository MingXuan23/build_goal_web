/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> } 
 */
exports.seed = async function(knex) {


    const contents = [
      {
        name: 'Microentrepreneuship:start with roti canai',
        desc: 'Learn how to start a successful roti canai business',
        link: null,
        content: "```***Introduction***Here I will teach u do make roti canai```***Sell it!***Find your neighbour and sell to them",
        enrollment_price: '0.00',
        status: 1,
        category_weight: null,
        content_type_id: await knex('content_types')
          .where('type', 'MicroLearning Resource')
          .select('id')
          .first()
          .then(result => result.id),
        place: null,
        participant_limit: null,
        state: null,
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: null,
        reason_phrase: 'APPROVED',
        first_date: null
      },
      {
        name: 'Online Course: Flutter Helper Course',
        desc: 'Comprehensive course on Flutter development',
        link: null,
        content: null,
        enrollment_price: 10.00,
        status: 1,
        category_weight: null,
        content_type_id: await knex('content_types')
          .where('type', 'Course and Training')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Recap Room, FTMK, UTeM',
        participant_limit: 100,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'APPROVED',
        first_date: new Date('2025-01-02').toISOString().slice(0, 19).replace('T', ' ')
      },
      {
        name: 'Event: Satria Car Boot Sale',
        desc: 'Community car boot sale event',
        link: null,
        content: null,
        enrollment_price: 20.00,
        status: 1,
        category_weight: null,
        content_type_id: await knex('content_types')
          .where('type', 'Micro Entrepreneurship')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Satria Cafe, UTeM',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'APPROVED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' ')
      },
      {
        name: 'Santuni Madani KPT@KSB',
        desc: 'Cleaning the local beach around Melaka',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        category_weight: JSON.stringify([0.291,0.082,0.122,0.122,0.114,0.999,0.177,0.999]),
        content_type_id: await knex('content_types')
          .where('type', 'Event')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Satria Cafe, UTeM',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'APPROVED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://www.mohe.gov.my/images/hebahan/sorotan_aktiviti/2024/09/2024-09-14-KSU-MADANI/2024-09-14-KSU-05.JPG',
      },
      {
        name: 'Mental Health Awareness Campaign',
        desc: 'Check your mental health',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        category_weight: JSON.stringify([0.999,0.241,0.104,0.104,0.873,0.084,0.077,0.845]),
        content_type_id: await knex('content_types')
          .where('type', 'Event')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Satria Cafe, UTeM',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'PENDING',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://cdn.prod.website-files.com/62dadf7d66e2fb7047b69c6d/640197e00a210b4792f9fb43_MHA%20graphic.svg',
      },

      {
        name: 'Public Speaking Course',
        desc: 'Improve your public speaking skills',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        category_weight: JSON.stringify([0.782,0.207,0.871,0.086,0.902,0.143,0.098,0.262]),
        content_type_id: await knex('content_types')
          .where('type', 'Course and Training')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Laman Hikmah UTeM',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'PENDING',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://static.vecteezy.com/system/resources/previews/005/206/188/non_2x/public-speaker-speaking-behind-the-podium-free-vector.jpg',
      },

      {
        name: 'Bakery 101',
        desc: 'Learn how to bake',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        category_weight: JSON.stringify([0.138,0.200,0.772,0.031,0.088,0.067,0.029,0.999]),
        content_type_id: await knex('content_types')
          .where('type', 'Course and Training')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Cafe UTeM',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'PENDING',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://chennaisamirta.com/wp-content/uploads/2019/05/chennais-amirta-baking-lab.jpg',
      },
      {
        name: 'Event Management Course',
        desc: 'Learn how to manage your own events',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        category_weight: JSON.stringify([0.483,0.136,0.999,0.280,0.302,0.217,0.090,0.159]),
        content_type_id: await knex('content_types')
          .where('type', 'Course and Training')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'FTMK UTeM',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'REJECTED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://i0.wp.com/eduspiral.com/wp-content/uploads/2018/11/event_management.jpg?fit=620%2C413&ssl=1',
      },
      {
        name: 'Preloved Books and Apparels',
        desc: 'Sell your preloved and unused things',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        category_weight: JSON.stringify([0.132,0.132,0.999,0.071,0.033,0.097,0.031,0.924]),
        content_type_id: await knex('content_types')
          .where('type', 'Event')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Tapak Niaga UTeM',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'REJECTED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://upload.wikimedia.org/wikipedia/en/f/fe/Preloved_logo.png',
      },
      {
        name: 'How to be a backend Software Engineer',
        desc: 'learn the foundation on becoming a successfull software engineer',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        //http://localhost:30000/api/vector/getVectorValue?values=[80,56,32,58,77,86,251,60,62,41,31,176,61,64,178]
        category_weight: JSON.stringify([0.495,0.117,0.308,0.999,0.285,0.070,0.041,0.232]),
        content_type_id: await knex('content_types')
          .where('type', 'Course and Training')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Dewan Seminar FTMK UTeM',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'REJECTED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://miro.medium.com/v2/resize:fit:1400/1*sHCJ7Pk_gKEdwi_iFk918w.png',
      },
      {
        name: 'Pasar Malam Mahasiswa UTeM',
        desc: 'Find opportunity to make side incomes by partcipating at the Pasar Malam',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        //http://localhost:30000/api/vector/getVectorValue?values=[254,215,88,195,258,191,252,30,234,122,43,255]
        category_weight: JSON.stringify([0.098,0.083,0.999,0.063,0.078,0.079,0.039,0.999]),
        content_type_id: await knex('content_types')
          .where('type', 'Job Offering')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Sasana Niaga UTeM',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'REJECTED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://pbs.twimg.com/media/DXHp4DsVoAECiDe.jpg'
      },
      {
        name: 'Program Cuci Kereta',
        desc: 'Participate in this program to earn some money',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        //http://localhost:30000/api/vector/getVectorValue?values=[162,235,116,195,92,258,122]
        category_weight: JSON.stringify([0.143,0.037,0.502,0.031,0.073,0.538,0.966,0.999]),
        content_type_id: await knex('content_types')
          .where('type', 'Job Offering')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Dewan Seminar FTMK UTeM',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'REJECTED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://assets.hmetro.com.my/images/articles/11hmbasuh1.transformed.jpg'
      },
      {
        name: 'Bengkel GitHub Desk',
        desc: 'Increase your development productivity by using GitHub',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        //http://localhost:30000/api/vector/getVectorValue?values=[80,54,32,57,58,59,77,251,41,31,257,176,178,61]
        category_weight: JSON.stringify([0.469,0.221,0.511,0.999,0.228,0.077,0.046,0.278]),
        content_type_id: await knex('content_types')
          .where('type', 'Course and Training')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Common Room FTMK',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'APPROVED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://blog.runcloud.io/wp-content/uploads/2021/06/what-is-github.png'
      },
      {
        name: 'Digital Marketing Tips: Promote Your Product Effectively!',
        desc: 'Learn how to promote your product online through this course',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        //http://localhost:30000/api/vector/getVectorValue?values=[80,32,175,190,258,77,191,252,67,224,78,36,257,243,245,143,255,64]
        category_weight: JSON.stringify([0.489,0.065,0.999,0.510,0.590,0.035,0.026,0.583]),
        content_type_id: await knex('content_types')
          .where('type', 'Course and Training')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Google Meet',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'APPROVED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://digitalcatalyst.in/blog/wp-content/uploads/2022/03/major-components-of-digital-marketing.png'
      },
      {
        name: 'Generate money from your home!!',
        desc: 'Get to know how you can make money just by staying at your home',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        //http://localhost:30000/api/vector/getVectorValue?values=[254,32,175,65,66,212,228,127,258,30,27,67,251,38,79,253,78,68,36,255,230]
        category_weight: JSON.stringify([0.269,0.160,0.999,0.105,0.979,0.045,0.138,0.553]),
        content_type_id: await knex('content_types')
          .where('type', 'MicroLearning Resource')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Google Meet',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'APPROVED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://p2pgallery.s3.eu-central-1.amazonaws.com/BLOG-FEATUREDIMAGE/how-to-make-money-from-home.webp'
      },
      {
        name: 'Earn money just by walking pets',
        desc: 'Earn your side income by helping people walk their pets',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        //http://localhost:30000/api/vector/getVectorValue?values=[168,258,88,251,200,112,241,89]
        category_weight: JSON.stringify([0.289,0.875,0.680,0.040,0.240,0.122,0.073,0.999]),
        content_type_id: await knex('content_types')
          .where('type', 'Job Offering')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Google Meet',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'APPROVED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://images.wagwalkingweb.com/media/daily_wag/blog_articles/hero/1642800424.549621/how-to-walk-bigger-dogs-on-dog-walks.png'
      },
      {
        name: 'Earn money just by walking pets',
        desc: 'Earn your side income by helping people walk their pets',
        link: 'https://xbug.online/',
        content: null,
        enrollment_price: 20.00,
        status: 1,
        //http://localhost:30000/api/vector/getVectorValue?values=[168,258,88,251,200,112,241,89]
        category_weight: JSON.stringify([0.289,0.875,0.680,0.040,0.240,0.122,0.073,0.999]),
        content_type_id: await knex('content_types')
          .where('type', 'Job Offering')
          .select('id')
          .first()
          .then(result => result.id),
        place: 'Google Meet',
        participant_limit: 20,
        state: JSON.stringify(['Melaka']),
        created_at: knex.fn.now(),
        updated_at: knex.fn.now(),
        closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
        reason_phrase: 'APPROVED',
        first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' '),
        image: 'https://images.wagwalkingweb.com/media/daily_wag/blog_articles/hero/1642800424.549621/how-to-walk-bigger-dogs-on-dog-walks.png'
      }
      
      

      



    ];
  
    return Promise.all(
      contents.map(content => {
        return knex('contents')
          .select('*')
          .where('name', content.name)
          .first()
          .then(existing => {
            if (!existing) {
              return knex('contents').insert(content);
            }
          });
      })
    );
  };