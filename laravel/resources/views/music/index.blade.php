@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <h1 class="text-title text-3xl text-center py-4 circle ">Music</h1>

  <x-searchinput/>

  <div class="flex flex-col md:flex-row m-3 gap-3 justify-center">
    <section class="min-h-64 w-full md:w-5/12">
      <a href="{{route('songs.index')}}" class="border-b text-2xl text-title border-white mb-5 block">Songs</a>
      <div class="flex gap-2 flex-wrap justify-around">
        @foreach ($data as $song)
          <x-songcard :song="$song"/>
        @endforeach
      </div>
    </section>
    <section class="min-h-64 w-full md:w-5/12 ">
      <h3 class="border-b text-2xl text-title border-white mb-5">Playlists</h3>
    </section>
  </div>
@endsection
