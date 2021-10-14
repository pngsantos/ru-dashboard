<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->foreignId('scholar_id');
            $table->integer('split')->nullable();
            $table->decimal('slp')->nullable();
            $table->decimal('usd')->nullable();
            $table->decimal('bonus')->nullable();
            $table->decimal('balance')->nullable();
            $table->tinyInteger('team_weight')->nullable();
            $table->datetime('from_date')->nullable();
            $table->datetime('to_date')->nullable();
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
        Schema::dropIfExists('payouts');
    }
}
