@php
  $fileName = "3-1729357777"
@endphp
@extends('main')
@section('title')
  {{ $title }}
@endsection
@section('content')
  <h1 class="text-title text-3xl text-center py-4 circle">Music</h1>
  
  <audio id="audioPlayer" controls>
    <source src="http://localhost:5000/get-song?fileName={{$fileName}}" type="audio/mpeg">
    Your browser does not support the audio element.
  </audio>
  
  <div id="metadata" class="metadata mt-4 text-center"></div>
  <div id="lyrics" class="lyrics mt-4 text-center"></div>
  
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const audioPlayer = document.getElementById("audioPlayer");
      const lyricsContainer = document.getElementById("lyrics");
      const metadataContainer = document.getElementById("metadata");
  
      // Memuat file LRC
      fetch("http://localhost:5000/lyrics?fileName={{$fileName}}")
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
        })
        .then(data => {
          const lines = data.split('\n');
          const lyrics = [];
          let title = '';
          let artist = '';
          let album = '';
  
          // Parsing lirik dan metadata
          lines.forEach(line => {
            const metadataMatch = line.match(/^\[(ti|ar|al): (.+?)\]/);
            const lyricMatch = line.match(/\[(\d{2}):(\d{2})\.(\d{2})\](.*)/);
  
            // Menangani metadata
            if (metadataMatch) {
              const tag = metadataMatch[1];
              const value = metadataMatch[2];
              if (tag === 'ti') title = value;
              else if (tag === 'ar') artist = value;
              else if (tag === 'al') album = value;
            }
  
            // Menangani lirik
            if (lyricMatch) {
              const minutes = parseInt(lyricMatch[1]);
              const seconds = parseInt(lyricMatch[2]);
              const milliseconds = parseInt(lyricMatch[3]);
              const text = lyricMatch[4].trim();
              lyrics.push({ time: (minutes * 60 + seconds + milliseconds / 100), text: text });
            }
          });
  
          // Menampilkan metadata
          metadataContainer.innerHTML = `<strong>${title}</strong><br>Artis: ${artist}<br>Album: ${album}`;
  
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
          lyricsContainer.innerHTML = "Lirik tidak tersedia.";
        });
    });
  </script>
  
@endsection
