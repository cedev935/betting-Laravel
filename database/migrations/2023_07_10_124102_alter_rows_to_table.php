<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRowsToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funds', function (Blueprint $table) {
            $table->string('payment_id')->nullable();
        });

        Schema::table('configures', function (Blueprint $table) {
            $table->string('currency_layer_access_key')->nullable();
            $table->tinyInteger('currency_layer_auto_update')->default(0);
            $table->string('currency_layer_auto_update_at')->nullable();
            $table->string('coin_market_cap_app_key')->nullable();
            $table->tinyInteger('coin_market_cap_auto_update')->default(0);
            $table->string('coin_market_cap_auto_update_at')->nullable();
        });

        Schema::table('payout_logs', function (Blueprint $table) {
            $table->string('response_id')->nullable();
            $table->text('meta_field')->nullable();
            $table->string('currency_code')->nullable();
            $table->text('last_error')->nullable();
        });

        Schema::table('payout_methods', function (Blueprint $table) {
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->text('bank_name')->nullable();
            $table->text('banks')->nullable();
            $table->text('parameters')->nullable();
            $table->text('extra_parameters')->nullable();
            $table->text('currency_lists')->nullable();
            $table->text('supported_currency')->nullable();
            $table->text('convert_rate')->nullable();
            $table->tinyInteger('is_automatic')->default(0);
            $table->tinyInteger('is_sandbox')->default(0);
            $table->tinyInteger('environment')->default(1)->comment("0=>test, 1=>live");
        });

        Schema::create('razorpay_contacts', function (Blueprint $table) {
            $table->string('contact_id')->nullable();
            $table->string('entity')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funds', function (Blueprint $table) {
            $table->dropColumn('payment_id');
        });

        Schema::table('configures', function (Blueprint $table) {
            $table->dropColumn('currency_layer_access_key');
            $table->dropColumn('currency_layer_auto_update');
            $table->dropColumn('currency_layer_auto_update_at');
            $table->dropColumn('currency_layer_auto_update_at');
            $table->dropColumn('coin_market_cap_app_key');
            $table->dropColumn('coin_market_cap_auto_update_at');
        });

        Schema::table('payout_logs', function (Blueprint $table) {
            $table->dropColumn('response_id');
            $table->dropColumn('meta_field');
            $table->dropColumn('currency_code');
            $table->dropColumn('last_error');
        });

        Schema::table('payout_logs', function (Blueprint $table) {
            $table->dropColumn('response_id');
            $table->dropColumn('meta_field');
            $table->dropColumn('currency_code');
            $table->dropColumn('last_error');
        });

        Schema::table('payout_methods', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('description');
            $table->dropColumn('bank_name');
            $table->dropColumn('banks');
            $table->dropColumn('parameters');
            $table->dropColumn('extra_parameters');
            $table->dropColumn('currency_lists');
            $table->dropColumn('supported_currency');
            $table->dropColumn('convert_rate');
            $table->dropColumn('is_automatic');
            $table->dropColumn('is_sandbox');
            $table->dropColumn('environment');
        });

    }
}
