const express = require('express');
const multer = require('multer');
const knex = require('knex')(require('./knexfile')); // Your Knex configuration file
const path = require('path');

const cors = require('cors');
app.use(cors());

const app = express();
const port = 8080;

// Configure Multer for file uploads
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, 'uploads/');
  },
  filename: (req, file, cb) => {
    cb(null, Date.now() + path.extname(file.originalname)); // Use a unique filename
  },
});

const upload = multer({ storage: storage });

// Middleware to parse JSON bodies
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Create the "uploads" directory if it doesn't exist
const fs = require('fs');
const uploadDir = 'uploads';
if (!fs.existsSync(uploadDir)) {
  fs.mkdirSync(uploadDir);
}

// GET all content
app.get('/api/content', async (req, res) => {
  try {
    const content = await knex('content').select('*');
    res.json(content);
  } catch (error) {
    res.status(500).json({ message: 'Error fetching content', error });
  }
});

// GET a specific content item by ID
app.get('/api/content/:id', async (req, res) => {
  try {
    const content = await knex('content').where('id', req.params.id).first();
    if (content) {
      res.json(content);
    } else {
      res.status(404).json({ message: 'Content not found' });
    }
  } catch (error) {
    res.status(500).json({ message: 'Error fetching content', error });
  }
});

// POST to create new content
app.post('/api/content', upload.single('media'), async (req, res) => {
  try {
    const { title, description, body, media_type } = req.body;
    const media_url = req.file ? req.file.path : null; // Save the media URL if a file is uploaded

    const newContent = await knex('content').insert({
      title,
      description,
      body,
      media_type,
      media_url,
    });

    res.status(201).json({ message: 'Content created successfully', id: newContent[0] });
  } catch (error) {
    res.status(500).json({ message: 'Error creating content', error });
  }
});

// PUT to update content
app.put('/api/content/:id', upload.single('media'), async (req, res) => {
  try {
    const { title, description, body, media_type } = req.body;
    const media_url = req.file ? req.file.path : null; // Save the new media URL if a file is uploaded

    const updatedContent = await knex('content')
      .where('id', req.params.id)
      .update({
        title,
        description,
        body,
        media_type,
        media_url,
      });

    if (updatedContent) {
      res.json({ message: 'Content updated successfully' });
    } else {
      res.status(404).json({ message: 'Content not found' });
    }
  } catch (error) {
    res.status(500).json({ message: 'Error updating content', error });
  }
});

// DELETE content
app.delete('/api/content/:id', async (req, res) => {
  try {
    const deletedContent = await knex('content').where('id', req.params.id).del();
    if (deletedContent) {
      res.json({ message: 'Content deleted successfully' });
    } else {
      res.status(404).json({ message: 'Content not found' });
    }
  } catch (error) {
    res.status(500).json({ message: 'Error deleting content', error });
  }
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
