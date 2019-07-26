<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('semi_final_id');
            $table->unsignedSmallInteger('day')->nullable();
            $table->text('morning_sex')->nullable();
            $table->text('secretary')->nullable();
            $table->text('best_kid')->nullable();
            $table->text('show')->nullable();
            $table->text('threesome')->nullable();
            $table->text('winner_1')->nullable();
            $table->text('winner_2')->nullable();
            $table->text('winner_3')->nullable();
            $table->text('winner_4')->nullable();
            $table->text('winner_overall')->nullable();
            $table->text('pool_party')->nullable();
            $table->text('nightovers')->nullable();
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
        Schema::dropIfExists('final_days');
    }
}
