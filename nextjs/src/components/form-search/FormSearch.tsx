

const FormSearch = ({className}:{className?: string}) => {
  return (
    <form className={className}>
      <label htmlFor="voice-search" className="sr-only">Search</label>
      <div className="relative w-full">
        <input type="text" id="voice-search" className="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Songs, Playlist and Notes..." required />
      </div>
      {/* <button type="submit" className="inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white to-bottom rounded-lg border border-green-600">
        <svg className="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
          <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
        </svg>Search
      </button> */}
    </form>
  )
}

export default FormSearch