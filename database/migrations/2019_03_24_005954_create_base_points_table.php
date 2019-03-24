<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->unique();
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });

        \DB::table('base_points')->insert([
            'type' => 'kid',
            'quantity' => 1000,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_points');
    }
}
