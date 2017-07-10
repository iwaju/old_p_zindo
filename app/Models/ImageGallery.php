<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
	protected $table = 'images_gallery';
    protected $fillable = array('album_id','description','url');
}
