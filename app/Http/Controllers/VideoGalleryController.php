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
          'album' => 'required|numeric|exists:media_albums,id',
          'video'=>'required|file'
        ];

        $album_id = $request->get('album');
        $input = ['album' => null];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->route('videos.create', ['id' => $album_id])->withErrors($validator)->withInput();
        }

        $album_name = MediaAlbum::find($album_id)->name;
        $vid = $request->file('video');
        $thumb = $request->file('thumbnail');

        $random_name = str_random(8);

        $vidDestPath = 'public/gallery/video/'.$album_name;
        //$thumbDestPath = 'public/gallery/video/thumbnail';

        $vidExtension = $vid->getClientOriginalExtension();
        //$thumbExtension = $thumb->getClientOriginalExtension();

        $vidname=$random_name.'_'.$album_name.'.'.$vidExtension;
        //$thumbname=$random_name.'_'.$album_name.'.'.$thumbExtension;
        
        $vidStatus = $request->file('video')->move($vidDestPath, $vidname);
        if($vidStatus){
            $thumbname = $this->resizer($thumb);
        }
        if(null != $thumbname){
        $newVideo = VideoGallery::create([
          'album_id'=> $request->get('album'),
          'title' => $request->get('title'),
          'description' => $request->get('description'),
          'url' => $vidname,
          'thumbnail' => $thumbname,
          
        ]);


        return redirect()->route('videos.show',['id'=>$newVideo->id])->with('success', 'misc.upload_succes');

        }

        return redirect()->route('videos.create', ['id' => $album_id])->withInput()->with('errors', 'misc.upload_failed');  
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

    /**
     * Resize uploaded image.
     *
     
     * @return \Illuminate\Http\Response
     */
    public function resizer($file)
    {
            // PATHS
            $temp            = 'public/temp/';
            $path_small    = 'public/gallery/video/thumbnail/' ;
            $path_large   = 'public/gallery/video/thumbnail/x';
           
            
            if( \File::isFile($file) )  {
                
                $extension    = $file->getClientOriginalExtension();
                $file_large     = strtolower(Auth::user()->id.time().str_random(40).'.'.$extension);
                $file_small     = strtolower(Auth::user()->id.time().str_random(40).'.'.$extension);
                
                if( $file->move($temp, $file_large) ) {
                    
                    set_time_limit(0);
                    
                    //=============== Image Large =================//
                    $width  = Helper::getWidth( $temp.$file_large );
                    $height = Helper::getHeight( $temp.$file_large );
                    $max_width = '800';
                    
                    if( $width < $height ) {
                        $max_width = '400';
                    }
                    
                    if ( $width > $max_width ) {
                        $scale = $max_width / $width;
                        $uploaded = Helper::resizeImage( $temp.$file_large, $width, $height, $scale, $temp.$file_large );
                    } else {
                        $scale = 1;
                        $uploaded = Helper::resizeImage( $temp.$file_large, $width, $height, $scale, $temp.$file_large );
                    }
                    
                    //=============== Small Large =================//
                    Helper::resizeImageFixed( $temp.$file_large, 400, 300, $temp.$file_small );
                                    
                    //======= Copy Folder Small and Delete...
                    if ( \File::exists($temp.$file_small) ) {
                        \File::copy($temp.$file_small, $path_small.$file_small);
                        \File::delete($temp.$file_small);
                    }//<--- IF FILE EXISTS
                    
                    Image::make($temp.$file_large)->orientate();
                    
                    //======= Copy Folder Large and Delete...
                    if ( \File::exists($temp.$file_large) ) {
                        \File::copy($temp.$file_large, $path_large.$file_large);
                        \File::delete($temp.$file_large);
                    }//<--- IF FILE EXISTS

                    $image_small  = $file_small;
                    $image_large  = $file_large; 

                    return $image_small;
                    
                }

            }    
            return null;
    }
}
