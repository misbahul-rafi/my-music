<!-- resources/views/components/form-login.blade.php -->
<form action="{{ route('login.post') }}" method="POST">
    @csrf
    <div class="space-y-4">
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
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
        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Login</button>
      </div>
      <div class="text-center mt-4">
        <p class="text-sm">Belum memiliki akun? <a href="{{ route('register') }}" class="text-blue-500">Daftar di sini</a>
        </p>
      </div>
    </div>
  </form>
