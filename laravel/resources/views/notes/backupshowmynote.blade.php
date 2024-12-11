@extends('main')
@section('content')
{{-- {{ Breadcrumbs::render('notes.show', $note) }} --}}
  <div class="w-9/12 m-auto mt-3 py-4 px-5 circle">
    <section class="flex justify-end gap-5">
      <button class="button px-12 py-1 text-title rounded-lg hover:bg-hover transition duration-200">
        Edit
      </button>
      <button class="button px-12 py-1 text-title rounded-lg hover:bg-hover transition duration-200">
        Delete
      </button>
    </section>
    <h1 class="text-title mb-3">{{ $note->title }}</h1>
    <p class="text-text">{{ $note->content }}</p>
  </div>
@endsection
