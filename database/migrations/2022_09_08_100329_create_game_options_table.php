<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('option_name')->nullable();
            $table->decimal('invest_amount');
            $table->decimal('return_amount');
            $table->decimal('minimum_amount');
            $table->string('ratio')->nullable();
            $table->tinyInteger('status')->comment('pending=>1 ,win=>2, deActive=>0, refunded=>3, Lost=> -2');
            $table->foreign('match_id')
                ->references('id')->on('game_matches')->onDelete('cascade');
            $table->foreign('question_id')
                ->references('id')->on('game_questions')->onDelete('cascade');
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
        Schema::dropIfExists('game_options');
    }
}
