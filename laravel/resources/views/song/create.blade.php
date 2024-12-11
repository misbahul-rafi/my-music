@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <div class="circle max-w-md mx-auto mt-10 p-6 rounded-lg shadow-custom-primary">
    <h2 class="text-2xl font-bold mb-6 text-title text-center">Add Song</h2>

    <form action="{{ route('song.store') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-text">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}"
          class="mt-1 block w-full p-2 border border-title rounded-lg focus:ring focus:ring-[#b5c6e0] transparant-input text-title">
        @error('title')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="artist" class="block text-sm font-medium text-text">Artist</label>
        <input type="text" name="artist" id="artist" value="{{ old('artist') }}"
          class="mt-1 block w-full p-2 border border-title rounded-lg focus:ring focus:ring-[#b5c6e0] transparant-input text-title">
        @error('artist')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="youtube_url" class="block text-sm font-medium text-text">Youtube URL</label>
        <input type="text" name="youtube_url" id="youtube_url" value="{{ old('youtube_url') }}"
          class="mt-1 block w-full p-2 border border-title rounded-lg focus:ring focus:ring-[#b5c6e0] transparant-input text-title">
        @error('youtube_url')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="lyrirc" class="block text-sm font-medium text-text">Lyric</label>
        <textarea name="lyrirc" id="lyrirc" rows="4"
          class="mt-1 block w-full p-2 border border-title rounded-lg focus:ring focus:ring-[#b5c6e0] transparant-input text-text">{{ old('lyrirc') }}</textarea>
        @error('lyrirc')
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
