<a href="{{ route('song.play', ['songid' => $song->id]) }}" class="circle w-64 border rounded-lg px-3">
  <h4>{{ Str::limit($song['title'], 20) }}</h4>
  <span class="flex justify-between">
    <p class="text-sm">{{ $song['artist'] }}</p>
    <p class="text-sm">{{ gmdate($song['duration'] >= 3600 ? 'H:i:s' : 'i:s', $song['duration']) }}</p>
  </span>
  <p>{{$song['file_name']}}</p>
</a>