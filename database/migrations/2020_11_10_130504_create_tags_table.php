<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('title');//tag name
            $table->string('slug');//tag slug
            $table->text('description');//article long description
            $table->boolean('status');//article status =>show or hide for user

            $table->unsignedBigInteger('photo_id');//one to many relegation ship tag and photo
            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('CASCADE');

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
        Schema::dropIfExists('tags');
    }
}
