'use client'
import Link from "next/link";
import { useRouter } from 'next/navigation';
import { useState } from "react";
import { signIn } from "next-auth/react";

const Login = () => {
  const router = useRouter();
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    const result = await signIn("credentials", {
      username,
      password,
      redirect: false,
    });
    console.log(result)

    if (result?.error) {
      setError(result.error);
    } else {
      router.push("/profile");
    }
  };

  return (
    <div className="border m-auto max-w-[512px] w-4/5 p-7 mt-10 form rounded-lg">
      {/* <TestEncrypt/> */}
      <h1 className="text-3xl font-bold text-center">Login</h1>
      <form onSubmit={handleSubmit} className="flex flex-col p-4 gap-4">
        <div className="flex flex-col gap-2">
          <label htmlFor="username" className="text-sm font-medium">Username</label>
          <input
            type="text"
            placeholder="Username"
            value={username}
            onChange={(e) => setUsername(e.target.value)}
            required
            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-[#6EC207] text-black"
          />
        </div>

        <div className="flex flex-col gap-2">
          <label htmlFor="password" className="text-sm font-medium">Password</label>
          <input
            type="password"
            placeholder="Password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-[#6EC207] text-black"
          />
        </div>

        {error && <p className="text-red-500 text-sm italic">{error}</p>}
        <div className="flex justify-end mt-4">
          <button type="submit" className="border px-7 py-2 rounded-md bg-[#6EC207] text-white">
            Login
          </button>
        </div>
      </form>
      <p className="text-sm">
          Don’t have an account? <Link href="/register">Click Here to Register</Link>
        </p>
    </div>
  );
}

export default Login;
