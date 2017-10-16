<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('row');
            $table->integer('col');
            $table->integer('pieces');
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
        Schema::table('game_sizes', function (Blueprint $table) {
            //
        });
    }
}
