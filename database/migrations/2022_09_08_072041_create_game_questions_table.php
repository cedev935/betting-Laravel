<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('game_questions', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('match_id');
//            $table->string('name')->nullable();
//            $table->tinyInteger('status')->default(0)->comment('0=> pending, 1=> active, 2=> closed');
//            $table->tinyInteger('result')->default(0);
//            $table->integer('limit')->default(100);
//            $table->unsignedBigInteger('creator_id');
//            $table->foreign('match_id')
//                ->references('id')->on('game_matches')->onDelete('cascade');
//            $table->foreign('creator_id')
//                ->references('id')->on('users')->onDelete('cascade');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_questions');
    }
}
