import truncateText from "@/utils/truncateText";
import convertTime from "@/utils/convertTime";
import Link from "next/link";
import { Song } from "@/types";

const SongCard = ({songs}: {songs: Song[]}) => {
  return (
    <div>
      <div className="flex gap-3 flex-wrap justify-center flex-col lg:flex-row">
        {songs.length > 0 ? (
          songs.map(song => (
            <Link key={song.id} href={`/songs/${song.id}`} passHref>
            <div className="border-white border w-full lg:w-72 px-3 py-1 rounded-lg">
              <h3 className="text-lg">{truncateText(song.title, 20)}</h3>
              <span className="flex flex-row justify-between">
                <p className="text-sm">{truncateText(song.artist, 20)}</p>
                <p className="text-sm">{convertTime(song.duration)}</p>
              </span>
            </div>
            </Link>
          ))
        ) : (
          <p>No songs found.</p>
        )}
      </div>
    </div>
  )
}

export default SongCard