@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <h1 class="text-title text-3xl text-center py-4 circle ">Songs</h1>

  <form action="" class="m-auto flex items-end">
    <input type="text" name="search" placeholder="Search Songs, Artist or Playlist..."
      class="border w-72 bg-black border-text focus:border-title rounded-lg px-4 py-1 mr-4 transition-all duration-200 ease-in-out focus:outline-none text-text"
      value="{{ request('search') }}" autocomplete="off">
    <button type="submit" class=""><i class="bi bi-search text-2xl text-title"></i></button>
  </form>

  <div class="flex flex-col md:flex-row m-3 gap-3 justify-center">
    <section class="min-h-64 w-full md:w-5/12">
      <div class="flex gap-2 flex-wrap justify-around">
        @foreach ($songs as $song)
          <x-songcard :song="$song" />
        @endforeach
      </div>
    </section>
  </div>
@endsection
