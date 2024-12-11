// import { z, ZodError } from 'zod';

// const registerSchema = z.object({
//   username: z.string().min(5),
//   name: z.string().min(5),
//   password: z.string().min(6),
// });

// const formatZodErrors = (error: ZodError) => {
//   const issues = error.issues;
//   return issues.map((issue) => {
//     const field = issue.path[0];
//     const message = issue.message;
//     return `${field.charAt(0).toUpperCase() + field.slice(1)}: ${message}`;
//   }).join(', ');
// };
// const validate = (data: any) => {
//   try {
//     return registerSchema.parse(data);
//   } catch (error) {
//     if (error instanceof ZodError) {
//       throw formatZodErrors(error);
//     }
//     throw 'Terjadi kesalahan, silakan coba lagi.';
//   }
// };

// export {registerSchema, formatZodErrors, validate}