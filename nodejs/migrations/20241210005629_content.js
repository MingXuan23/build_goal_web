exports.up = function(knex) {
    return knex.schema
      .raw('DROP TABLE IF EXISTS content;')  // Drop the table if it exists
      .createTable('content', function(table) {
        table.bigIncrements('id').primary().unsigned();
        table.string('title').notNullable();
        table.text('description').nullable();
        table.text('body').nullable();
        table.string('media_type').notNullable();
        table.string('media_url').nullable();
        table.integer('thumbnail_id').unsigned().nullable();
        table.timestamps(true, true);  // Created at & Updated at
      });
  };
  
  exports.down = function(knex) {
    return knex.schema.dropTableIfExists('content');
  };
  