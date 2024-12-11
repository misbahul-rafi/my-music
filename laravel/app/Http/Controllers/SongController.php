<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class SongController extends Controller
{
    public function index(){
        $songs = Song::all();
        return view("song.index",[
            "title"=> "Songs",
            "songs"=> $songs
        ]);
    }
    public function playSong($songid)
    {
        $song = Song::find($songid);
        if ($song) {
            $relatedSongs = Song::where('id', '!=', $songid)->inRandomOrder()->limit(5) ->get();
    
            return view('song.play', [
                'title'=> $song->title,
                'song'=> $song,
                'relatedSongs' => $relatedSongs
            ]);
        }
        return redirect()->back()->with('error', 'Song Not Found');
    }
    public function edit(){
        $song = Song::find(request("songid"));
        $client = new Client();
        try {
            $response = $client->request("GET", env('FLASK_API_URL') . '/lyrics?fileName=' . $song['file_name']);
            $lyrics = $response->getStatusCode() == 200 ? $response->getBody()->getContents() : "";
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Cek apakah status code adalah 404
            if ($e->getResponse()->getStatusCode() == 404) {
                Log::warning("Lirik tidak ditemukan untuk file: " . $song['file_name']);
                $lyrics = ""; // Jika file tidak ditemukan, berikan nilai string kosong
            } else {
                // Tangani kesalahan lain jika diperlukan
                Log::error('Error occurred while fetching lyrics: ' . $e->getMessage());
                $lyrics = "Terjadi kesalahan saat mengambil lirik.";
            }
        } catch (\Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            $lyrics = "Terjadi kesalahan saat mengambil lirik.";
        }

        return view("song.edit",[
            "title"=> "Update Song",
            "song"=> $song,
            "lyrics"=> $lyrics
        ]);
    }
    public function create(){
        return view("song.create",[
            "title"=> "Add Song",
        ]);
    }

    public function store(Request $request)
    {
        Log::info("Berjalan...");
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:50',
            'artist' => 'required|string|max:50',
            'youtube_url' => 'required|url',
        ], [
            'title.required' => 'Title tidak boleh kosong.',
            'title.max' => 'Title tidak boleh lebih dari 50 karakter.',
            'artist.required' => 'Artist tidak boleh kosong.',
            'artist.max' => 'Artist tidak boleh lebih dari 50 karakter.',
            'youtube_url.required' => 'URL YouTube tidak boleh kosong.',
            'youtube_url.url' => 'URL YouTube harus format yang valid.',
        ]);
        Log::info("Berhasil mengambil title, artist dan url");
        
        
        // Buat HTTP client untuk berkomunikasi dengan Flask
        $client = new Client();
        try {
            Log::info("Mengirimkan request ke flask...");
            // Kirimkan request ke Flask API
            $response = $client->post(env('FLASK_API_URL').'/songs', [
                'json' => [
                    'url' => $request->youtube_url,
                    'userid' => auth()->id(),
                ]
            ]);
            
            Log::info('Response Status: ' . $response->getStatusCode());
            Log::info('Response Body: ' . $response->getBody());

            // Parsing response dari Flask
            $data = json_decode($response->getBody(), true);

            $song = Song::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'artist' => $request->artist,
                'file_name' => $data['file_name'],
                'duration' => $data['duration'],
                'youtube_url' => $request->youtube_url,
            ]);
    
            return redirect()->route('music.dashboard')->with('success', 'Song Added');
    
        } catch (\Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return view('errors.500', [
                'title'=> "Internal Server",
            ]);
        }
    }
    public function update(Request $request)
    {
        Log::info("Memulai proses update...");
        
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:50',
            'artist' => 'required|string|max:50',
        ], [
            'title.required' => 'Title tidak boleh kosong.',
            'title.max' => 'Title tidak boleh lebih dari 50 karakter.',
            'artist.required' => 'Artist tidak boleh kosong.',
            'artist.max' => 'Artist tidak boleh lebih dari 50 karakter.',
        ]);

        Log::info("Validasi selesai, melanjutkan update...");
        
        // Temukan lagu berdasarkan ID
        $song = Song::where('id', $request->songid)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $song->update([
            'title' => $request->title,
            'artist' => $request->artist,
        ]);
        if($request->text_lyrics != '') {
            try{
                $client = new Client();
                $response = $client->post(env('FLASK_API_URL').'/lyrics', 
                [
                    'json' => [
                        'text_lyrics' => $request->text_lyrics,
                        'file_name' => $song->file_name,
                    ]
                ]);
            }catch(\Exception $e){
                Log::error('Error occurred: ' . $e->getMessage());
                return view('errors.500', [
                    'title'=> "Internal Server",
                ]);
            }
        }
        return redirect()->route('song.play', ['songid' => $song->id])
        ->with('success', 'Lirik berhasil diperbarui.');

    }
    public function destroy()
    {
        $song = Song::where('id', request("songid"))
                    ->where('user_id', auth()->id())
                    ->firstOrFail();
    
        try {
            $client = new Client();
            $response = $client->delete(env('FLASK_API_URL') . '/songs', [
                'json' => [
                    'fileName' => $song->file_name
                ]
            ]);
            $responseBody = $response->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            if (isset($responseData['message']) && $responseData['message'] == "File Deleted") {
                $song->delete();
                Log::info("Songs ID " . $song->title . " Deleted from " . auth()->user()->username);
                return redirect()->route('songs.index')->with('success', 'Lagu berhasil dihapus.');
            }
    
        } catch (ModelNotFoundException $e) {
            Log::warning("Pengguna tidak diizinkan menghapus lagu ID: " . request("songid"));
            abort(403, 'Anda tidak diizinkan untuk menghapus lagu ini.');
        } catch (\Exception $e) {
            Log::error('Error while deleting songs: ' . $e->getMessage());
            return view('errors.500', [
                'title' => "Internal Server",
            ]);
        }
    }
    
}