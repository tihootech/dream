<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('number');
            $table->unsignedSmallInteger('block');
            $table->unsignedSmallInteger('capacity')->default(6);
            $table->unsignedSmallInteger('status')->default(1); // 1:empty, 2:accepting, 3:full
            $table->timestamps();
        });

        $blocks = [1,2,3,4,6];
        foreach ($blocks as $block) {
            $numbers = [51,52,53,54,55,56,101,102,103,104,105,106,201,202,203,204,205,206,301,302,303,304,305,306];
            foreach ($numbers as $number) {
                \App\Room::create([
                    'number' => $number,
                    'block' => $block,
                ]);
            }
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
