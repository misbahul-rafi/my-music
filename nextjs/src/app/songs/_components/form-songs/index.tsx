'use client'

import { useRef, useState, MouseEventHandler } from "react";
import { Song } from "@/types";
import { useCreateSong, useUpdateSong } from "@/utils/useSongs";
import Notification from "@/components/notifications";

interface FormProps {
  song?: Song,
  songLyrics?: string,
  onClose: () => void,
}

const FormSong = ({ song, onClose, songLyrics }: FormProps) => {
  const overlay = useRef(null)
  const [succeed, setSucceed] = useState<boolean>(false)
  const [textLyrics, setTextLyrics] = useState<string>(songLyrics || '')
  const [songData, setSongData] = useState<Song>(song || {
    id: 0,
    title: '',
    artist: '',
    fileName: '',
    userId: '',
    youtubeUrl: '',
    duration: 0,
  });
  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSongData({ ...songData, [e.target.name]: e.target.value });
  };
  const handleChangeText = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
    setTextLyrics(e.target.value);
  };

  const close: MouseEventHandler = (e) => {
    if (e.target === overlay.current) {
      onClose()
    }
  }

  const handleSuccess = () => {
    setSucceed(true)
    setTimeout(() => {
      setSucceed(false)
      onClose()
    }, 2000)
  }
  // eslint-disable-next-line react-hooks/rules-of-hooks
  const mutateSong = !song ? useCreateSong(handleSuccess) : useUpdateSong(handleSuccess);
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    mutateSong.mutate({
      songData,
      textLyrics
    });
  };

  return (
    <div className={`modal`}
      ref={overlay}
      onClick={close}>
      <div className="w-[520px] m-auto circle rounded-lg p-5">
        <h1 className="text-4xl text-center my-5">{!song ? "Create" : "Update"} Song</h1>
        <form onSubmit={handleSubmit} className="flex flex-col p-4 gap-4">
          <div className="flex flex-col mb-2">
            <label htmlFor="title" className="text-sm font-medium">Title</label>
            <input
              type="text"
              placeholder="Title of the song"
              name='title'
              value={songData?.title}
              onChange={handleChange}
              required
              className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-[#6EC207] text-black"
            />
          </div>
          <div className="flex flex-col mb-2">
            <label htmlFor="artist" className="text-sm font-medium">Artists</label>
            <input
              type="text"
              placeholder="Artists"
              name='artist'
              value={songData?.artist}
              onChange={handleChange}
              required
              className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-[#6EC207] text-black"
            />
          </div>
          <div className="flex flex-col mb-2">
            <label htmlFor="youtubeUrl" className="text-sm font-medium">YouTube URL</label>
            <input
              type="text"
              placeholder="YouTube URL"
              name='youtubeUrl'
              value={songData?.youtubeUrl}
              onChange={handleChange}
              required
              disabled={!song ? false : true}
              className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-[#6EC207] text-black"
            />
          </div>
          <div className="flex flex-col mb-2">
            <label htmlFor="textLyrics" className="text-sm font-medium">Lyric</label>
            <textarea
              placeholder="Lyrics"
              name='textLyrics'
              value={textLyrics}
              onChange={handleChangeText}
              className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-[#6EC207] text-black"
            />
          </div>

          <div className="flex justify-end mt-4 gap-3">
            <button type={'button'} className="border w-32 py-1 rounded-md bg-[#333333] text-white" onClick={onClose}>Cancel</button>
            <button
              type="submit"
              disabled={mutateSong.isPending}
              className="border w-32 py-1 rounded-md bg-[#E95420] text-white">
              {mutateSong.isPending ? (
                <div className="loader mx-auto"></div>
              ) : (
                <p>{!song ? "Create" : "Update"}Song</p>
              )}
            </button>
          </div>
        </form>
        <p className="text-sm text-red-500">{mutateSong.error && mutateSong.error.message}</p>
      </div>
      {succeed && <Notification type="success" message="Success Added Song" />}
    </div>
  );
}

export default FormSong;