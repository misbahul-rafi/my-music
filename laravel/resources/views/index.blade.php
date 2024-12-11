@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <div>
    <h1 class="text-title text-3xl text-center py-4 circle">Welcom To My Personal Tools</h1>
    <section class="flex justify-between mx-10 md:mx-64">
      <a href="{{ route('notes.index') }}">
        <i class="bi bi-journal text-9xl block mt-10 feat-card p-5 rounded-lg "></i>
      </a>
      <a href="{{ route('music.index') }}">
        <i class="bi bi-music-note-beamed text-9xl block mt-10 feat-card p-5 rounded-lg"></i>
      </a>
      <a href="{{ route('notes.index') }}">
        <i class="bi bi-journal text-9xl block mt-10 feat-card p-5 rounded-lg"></i>
      </a>
    </section>
  </div>
@endsection
