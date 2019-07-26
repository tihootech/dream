<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemiFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semi_finals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('year');
            $table->unsignedInteger('base');
            $table->text('performers')->nullable();
            $table->string('announcer')->nullable();
            $table->string('queen')->nullable();
            $table->string('manager')->nullable();
            $table->string('sitters')->nullable();
            $table->string('suckers')->nullable();
            $table->text('layers')->nullable();
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
        Schema::dropIfExists('semi_finals');
    }
}
