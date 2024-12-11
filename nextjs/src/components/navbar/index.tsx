"use client";
import { signOut, useSession } from "next-auth/react";
import Link from "next/link";
import { useState } from "react";

export default function Navbar() {
  const [isOpen, setIsOpen] = useState(false);
  const {status} = useSession()

  const toggleMenu = () => {
    setIsOpen(!isOpen);
  };

  const closeMenu = () => {
    setIsOpen(false);
  };

  return (
    <nav className="w-full to-bottom flex items-center justify-between p-4 lg:py-0 relative z-10">
      <h1 className="text-white font-bold">Personal Tools</h1>

      <div className="lg:hidden cursor-pointer z-10" onClick={toggleMenu}>
        <div
          className={`w-6 h-1 rounded-lg bg-white mb-1 transition-transform duration-300 ${isOpen ? "transform rotate-45 translate-y-2" : ""
            }`}
        ></div>
        <div
          className={`w-6 h-1 rounded-lg bg-white mb-1 transition-opacity duration-300 ${isOpen ? "opacity-0" : ""
            }`}
        ></div>
        <div
          className={`w-6 h-1 rounded-lg bg-white transition-transform duration-300 ${isOpen ? "transform -rotate-45 -translate-y-2" : ""
            }`}
        ></div>
      </div>

      <section
        className={`fixed top-12 right-0 h-full bg-green-600 w-2/5 transform ${isOpen ? "translate-x-0" : "translate-x-full"
          } transition-transform duration-300 lg:static lg:translate-x-0 lg:flex lg:w-auto lg:bg-transparent flex flex-col lg:flex-row lg:items-center p-4 lg:py-0`}
      >
        <Link href={"/"} className="p-4 text-white hover:bg-green-700 lg:hover:bg-transparent" onClick={closeMenu}>
          Home
        </Link>
        <Link href={'/songs'} className="p-4 text-white hover:bg-green-700 lg:hover:bg-transparent" onClick={closeMenu}>
          Songs
        </Link>
        <Link href={'/playlists'} className="p-4 text-white hover:bg-green-700 lg:hover:bg-transparent" onClick={closeMenu}>
          Playlists
        </Link>
        <Link href="/profile" className="p-4 text-white hover:bg-green-700 lg:hover:bg-transparent" onClick={closeMenu}>
          Profiles
        </Link>
        {status === 'authenticated' ? (
          <span onClick={() => signOut()} className="p-4 text-white hover:bg-green-700 lg:hover:bg-transparent">Logout</span>

        ) : (
          <Link href="/login" className="p-4 text-white hover:bg-green-700 lg:hover:bg-transparent" onClick={closeMenu}>
            Login
          </Link>
        )}
      </section>
    </nav>
  );
};
