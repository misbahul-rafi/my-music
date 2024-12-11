@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <h2 class="text-2xl font-bold text-center text-title mt-20">Login</h2>
  <form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="space-y-4 max-w-xl m-auto mt-6">
      <div>
        <label for="username" class="text-sm font-medium text-title">Username</label>
        <input type="text" name="username" id="username" required
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
          placeholder="Your Username">
        @error('username')
          <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" id="password" required
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
          placeholder="********">
      </div>
      <div>
        <button type="submit"
          class="w-full bg-gradient-to-b from-[#16222A] to-[#3A6073] text-title px-4 py-2 rounded hover:bg-[#16222A] hover:bg-none">Login</button>
      </div>
      <div class="text-center mt-4 text-sm text-text">
        <p>Belum memiliki akun? <a href="{{ route('register') }}" class="text-title hover:text-white">Daftar di sini</a>
        </p>
      </div>
    </div>
  </form>
@endsection
