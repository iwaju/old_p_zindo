<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;
use App\Models\AudioGallery;
use App\Models\MediaAlbum;

class AudioGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media_type = 'audio';
        $albums = MediaAlbum::where(['type'=>'audio'])->with('Audios')->get();

        return view('admin.media.audio.index', compact('albums', 'media_type'));
    }

    /**
     * Show the form for creating a new audio.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $album_id = $request->get('id_type');

        $media_type = MediaAlbum::where(['id'=>$album_id])->first()->type;
        
        $albums = MediaAlbum::where(['type'=>$media_type])->get();

        return view('admin.media.audio.create', compact('albums', 'media_type', 'album_id'));
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
          'album' => 'required|numeric|exists:media_albums,id',
          'title'=>'required',
          'audio'=>'required|file'
        ];

        $album_id = $request->get('album');
        $input = ['album' => null];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->route('audios.create', ['id' => $album_id])->withErrors($validator)->withInput();
        }


        $album_name = MediaAlbum::find($album_id)->name;
        $audio = $request->file('audio');
        $random_name = str_random(8);

        $audioDestPath = 'public/gallery/audio/'.$album_name;

        $audioExtension = $audio->getClientOriginalExtension();

        $audioName=$random_name.'_'.$album_name.'_audio.'.$audioExtension;
        
        $audioStatus = $audio->move($audioDestPath, $audioName);
        if($audioStatus){
        	$newAudio = AudioGallery::create([
	          'title' => $request->get('title'),
	          'description' => $request->get('description'),
	          'url' => $audioName,
	          'album_id'=> $request->get('album')
          ]);

        	return redirect()->route('audios.show',['id'=>$newAudio->id]);

        }

        return redirect()->route('audios.create')->withErrors('please retry')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $audio = AudioGallery::findOrFail($id);
        $album = MediaAlbum::findOrFail($audio->album_id);
        
        return view('admin.media.audio.play', compact('album','audio')); 
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
     * Move an audio to another Album.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        $rules = array(

          'new_album' => 'required|numeric|exists:media_albums,id',
          'audio'=>'required|num,nnnuueric|exists:audios_gallery,id'

        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

          return redirect()->route('audio-album.index');
        }

        $new_album = $request->get('new_album');
        $audio = AudioGallery::find($request->get('audio'));
        $audio->album_id = $new_album;
        $audio->save();
        return redirect()->route('audio-album.show', ['id'=>$new_album]);
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

         $current_album = MediaAlbum::where(['id'=>$id])->with('Audios')->get()->first();

         $albums = MediaAlbum::where(['type'=>$current_album->type])->with('Audios')->get();

         return view('admin.media.audio.show', compact('current_album','albums'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $audio = AudioGallery::findOrFail($id);
        $album = $audio->album_id;
        $audio->delete();
        return redirect()->route('audios-albums',['id'=>$album]);
    }
}
