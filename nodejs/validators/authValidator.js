const z = require('zod');

const registerSchema = z.object({
  name: z.string().nonempty('Full name is required'), 
  password: z.string().min(6, 'Password must be at least 6 characters long'),
  telno: z
    .string()
    .min(9, 'Phone number must be at least 9 digits long')
    .regex(/^\d+$/, 'Phone number must contain only numbers'),
  email: z.string().email('Invalid email format'), 
  // role: z.string().nonempty('Role is required'), 
  state: z.string().nonempty('State is required'), 
  address: z.string().nonempty('Address is required'), 
});


const loginSchema = z.object({
  email: z.string().email('Invalid email address'),
  password: z.string().min(6, 'Password must be at least 6 characters long'),
});


const forgetPasswordSchema = z.object({
  email: z.string().email('Invalid email format'),
});

const changePasswordSchema = z.object({
  oldPassword: z.string().min(6, 'Old Password must be at least 6 characters long'),
  newPassword: z.string().min(6, 'New Password must be at least 6 characters long'),
});
module.exports = { registerSchema, loginSchema, forgetPasswordSchema, changePasswordSchema };
