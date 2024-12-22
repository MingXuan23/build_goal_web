/**
 * @param {import("knex").Knex} knex
 * @returns {Promise<void>}
 */
exports.seed = async function (knex) {
  // List of organizations to insert
  const orgs = [
    {
      name: 'Xbug Sdn Bhd',
      desc: 'Company of the xbug',
      status: '1',
      address: 'X bug company address',
      state: 'Melaka',
      email: 'xbug@xbug.online',
      org_type: 'Company',
      payment_key: 'key',
    },
  ];

  // Iterate over each organization
  return Promise.all(
    orgs.map(async (org) => {
      // Check if the organization already exists
      let existingOrg = await knex('organization')
        .select('*')
        .where('name', org.name)
        .first();

      let organizationId;

      if (!existingOrg) {
        // Insert the organization and get the inserted ID
        const [newOrgId] = await knex('organization').insert(org).returning('id');
        organizationId = newOrgId;
      } else {
        organizationId = existingOrg.id;
      }

      // Find users with roles containing [1, 2, 3, 4] and with names starting with 'user_'
      const users = await knex('users')
        .where(function () {
          this.whereRaw(`JSON_CONTAINS(role, '1', '$')`)
              .orWhereRaw(`JSON_CONTAINS(role, '2', '$')`)
              .orWhereRaw(`JSON_CONTAINS(role, '3', '$')`)
              .orWhereRaw(`JSON_CONTAINS(role, '4', '$')`);
        })
        .andWhere('name', 'like', 'user_%');

      // Iterate over each user and insert into 'organization_user' if not already associated
      await Promise.all(
        users.map(async (user) => {
          const existingOrgUser = await knex('organization_user')
            .where('user_id', user.id)
            .andWhere('organization_id', organizationId)
            .first();

          if (!existingOrgUser) {
            let roles;
            try {
              roles = JSON.parse(user.role);
            } catch (error) {
              console.error(`Error parsing roles for user ${user.id}:`, error);
              return;
            }
            //console.log(roles);
            // Insert each role associated with the user
            try{
              for (const role of roles) {
                await knex('organization_user').insert({
                  user_id: user.id,
                  organization_id: organizationId,
                  role_id: role,
                });
              }
            }catch(error){
              await knex('organization_user').insert({
                user_id: user.id,
                organization_id: organizationId,
                role_id: roles,
              });
            }
          }
        })
      );
    })
  );
};
