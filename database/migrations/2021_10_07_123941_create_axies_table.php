<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAxieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('axies', function (Blueprint $table) {
            $table->id();
            $table->integer('axie_id')->nullable();
            $table->tinyInteger('stage')->nullable();
            $table->tinyInteger('breed')->nullable();
            $table->string('ronin_address');
            $table->string('name')->nullable();
            $table->string('class')->nullable();
            $table->string('image')->nullable();
            $table->text('parts')->nullable();
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
        Schema::dropIfExists('axies');
    }
}
