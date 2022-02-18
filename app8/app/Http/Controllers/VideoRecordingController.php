<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ProtoneMidea\laravelFFMpeg\support\FFMpeg;

class VideoRecordingController extends Controller
{
    //
    public function index(){
        // $submitText = NULL;
        return view('./');

        // return view('video');
    }

    public function store(Request $request){
        $file = tap($request->file('video'))->store('videos');
        $filename = pathinfo($file->hasName(), PATHINFO_FILENAME);
        // dd($filename);

        dd($filename);
        FFMpeg::fromDisk("Local")
        ->open("videos/".$file->hasName())
        ->export()
        ->toDisk()("Local")
        ->inFormat(new \FFMpeg\Format\Video\x264('libm3lane', 'libx264'))
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
