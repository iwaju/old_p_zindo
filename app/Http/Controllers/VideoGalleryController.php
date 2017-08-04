<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;
use App\Models\VideoGallery;
use App\Models\MediaAlbum;
use Illuminate\Support\Facades\Auth;
use App\Helper;
use Image;

class VideoGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media_type = 'video';
        $albums = MediaAlbum::where(['type'=>$media_type])->with('Videos')->get();
        //dd($albums[0]->videos);
        return view('admin.media.video.index', compact('albums', 'media_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       $album_id = $request->get('id_type') ? $request->get('id_type') : $request->get('id');
        
        $media_type = MediaAlbum::where(['id'=>$album_id])->first()->type;
        
        $albums = MediaAlbum::where(['type'=>$media_type])->get();

        return view('admin.media.video.create', compact('albums', 'media_type', 'album_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
          'title' => 'required|unique:videos_gallery,title',
          'album' => 'required|numeric|exists:media_albums,id',
          'video'=>'required|url|unique:videos_gallery,url'
        ];

        $album_id = $request->get('album');
        $input = ['album' => null];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->route('videos.create', ['id' => $album_id])->withErrors($validator)->withInput();
        }

        $newVideo = VideoGallery::create([
          'album_id'=> $request->get('album'),
          'title' => $request->get('title'),
          'description' => $request->get('description'),
          'url' => $request->get('video'),
        ]);

        return redirect()->route('videos.show',['id'=>$newVideo->id])->with('success', 'misc.upload_succes');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = VideoGallery::findOrFail($id);
        $album = MediaAlbum::findOrFail($video->album_id);
        
        return view('admin.media.video.watch', compact('album','video')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function album(Request $request, $id=null)
    {

        if(null == $id){ $id = $request->get('id_type');} 

         $current_album = MediaAlbum::where(['id'=>$id])->with('Videos')->get()->first();
         $medias = $current_album->videos;

         $albums = MediaAlbum::where(['type'=>$current_album->type])->with('Videos')->get();

         return view('admin.media.video.show', compact('current_album','albums','medias'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = VideoGallery::find($id);
        $album = $video->album_id;
        $video->delete();
        return redirect()->route('videos-albums',['id'=>$album]);
    }

    public function missingMethod($parameters=[])
    {
        return Redirect::route('videos-album.index');

    }
}
