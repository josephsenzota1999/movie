<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
             $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('movie_id');
        $table->unsignedTinyInteger('rating'); // Rating on a scale of 1 to 5
        $table->timestamps();

        $table->unique(['user_id', 'movie_id']);
        $table->foreign('user_id')->references('id')->on('users');
        $table->foreign('movie_id')->references('id')->on('movies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};
