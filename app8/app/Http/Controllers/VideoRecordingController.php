<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use ProtoneMidea\laravelFFMpeg\support\FFMpeg;
use FFMpeg;

class VideoRecordingController extends Controller
{
    //
    public function index(){
        // $submitText = NULL;
        return view('./');

        // return view('video');
    }

    public function store(Request $request){
        // dd($request);
        $file = tap($request->file('video'))->store('videos');
        $filename = pathinfo($file->hashName(), PATHINFO_FILENAME);

        // dd($filename);
        FFMpeg::fromDisk("local")
        ->open("videos/".$file->hashName())
        ->export()
        ->toDisk('local')
        ->inFormat(new \FFMpeg\Format\Video\x264('libmp3lame', 'libx264'))
        ->save('converted_videos/'.$filename.'.mp4');
        
        return response()->json([
            'status'=> 'success'
        ]);
    }

    public function __invoke(Request $request)
    {
        FFMpeg::open($request->file('video'));
    }
}
