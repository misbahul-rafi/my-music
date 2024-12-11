@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <div class="flex justify-end mx-10 md:mx-20">
    <form action="" class="mr-4">
      <input type="text" name="search" placeholder="Cari catatan..."
        class="border w-72 bg-black border-text focus:border-title rounded-lg px-4 py-1 mr-4 transition-all duration-200 ease-in-out focus:outline-none text-text"
        value="{{ request('search') }}" autocomplete="off">
      <button type="submit" class=""><i class="bi bi-search text-2xl text-title"></i></button>
    </form>
    <a href="{{ route('notes.create') }}"><i class="bi bi-plus-square text-2xl text-title"></i></a>
  </div>
  <div class="mt-10">
    <div class="mt-10">
      @if ($notes->isEmpty())
        <p>
          {{ request('search') ? 'Tidak ada catatan yang cocok dengan pencarian.' : 'Tidak ada catatan yang ditemukan.' }}
        </p>
      @else
        <div class="flex flex-wrap gap-6 justify-center">
          @foreach ($notes as $note)
            <a href="{{ route('notes.show', $note->id) }}"
              class=" w-72 p-3 rounded-lg bg-gradient-to-b from-[#203A43] to-[#000000]">
              <h5 class="mb-2 text-xl font-bold tracking-tight text-title">{{ $note->title }}</h5>
              <p class="text-text">{{ Str::limit($note->content, 100) }}</p>
            </a>
          @endforeach
        </div>
      @endif
    </div>
  @endsection
