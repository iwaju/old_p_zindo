<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    protected $table = 'videos_gallery';
    protected $fillable = array('album_id','title','description','thumbnail','url');
}
