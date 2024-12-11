'use client'
import FormSearch from "@/components/form-search/FormSearch"
import SongCard from "./_components/song-card";
import FormSong from "./_components/form-songs";
import { MouseEventHandler, useState } from "react";
import { useSongs } from "@/utils/useSongs";
import { useSession } from "next-auth/react";
import Notification from "@/components/notifications";
import { MdAddCircle } from "react-icons/md";

const Songs = () => {
  const [visibleCreateForm, setVisibleCreateSong] = useState<boolean>(false)
  const { data, isLoading, error } = useSongs();
  const session = useSession()
  const [notif, setNotif] = useState(false)

  if (isLoading) {
    return <div>Loading...</div>;
  }

  if (error instanceof Error) {
    return <div>Error: {error.message}</div>;
  }
  const addSongsClick: MouseEventHandler = () => {
    if (session.status === "authenticated") {
      return setVisibleCreateSong(true)
    }
    setNotif(true)
    setTimeout(() => {
      setNotif(false)
    }, 2000)
  }
  return (
    <div className="p-4">
      <header>
        <h1 className="text-4xl text-center my-5">Song Collections</h1>
        <div className="flex justify-center">
          <FormSearch className="flex w- items-center w-[450px]" />
          <button onClick={addSongsClick}
            className="inline-flex items-center ms-2 text-sm font-medium"
          >
            <MdAddCircle size={40} />
          </button>
          {visibleCreateForm && <FormSong onClose={() => setVisibleCreateSong(false)} />}
        </div>
      </header>
      <div className="flex flex-col md:flex-row items-start mt-10 gap-2">
        <section className="bg-gray-500 w-full md:w-1/2 rounded-lg p-1">
          <h1 className="text-3xl">All Songs</h1>
          <SongCard songs={data} />
        </section>
        <aside className="w-full md:w-1/2 h-[720px] bg-gray-500 rounded-lg">
          <section>
            <h1 className="text-3xl">All Albums</h1>
          </section>
        </aside>
      </div>
      {notif && <Notification type="error" message="Please Login" />}
    </div>
  )
}
export default Songs