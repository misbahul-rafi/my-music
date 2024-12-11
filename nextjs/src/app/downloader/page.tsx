'use client'
import React, { useState } from "react";
import { useDownloadSong } from '@/utils/useSongs';

const Downloader = () => {
  const [formData, setFormData] = useState({
    title: "",
    youtubeUrl: "",
  });

  const { mutate, isPending, isError, error, isSuccess, data } = useDownloadSong(() => {
    setFormData({
      title: "",
      youtubeUrl: "",
    });
  });

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }));
  };
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    mutate(formData);
  };

  return (
    <div>
      <form
        onSubmit={handleSubmit}
        className="w-[450px] flex flex-col mx-auto gap-2"
      >
        <section>
          <label htmlFor="title">Title</label>
          <input
            type="text"
            placeholder="Artist - Title of the song"
            name="title"
            required
            autoComplete="off"
            value={formData.title}
            onChange={handleInputChange}
            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-[#6EC207] text-black"
          />
          <label htmlFor="youtubeUrl">Youtube URL</label>
          <input
            type="text"
            placeholder="Youtube URL"
            name="youtubeUrl"
            required
            autoComplete="off"
            value={formData.youtubeUrl}
            onChange={handleInputChange}
            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-[#6EC207] text-black"
          />
        </section>
        <section className="flex justify-end">
          <button
            type="submit"
            className="border w-32 py-1 rounded-md bg-[#E95420] text-white"
            disabled={isPending}
          >
            {isPending ? "Downloading..." : "Download"}
          </button>
        </section>
      {isError && <p className="text-red-500">{error?.message}</p>}
      {isSuccess && <p className="text-green-500">{data?.message}</p>}
      </form>
    </div>
  );
};

export default Downloader;
