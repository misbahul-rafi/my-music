@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <div class="circle w-4/5 md:w-1/2 mx-auto mt-10 p-6 rounded-lg shadow-custom-primary">
    <p></p>
    <header class="mb-6 text-center">
      <h2 class="text-2xl font-bold text-title">{{$song['title']}}</h2>
      <p class="text-sm">{{$song['artist']}}</p>
    </header>

    <form action="" method="POST">
      @csrf
      <div class="mb-4">
        <label for="text_lyrics" class="block text-sm font-medium text-text">Lyrics</label>
        <textarea name="text_lyrics" id="text_lyrics" rows="15"
          class="mt-1 block w-full p-2 border border-title rounded-lg focus:ring focus:ring-[#b5c6e0] transparant-input text-text">{{ old('lyrics', $lyrics ?? '') }}</textarea>
        @error('text_lyrics')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 text-title rounded-lg hover:bg-hover transition duration-200">
          Add Song
        </button>
      </div>
    </form>
  </div>
@endsection
