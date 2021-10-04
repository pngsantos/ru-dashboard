<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->foreignId('scholar_id');
            $table->foreignId('user_id')->nullable();
            $table->string('ronin_address');
            $table->string('tags')->nullable();
            $table->tinyInteger('split');
            $table->integer('mmr')->nullable();
            $table->integer('unclaimed_slp')->nullable();
            $table->date('next_claim_date')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
