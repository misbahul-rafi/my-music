@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <div>
    <section class="bg-cover bg-center h-48" style="background-image: url('https://via.placeholder.com/1200x400');">
    </section>
    <section>
      <h1 class="text-xl">{{ $user->name }}</h1>
      <p>{{ $user->username }}</p>
      <p>{{ $user->email }}</p>
    </section>
    <section class="flex gap-9 bg-green-500">
        <i class="bi bi-stickies-fill text-8xl"></i>
        <i class="bi bi-2-square text-8xl"></i>
        <i class="bi bi-3-square text-8xl"></i>
    </section>
  </div>
@endsection
