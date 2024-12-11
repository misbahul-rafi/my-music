<nav class="bg-gradient-to-b from-[#000000] to-[#434343] flex justify-between items-end px-4">
  <a href="{{ url('/') }}" class="text-xl py-4 font-bold text-title">
    Personal Tools
  </a>
  <div class="relative" id="user-menu-toggle">
    <ul class="flex space-x-4">
      @guest
        <a href="{{ route('login') }}">
          <i class="bi bi-person-circle text-title text-xl"></i>
        </a>
      @else
        <div class="px-10">
          <span class="text-gray-200 cursor-pointer">{{ Auth::user()->name }}</span>
          <div id="user-menu"
            class="absolute hidden rounded-lg bg-[#31363F] right-0 w-48 z-50 cursor-pointer">
            <a href="{{ route('profile') }}" class="block w-full text-left px-4 py-2 text-text hover:bg-hover rounded-lg">Profile</a>
            <a href="{{ route('notes.dashboard') }}"
              class="block w-full text-left px-4 py-2 text-text hover:bg-hover">Notes</a>
            <a href="{{ route('music.dashboard') }}"
              class="block w-full text-left px-4 py-2 text-text hover:bg-hover">Music</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="block w-full text-left px-4 py-2 text-text hover:bg-hover rounded-lg">Logout</button>
            </form>
          </div>
        </div>
      @endguest
    </ul>
  </div>
</nav>

<script>
  var userMenuToggle = document.getElementById('user-menu-toggle');
  var userMenu = document.getElementById('user-menu');

  userMenuToggle.addEventListener('mouseenter', function() {
    userMenu.classList.remove('hidden');
  });

  userMenuToggle.addEventListener('mouseleave', function() {
    userMenu.classList.add('hidden');
  });
</script>
