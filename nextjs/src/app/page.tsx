import FormSearch from "@/components/form-search/FormSearch";
import Link from "next/link";
import { FaMusic, FaDownload } from "react-icons/fa";
import { RiPlayListFill } from "react-icons/ri";

export default function Home() {
  return (
    <div className="">
      <header className="">
        <h1 className="text-4xl text-center my-5">Welcome to Your Tools</h1>
        <FormSearch />
      </header>
      <section className="flex gap-3 max-w-[720px] m-auto justify-center mt-12">
        <Link href={'songs'}>
          <FaMusic className="text-9xl p-4 bg-green-600 rounded-lg"/>
        </Link>
        <Link href={'songs'}>
          <RiPlayListFill className="text-9xl p-4 bg-green-600 rounded-lg"/>
        </Link>
        <Link href={'downloader'}>
          <FaDownload className="text-9xl p-4 bg-green-600 rounded-lg"/>
        </Link>
      </section>
    </div>
  );
}
