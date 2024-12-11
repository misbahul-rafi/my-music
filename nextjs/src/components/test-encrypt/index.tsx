
import React, { useState } from 'react';
import * as bcrypt from 'bcrypt-ts';

const TestEncrypt = () => {
  const [password, setPassword] = useState('');
  const [hash, setHash] = useState('');
  const [output, setOutput] = useState('')
  const [isValid, setIsValid] = useState<boolean | null>(null)

  const hashPassword = async () => {
    try {
      const hashedPassword = await bcrypt.hash(password, 10);
      setOutput(hashedPassword);
      setIsValid(null); 
    } catch (error) {
      console.error("Error hashing password:", error);
    }
  };

  const checkPassword = async () => {
    try {
      const isMatch = await bcrypt.compare(password, hash);
      setIsValid(isMatch);
    } catch (error) {
      console.error("Error comparing password and hash:", error);
    }
  };


  return (
    <div className="text-black bg-gray-500 gap-2">
      <section className="">
        <span className='flex justify-between gap-2'>
          <label htmlFor="password">Password</label>
          <input type="text" name="password" onChange={(e) => setPassword(e.target.value)} />
        </span>
        <span className='flex justify-between gap-2'>
          <label htmlFor="hashed">Hash Passowrd</label>
          <input type="text" name="hashed" onChange={(e) => setHash(e.target.value)} />
        </span>
      </section>
      <section className='flex gap-2'>
        <button className="bg-green-300 px-3 py-1" onClick={hashPassword}>Hash</button>
        <button className="bg-green-300 px-3 py-1" onClick={checkPassword}>Compare</button>
      </section>
      <section className='h-24 2-72 bg-white'>
        <h1>Output</h1>
        <p className="w-full break-words">{output}</p>
      </section>
      <section>
        <h1>Valid</h1>
        <p>Output : </p>
        <p>{isValid === null ? "Not checked" : isValid ? "Valid" : "Invalid"}</p>
      </section>
    </div>
  )
}

export default TestEncrypt