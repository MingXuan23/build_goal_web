/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.createTable('content', function (table) {
      table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
      table.string('title').notNullable(); // Title of the content, required
      table.text('description').nullable(); // Description of the content
      table.text('body').nullable(); // Body of the content (text or HTML)
      table.string('media_type').nullable(); // Media type (image, video, etc.)
      table.string('media_url').nullable(); // URL or path to the uploaded media
      table.timestamps(true, true); // Created at & Updated at timestamps
    });
  };
  
  /**
   * @param { import("knex").Knex } knex
   * @returns { Promise<void> }
   */
  exports.down = function (knex) {
    return knex.schema.dropTableIfExists('content');
  };
  