@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <div class="circle max-w-xl mx-auto mt-10 p-6 rounded-lg shadow-custom-primary">
    <h2 class="text-2xl font-bold mb-6 text-title text-center">Update Song</h2>

    <form action="" method="POST">
      @csrf
      <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-text">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $song['title'] ?? '') }}"
          class="mt-1 block w-full p-2 border border-title rounded-lg focus:ring focus:ring-[#b5c6e0] transparant-input text-title"
          value="{{ $song['title'] }}">
        @error('title')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="artist" class="block text-sm font-medium text-text">Artist</label>
        <input type="text" name="artist" id="artist" value="{{ old('artist', $song['artist'] ?? '') }}"
          class="mt-1 block w-full p-2 border border-title rounded-lg focus:ring focus:ring-[#b5c6e0] transparant-input text-title">
        @error('artist')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="youtube_url" class="block text-sm font-medium text-text">Youtube URL</label>
        <input type="text" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $song['youtube_url'] ?? '') }}" disabled
          class="mt-1 block w-full p-2 border border-title rounded-lg opacity-40 text-title">
        @error('youtube_url')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="text_lyrics" class="block text-sm font-medium text-text">Lyric</label>
        <textarea name="text_lyrics" id="text_lyrics" rows="10"
          class="mt-1 block w-full p-2 border border-title rounded-lg focus:ring focus:ring-[#b5c6e0] transparant-input text-text">{{ old('text_lyrics', $lyrics ?? '') }}</textarea>
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
