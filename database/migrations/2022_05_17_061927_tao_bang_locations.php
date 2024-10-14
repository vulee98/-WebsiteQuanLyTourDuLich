<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->string('description')->nullable();
            $table->integer('day')->nullable();
            $table->date('startDate')->nullable();
            $table->unsignedBigInteger('tour_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
