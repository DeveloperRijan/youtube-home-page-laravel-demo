<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaLibraryController extends Controller
{
    /**
     * Get Media Library page
     * @return View
     */
    public function mediaLibrary(Request $request){
        $media = Media::orderBy('created_at', 'desc')->get();
        return view('index',compact('media'));
    }
}
