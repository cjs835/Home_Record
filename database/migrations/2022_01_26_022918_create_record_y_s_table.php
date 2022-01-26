<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordYSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recordsy', function (Blueprint $table) {
            $table->id();
            $table->decimal('temperature', 10, 2)->comment("溫度");
            $table->decimal('humidity', 10, 2)->comment("濕度");
            $table->integer('numbers')->comment("數量");
            $table->timestamp('time')->comment("紀錄時間");
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
        Schema::dropIfExists('recordsy');
    }
}
