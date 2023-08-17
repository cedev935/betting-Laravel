<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetInvestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('bet_invests', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('user_id');
//            $table->unsignedBigInteger('creator_id');
//            $table->unsignedBigInteger('match_id');
//            $table->unsignedBigInteger('question_id');
//            $table->unsignedBigInteger('bet_option_id');
//            $table->decimal('invest_amount')->default(0.00);
//            $table->decimal('return_amount')->default(0.00);
//            $table->decimal('charge')->default(0.00);
//            $table->decimal('remaining_balance')->default(0.00);
//            $table->string('radio')->nullable();
//            $table->tinyInteger('status')->default(0)->comment('default 0, win 1, lose -1, refund 2');
//            $table->string('question_name')->nullable();
//            $table->string('option_name')->nullable();
//            $table->tinyInteger('isMultiBet')->default(0);
//            $table->longText('details')->nullable();
//
//
//            $table->foreign('match_id')
//                ->references('id')->on('game_matches')->onDelete('cascade');
//            $table->foreign('question_id')
//                ->references('id')->on('game_questions')->onDelete('cascade');
//            $table->foreign('bet_option_id')
//                ->references('id')->on('game_options')->onDelete('cascade');
//            $table->foreign('user_id')
//                ->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('bet_invests');
    }
}
