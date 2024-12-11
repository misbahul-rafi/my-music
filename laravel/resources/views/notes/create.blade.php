@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <div class="circle max-w-md mx-auto mt-10 p-6 rounded-lg shadow-custom-primary">
    <h2 class="text-2xl font-bold mb-6 text-title">Create Note</h2>

    <form action="{{ route('notes.store') }}" method="POST">
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
        <label for="content" class="block text-sm font-medium text-text">Content</label>
        <textarea name="content" id="content" rows="4"
          class="mt-1 block w-full p-2 border border-title rounded-lg focus:ring focus:ring-[#b5c6e0] transparant-input text-text">{{ old('content') }}</textarea>
        @error('content')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 text-title rounded-lg hover:bg-hover transition duration-200">
          Save Note
        </button>
      </div>
    </form>
  </div>
@endsection
