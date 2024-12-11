<form action="" class="mr-4">
  <input type="text" name="search" placeholder="Search Songs, Artist or Playlist..."
    class="border w-72 bg-black border-text focus:border-title rounded-lg px-4 py-1 mr-4 transition-all duration-200 ease-in-out focus:outline-none text-text"
    value="{{ request('search') }}" autocomplete="off">
  <button type="submit" class=""><i class="bi bi-search text-2xl text-title"></i></button>
</form>