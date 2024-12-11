'use client'
import Link from 'next/link';
import { useState } from 'react';
import { useRouter } from 'next/navigation';


export default function Register() {
  const [formData, setFormData] = useState({ name: '', username: '', password: '' });
  const [error, setError] = useState('');
  const router = useRouter();

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {

      const res = await fetch('/api/auth/register/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ ...formData }),
      });

      if (res.ok) {
        router.push('/login');
      }else {
        const errorData = await res.json()
        setError(errorData.error)
      }
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    } catch (err: any) {
      throw new Error("Internal Server: ", err)
    }
  };
  return (
    <div className='w-[450px] mx-auto mt-24'>
      <h1 className='text-3xl text-center font-bold'>Register</h1>
      <form onSubmit={handleSubmit} className="flex flex-col p-4 gap-4">
        <div className="flex flex-col mb-2">
          <label htmlFor="username" className="text-sm font-medium">Username</label>
          <input
            type="text"
            placeholder="Your Username"
            name='username'
            onChange={handleChange}
            required
            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-[#6EC207] text-black"
          />
        </div>
        <div className="flex flex-col mb-2">
          <label htmlFor="name" className="text-sm font-medium">Name</label>
          <input
            type="text"
            placeholder="Your name"
            name='name'
            onChange={handleChange}
            required
            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-[#6EC207] text-black"
          />
        </div>

        <div className="flex flex-col mb-2">
          <label htmlFor="password" className="text-sm font-medium">Password</label>
          <input
            type="password"
            placeholder="Your Password"
            name='password'
            onChange={handleChange}
            required
            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-[#6EC207] text-black"
          />
        </div>

        {error && <p className='text-red-500 text-sm'>{error}</p>}
        <div className="flex justify-end mt-4">
          <button type="submit" className="border px-7 py-2 rounded-md bg-[#6EC207] text-white">
            Login
          </button>
        </div>
        <p className="text-sm">
          Alredy have an account? <Link href={'/login'}>Click Here to Login</Link>
        </p>
      </form>
    </div>
  );
}
