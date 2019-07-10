<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoomIdForStars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stars', function (Blueprint $table) {
            $table->unsignedInteger('room_id')->after('name')->nullable();
        });

        $rooms = \App\Room::inRandomOrder()->get();
        foreach ($rooms as $room) {
            for ($i=0; $i < $room->capacity ; $i++) {
                $star = \App\Star::whereNull('room_id')->inRandomOrder()->first();
                if ($star) {
                    $star->change_room($room->id);
                    $i == $room->capacity-1 ? $room->mark_as_full() : $room->mark_as_accepting();
                }
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
        Schema::table('stars', function (Blueprint $table) {
            $table->dropColumn('room_id');
        });
    }
}
