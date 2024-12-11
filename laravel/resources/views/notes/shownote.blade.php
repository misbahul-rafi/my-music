@extends('main')
@section('content')
  {{-- {{ Breadcrumbs::render('notes.show', $note) }} --}}
  <div class="w-9/12 relative m-auto mt-3 py-4 px-5 circle">
    @if ($note['user_id'] == auth()->id())
    <div id="dotoptions" class="flex justify-center items-center block rounded-full h-10 w-10 hover:bg-hover absolute top-0 right-1">
      <i class="bi bi-three-dots-vertical text-2xl"></i>
    </div>
    <div id="options" class="hidden absolute right-0 top-10 flex flex-col w-32 rounded-lg bg-[#31363F]">
      <a class="block w-full text-left px-4 py-2 text-text hover:bg-hover rounded-lg">Edit</a>
      <a class="block w-full text-left px-4 py-2 text-text hover:bg-hover rounded-lg">Delete</a>
    </div>
    @endif
    <h1 class="text-title mb-3">{{ $note->title }}</h1>
    <p class="text-text">{{ $note->content }}</p>
  </div>
  <script>
    const dotoptions = document.getElementById('dotoptions')
    const options = document.getElementById('options')
    dotoptions.addEventListener('click', () =>{
      options.classList.remove('hidden')
      console.log("Tes");
    })
    document.addEventListener('click', (event) => {
      if (!dotoptions.contains(event.target) && !options.contains(event.target)) {
        options.classList.add('hidden');
      }
    });
  </script>
@endsection