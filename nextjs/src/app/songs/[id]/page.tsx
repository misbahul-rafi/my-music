import PlayerSong from '@/app/songs/_components/player-song';
import Actions from '../_components/player-song/_components/actions';
import { notFound } from 'next/navigation';
import { Song } from '@/types';
import { getServerSession } from 'next-auth';

interface ViewSongProps {
  params: Promise<{ id: string }>;
}
const ViewSong = async ({ params }: ViewSongProps) => {
  const session  = await getServerSession()
  const id = (await params).id
  const songResponse = await fetch(`${process.env.NEXT_PUBLIC_API_BASE_URL}/api/songs/${id}`)
  if (!songResponse.ok) {
    return notFound()
  }
  const song:Song = await songResponse.json()
  const lyricsUrl = `${process.env.NEXT_PUBLIC_FLASK_API}/lyrics?fileName=${song.fileName}`
  const lyricsResponse = await fetch(lyricsUrl)
  const lyrics = await lyricsResponse.text()

  return (
    <div className='flex flex-col lg:flex-row justify-around gap-10'>
      <section className='circle rounded-lg w-full md:w-[756px] mx-auto lg:mx-0'>
        <PlayerSong song={song} textLyrics={lyrics}/>
        {session?.user?.id === song.userId && <Actions song={song} songLyrics={lyrics}/>}

      </section>
      <aside className='circle w-full lg:w-[400px] px-10 py-3 rounded-lg'>
        <h1 className='text-2xl font-bold'>Related Songs</h1>
      </aside>
    </div>
  );
};

export default ViewSong;
