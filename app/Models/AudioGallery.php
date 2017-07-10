<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudioGallery extends Model
{
    protected $table = 'audios_gallery';
    protected $fillable = array('album_id','title','description','url');
}
