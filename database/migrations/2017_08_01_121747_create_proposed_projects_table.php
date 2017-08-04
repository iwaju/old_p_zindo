<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposedProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposed_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('country');
            $table->string('town');
            $table->string('amount');
            $table->string('campaign_duration');
            $table->text('description');
            $table->text('counterparts');
            $table->text('project_holder_intro');
            $table->integer('user_id');
            $table->boolean('submitted')->default(0);
            $table->boolean('validated')->default(0);
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
        Schema::dropIfExists('proposed_projects');
    }
}