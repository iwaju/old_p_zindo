<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;
use App\Models\MediaAlbum;

class MediaAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        dd(Route::currentRouteName());
        $albums = MediaAlbum::with('Images')->get();
        
        return view('admin.media.photo.album.index', compact('albums'));
    }


    /**
     * Show the form for creating a new resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $media_type = $request->get('id_type');

        return view('admin.media.album.create', compact('media_type'));
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = ['name' => 'required'];

        $input = ['name' => null];

        //Validator::make($input, $rules)->passes(); // true

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
          // return Redirect::route('create_album_form') ;
          return redirect()->route('albums.create ')->withErrors($validator)->withInput();
        }

        $mediaType = $request->get('media_type');
        $mediaRoute = $mediaType.'s.index';
        
        MediaAlbum::create(array(
          'name' => $request->get('name'),
          'description' => $request->get('description'),
          'type' => $mediaType,
        ));

        return redirect()->route($mediaRoute);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $current_album = MediaAlbum::where(['id'=>$id])->with('Images')->get()->first();

        $albums = MediaAlbum::with('Images')->get();
       //dd($gol->images);
        return view('admin.media.photo.album.show', compact('current_album','albums', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MediaAlbum::findOrFail($id);
        $media_type = $data->type;
        
        return view('admin.media.album.edit', compact('data','media_type'));

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
        
        $validator = Validator::make($request->All(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $album = MediaAlbum::find($id);
        $album->name = $request->name;
        $album->description = $request->description;
        $album->save();

        $currentAlbumRoute = $album->type.'s-albums';
        //dd($currentAlbumRoute);

        return redirect()->route($currentAlbumRoute, ['id'=>$album->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album = MediaAlbum::find($id);
        $type = $album->type;
        $album->delete();

        if('photo' == $type){ return redirect()->route('photos.index'); }
        if('video' == $type){ return redirect()->route('videos.index'); }
        if('audio' == $type){ return redirect()->route('audios.index'); }

        return redirect('panel/admin');
    }

    /**
     * Display a listing of photo Album.
     *
     * @return \Illuminate\Http\Response
     */
    public function photoIndex()
    {
        dd(Route::currentRouteName());
        $albums = MediaAlbum::with('Images')->get();
        
        return view('admin.media.photo.album.index', compact('albums'));
    }

    public function missingMethod($parameters=[])
    {
        return Redirect::route('photo-album.index');
    }
}
