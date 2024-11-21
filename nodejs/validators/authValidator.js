const z = require('zod');

const registerSchema = z.object({
  name: z.string().nonempty('Full name is required'), 
  password: z.string().min(6, 'Password must be at least 6 characters long'),
  telno: z
  .string()
  .nonempty('Phone number is required')
  .regex(
    /^\+60\d{9,11}$/,
    'Phone number must start with +60 and contain 9 to 11 digits'
  ),
  email: z.string().email('Invalid email format'), 
  // role: z.string().nonempty('Role is required'), 
  state: z.string().nonempty('State is required'), 
  address: z.string().nonempty('Address is required'), 
});


const loginSchema = z.object({
  email: z.string().email('Invalid email address'),
  password: z.string().min(6, 'Password must be at least 6 characters long'),
  device_token: z.string()
});


const forgetPasswordSchema = z.object({
  email: z.string().email('Invalid email format'),
});

const changePasswordSchema = z.object({
  oldPassword: z.string().min(6, 'Old Password must be at least 6 characters long'),
  newPassword: z.string().min(6, 'New Password must be at least 6 characters long'),
});
module.exports = { registerSchema, loginSchema, forgetPasswordSchema, changePasswordSchema };
