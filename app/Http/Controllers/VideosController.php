<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use Cloudder;
use App\User;
use App\Video;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideosController extends Controller
{
    public function videoCategories($category)
    {
        $category = str_replace('_', ' ', $category);

        $videos = Video::where('category', '=', $category)->paginate(12);

        return view('landing', ['videos' => $videos]);
    }

    public function playback($id)
    {
        $video = Video::find($id);

        return view('playback', ['video' => $video]);
    }

    public function addVideo(Request $request)
    {
        $this->validate($request, [
           'title' => 'required|unique:videos',
            'category' => 'required',
            'url' => 'required',
            'description' => 'required',
        ]);

        $userID = Auth::user()->id;

        Video::create([
            'user_id' => $userID,
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'description' => $request->input('description'),
            'url' => $request->input('url')
        ]);

        $videos = Video::where('user_id', Auth::user()->id)->paginate(12);

        return view('dashboard', ['videos' => $videos, 'upload_message' => 'The video was successfully added.', 'action' => 'video upload']);
    }

    public function getEditVideo($id)
    {
        $video = Video::find($id);

        return view('video_edit', ['video' => $video]);
    }

    public function postEditVideo(Request $request, $id)
    {
        $video = Video::find($id);
        $video->title = $request->input('title');
        $video->category = $request->input('category');
        $video->url = $request->input('url');
        $video->description = $request->input('description');
        $video->save();

        return view('video_edit', ['video' => $video, 'message' => 'You changes have been saved.']);
    }

    public function deleteVideo(Request $request)
    {
        $video = Video::find($request->input('id'));
        $videoTitle = $video->title;
        $video->delete();

        $videos = Video::orderBy('created_at', 'desc')->paginate(12);

        return view('dashboard', ['videos' => $videos, 'message' => 'The video "'.$videoTitle.'" was deleted.']);
    }
}