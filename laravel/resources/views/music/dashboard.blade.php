@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <h1 class="text-title text-3xl text-center py-4 circle">My Music</h1>
  <div class="flex justify-end mx-10 md:mx-20">
    <form action="" class="mr-4">
      <input type="text" name="search" placeholder="Search Songs, Artist or Playlist..."
        class="border w-72 bg-black border-text focus:border-title rounded-lg px-4 py-1 mr-4 transition-all duration-200 ease-in-out focus:outline-none text-text"
        value="{{ request('search') }}" autocomplete="off">
      <button type="submit" class=""><i class="bi bi-search text-2xl text-title"></i></button>
    </form>
    <div class="relative" id="music-menu-toggle">
      <i class="bi bi-plus-square text-2xl text-title bg-white"></i>
      <div id="music-menu" class="absolute hidden rounded-lg bg-[#31363F] right-0 w-48 z-50 cursor-pointer">
        <a href="{{ route('song.create') }}"
          class="block w-full text-left px-4 py-2 text-text hover:bg-hover rounded-lg">Songs</a>
        <a href=""
          class="block w-full text-left px-4 py-2 text-text hover:bg-hover">Playlist</a>
      </div>
    </div>
  </div>
  <div class="flex gap-2 flex-wrap justify-around mt-10">
    @foreach ($songs as $song)
      <x-songcard :song="$song" />
    @endforeach
  </div>

  <script>
    var musicMenuToggle = document.getElementById('music-menu-toggle');
    var musicMenu = document.getElementById('music-menu');

    musicMenuToggle.addEventListener('click', function() {
      musicMenu.classList.remove('hidden');
    });

    document.addEventListener('click', function(event) {
      if (!musicMenu.contains(event.target) && !musicMenuToggle.contains(event.target)) {
        musicMenu.classList.add('hidden');
      }
    });
  </script>
@endsection
