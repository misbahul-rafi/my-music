@extends('main')
@section('title')
{{$title}}
@endsection
@section('content')
  <h2 class="text-2xl font-bold text-center text-title mt-16">Registrasi Pengguna</h2>

  @if (session('success'))
    <div class="bg-green-500 text-white text-center py-2 my-2 rounded">
      {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="bg-red-500 text-white text-center py-2 my-2 rounded">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{ route('register') }}" method="POST" class="mt-6 m-auto max-w-xl space-y-4">
    @csrf
    <div>
      <label for="username" class="block text-sm font-medium text-text">Username</label>
      <input type="text" name="username" id="username" required
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
        placeholder="Your Username">
      @error('username')
        <span class="text-red-500 text-sm">{{ $message }}</span>
      @enderror
    </div>
    <div>
      <label for="password" class="block text-sm font-medium text-text">Password</label>
      <input type="password" name="password" id="password" required
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
        placeholder="********">
    </div>
    <div>
      <label for="password_confirmation" class="block text-sm font-medium text-text">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" id="password_confirmation" required
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
        placeholder="********">
    </div>
    <div>
        <button type="submit" class="w-full bg-gradient-to-b from-[#16222A] to-[#3A6073] text-title px-4 py-2 rounded hover:bg-[#16222A] hover:bg-none">Login</button>
    </div>
    <div class="text-center mt-4 text-sm text-text text-sm">
      <p>Sudah memiliki akun? <a href="{{ route('login') }}" class="text-title hover:text-white">Login di sini</a></p>
    </div>
  </form>
@endsection
