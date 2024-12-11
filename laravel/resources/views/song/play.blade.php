@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  @if (session('success'))
    <x-notif-success :message="'Song Updated'" />
  @endif
  <h1 class="text-title text-3xl text-center py-4 circle">{{ $song['title'] }}</h1>
  <div id="test" class="w-4/5 mx-auto">
    @if ($song['user_id'] == auth()->id())
      <div class="relative">
        <div id="threedots" class="flex justify-end">
          <i class="bi bi-three-dots-vertical text-3xl"></i>
        </div>
        <div id="options" class="hidden absolute right-0 top-10 flex flex-col w-32 rounded-lg bg-[#31363F]">
          <button>
            <a href="{{ route('song.edit', ['songid' => $song['id']]) }}"
              class="block w-full text-left px-4 py-2 text-text hover:bg-hover rounded-lg">Edit</a>
          </button>
          <form action="{{ route('songs.delete', ['songid' => $song['id']]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="block w-full text-left px-4 py-2 text-text hover:bg-hover rounded-lg">Delete</button>
          </form>
        </div>
      </div>
      <script>
        const threedots = document.getElementById('threedots')
        const options = document.getElementById('options')
        threedots.addEventListener('click', () => {
          options.classList.remove('hidden')
          console.log("Tes");
        })
        document.addEventListener('click', (event) => {
          if (!threedots.contains(event.target) && !options.contains(event.target)) {
            options.classList.add('hidden');
          }
        });
      </script>
    @endif
    <img src="{{ env('FLASK_API_URL') . '/thumbnails?fileName=' . $song['file_name'] }}" alt="{{ $song['title'] }}"
      class="w-96 mx-auto">

    <div id="lyrics" class="lyrics mt-4 text-center h-36 text-3xl">.....</div>
    <div id="customAudioPlayer">
      <section class="flex justify-between px-24 items-center">
        <button id="playPrevBtn" class="hover:bg-hover p-3 rounded-full">
          <i class="text-4xl bi bi-chevron-left"></i>
        </button>
        <button id="playPauseBtn" class="hover:bg-hover p-3 rounded-full">
          <i id="playIcon" class="text-4xl bi bi-pause-fill"></i>
        </button>
        <button id="playAfterBtn" class="hover:bg-hover p-3 rounded-full">
          <i class="text-4xl bi bi-chevron-right"></i>
        </button>
      </section>

      <div id="seekContainer" class="mt-4 relative w-full h-2 bg-gray-300 rounded-full">
        <div id="nowDurations" class="h-2 bg-black rounded-full w-0 absolute top-0 left-0"></div>
      </div>

      <div class="flex justify-between text-sm mt-2">
        <span id="currentTime">0:00</span>
        <span id="duration">{{ gmdate($song['duration'] >= 3600 ? 'H:i:s' : 'i:s', $song['duration']) }}</span>
      </div>
    </div>
  </div>

  <audio id="audioPlayer" hidden autoplay>
    <source src="{{ env('FLASK_API_URL') }}/songs?fileName={{ $song['file_name'] }}" type="audio/mpeg">
    Your browser does not support the audio element.
  </audio>

  <div>
    @foreach ($relatedSongs as $nextSong)
      <p>{{ $nextSong['title']." ID " . $nextSong['id'] }}</p>
    @endforeach
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const audioPlayer = document.getElementById("audioPlayer");
      const lyricsContainer = document.getElementById("lyrics");
      const audio = document.getElementById('audioPlayer');
      const playPauseBtn = document.getElementById('playPauseBtn');
      const playIcon = document.getElementById('playIcon');
      const seekBar = document.getElementById('nowDurations');
      const seekContainer = document.getElementById('seekContainer');
      const currentTimeLabel = document.getElementById('currentTime');
      const durationLabel = document.getElementById('duration');

      const API_URL = "{{ env('FLASK_API_URL') }}/lyrics?fileName={{ $song['file_name'] }}";
      fetch(API_URL)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
        })
        .then(data => {
          const lines = data.split('\n');
          const lyrics = [];


          // Parsing lirik dan metadata
          lines.forEach(line => {
            const lyricMatch = line.match(/\[(\d{2}):(\d{2})\.(\d{2})\](.*)/);

            // Menangani lirik
            if (lyricMatch) {
              const minutes = parseInt(lyricMatch[1]);
              const seconds = parseInt(lyricMatch[2]);
              const milliseconds = parseInt(lyricMatch[3]);
              const text = lyricMatch[4].trim();
              lyrics.push({
                time: (minutes * 60 + seconds + milliseconds / 100),
                text: text
              });
            }
          });

          // Menampilkan lirik sesuai waktu
          audioPlayer.ontimeupdate = () => {
            const currentTime = audioPlayer.currentTime;
            const currentLine = lyrics.find((line, index) => {
              return line.time <= currentTime && (!lyrics[index + 1] || lyrics[index + 1].time > currentTime);
            });
            if (currentLine) {
              lyricsContainer.innerHTML = currentLine.text; // Menampilkan lirik saat ini
            } else {
              lyricsContainer.innerHTML = ""; // Kosongkan jika tidak ada lirik yang cocok
            }
          };
        })
        .catch(error => {
          console.error("Error loading LRC file:", error);
          lyricsContainer.innerHTML =
            '@if ($song['user_id'] == auth()->id())<button class="button text-title text-xl px-3 py-"><a href="{{ route('song.edit', ['songid' => $song->id]) }}">Upload Lyric</a></button>@else No Lyrics @endif';
        });
      // Play/Pause Button
      playPauseBtn.addEventListener('click', function() {
        if (audio.paused) {
          audio.play();
          playIcon.classList.remove('bi-play-fill');
          playIcon.classList.add('bi-pause-fill');
        } else {
          audio.pause();
          playIcon.classList.remove('bi-pause-fill');
          playIcon.classList.add('bi-play-fill');
        }
      });

      // Update seekbar as the audio plays
      audio.addEventListener('timeupdate', function() {
        const progress = (audio.currentTime / audio.duration) * 100;
        seekBar.style.width = progress + '%';
        currentTimeLabel.textContent = formatTime(audio.currentTime);
      });

      seekContainer.addEventListener('click', function(e) {
        const width = seekContainer.clientWidth;
        const clickX = e.offsetX;
        const duration = audio.duration;

        // Set audio currentTime based on the position clicked
        audio.currentTime = (clickX / width) * duration;
      });

      // Format time in minutes:seconds
      function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return minutes + ':' + (secs < 10 ? '0' : '') + secs;
      }
      audioPlayer.addEventListener("ended", function() {
        const relatedSongs = @json($relatedSongs);

        if (relatedSongs.length > 0) {
          // Ambil ID lagu pertama dari relatedSongs
          const nextSongId = relatedSongs[0].id;

          // Redirect ke route play untuk memutar lagu berikutnya
          window.location.href = `/songs/play/${nextSongId}`;
        } else {
          console.log("Tidak ada lagu terkait untuk diputar.");
        }
      });
      // audioPlayer.addEventListener("ended", function() {
      //   const relatedSongs = @json($relatedSongs);
      //   console.log(relatedSongs);
      //   currentSongIndex++;
      //   if (currentSongIndex < relatedSongs.length) {
      //     const nextSong = relatedSongs[currentSongIndex];
      //     audioPlayer.src = nextSong.getAttribute('data-url');
      //     audioPlayer.play();
      //     document.querySelector('.text-title').innerText = nextSong.getAttribute('data-title');
      //   }
      // });
    });
  </script>
@endsection
