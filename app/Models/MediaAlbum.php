<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaAlbum extends Model
{
    protected $table = 'media_albums';

    protected $fillable = ['name', 'description', 'type'];

    public function Images(){
    	
    	return $this->hasMany('App\Models\ImageGallery', 'album_id', 'id');
    }

    public function Videos(){
    	
    	return $this->hasMany('App\Models\VideoGallery', 'album_id', 'id');
    }

    public function Audios(){
    	
    	return $this->hasMany('App\Models\AudioGallery', 'album_id', 'id');
    }
}
