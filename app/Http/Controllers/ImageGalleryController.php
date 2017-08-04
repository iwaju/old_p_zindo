<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;
use App\Models\ImageGallery;
use App\Models\MediaAlbum;
use App\Helper;
use Image;

class ImageGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media_type = 'photo';
        $albums = MediaAlbum::where(['type'=>'photo'])->with('Images')->get();

        return view('admin.media.photo.index', compact('albums', 'media_type'));
    }

    /**
     * Show the form for creating a new image.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $album_id = $request->get('id_type');

        $media_type = MediaAlbum::where(['id'=>$album_id])->firstOrFail()->type;
        
        $albums = MediaAlbum::where(['type'=>$media_type])->get();

        return view('admin.media.photo.create', compact('albums', 'media_type', 'album_id'));
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
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $album_id = $request->get('album');
        $input = ['album' => null];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->route('photos.create', ['id' => $album_id])->withErrors($validator)->withInput();
        }


        $album_name = MediaAlbum::find($album_id)->name;
        $file = $request->file('image');
        $filePath = 'public/gallery/photo/'.$album_name.'/';
        $thumbPath = 'public/gallery/photo/thumbnails/';


        $status = $this->resizer($file, $album_name);

        if (null != $status) {
        $newImage = ImageGallery::create([
          'description' => $request->get('description'),
          'url' => $status,
          'album_id'=> $request->get('album')
        ]);

          return redirect()->route('photos-albums',['id'=>$newImage->album_id]);
        }
        return back()-with()->with('errors', 'file size error')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = ImageGallery::findOrFail($id);
        $album = MediaAlbum::findOrFail($image->album_id);
        
        return view('admin.media.photo.view', compact('album','image')); 
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
     * Move an image to another Album.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        $rules = array(

          'new_album' => 'required|numeric|exists:media_albums,id',
          'image'=>'required|num,nnnuueric|exists:images_gallery,id'

        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

          return redirect()->route('photo-album.index');
        }

        $new_album = $request->get('new_album');
        $image = ImageGallery::find($request->get('photo'));
        $image->album_id = $new_album;
        $image->save();
        return redirect()->route('photo-album.show', ['id'=>$new_album]);
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

         $current_album = MediaAlbum::where(['id'=>$id])->with('Images')->get()->first();

         $albums = MediaAlbum::where(['type'=>$current_album->type])->with('Images')->get();

         return view('admin.media.photo.show', compact('current_album','albums'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = ImageGallery::find($id);
        $album_name = MediaAlbum::find($image->album_id)->name;
        //dd($album_name);
        $album = $image->album_id;
        //unlink('public/gallery/photo/'.$image->url);
        //unlink('public/gallery/photo/thumbnails/'.$image->url);
        $image->delete();
        return redirect()->route('photos-albums',['id'=>$album]);
    }

    /**
     * Resize uploaded image.
     *
     
     * @return \Illuminate\Http\Response
     */
    public function resizer($file,$album_name)
    {
            // PATHS
            $temp            = 'public/temp/';
            $path_small    = 'public/gallery/photo/thumbnails/' ;
            $path_large   = 'public/gallery/photo/';
           
            
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

                    return $image_large;
                    
                }

            }    
            return null;
    }


}
