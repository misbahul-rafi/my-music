<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function index(){
        $data = Song::all();
        return view("music.index",[
            'title'=> 'Music',
            'data'=> $data
        ]);
    }
    public function dashboard(){
        $data = Song::all();
        return view("music.dashboard",[
            'title'=> 'Music',
            'songs'=> $data
        ]);
    }
}
