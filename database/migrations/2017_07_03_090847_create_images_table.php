<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_gallery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('album_id')->unsigned();
            $table->string('description');
            $table->string('url');
            $table->foreign('album_id')->references('id')->on('media_albums')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images_gallery');
    }
}
