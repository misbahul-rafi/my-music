"use client";

import { useSession } from "next-auth/react";

const ProfileClient = () => {
  const { data: session } = useSession();

  console.log(session)
  if (!session) return <p>Loading...</p>;

  return (
    <div>
      <h1>Profil</h1>
      <p>Nama: {session?.user?.name || ""}</p>
    </div>
  );
}

export default ProfileClient