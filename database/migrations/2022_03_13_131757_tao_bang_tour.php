<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('price', 12, 3);
            $table->integer('duration')->nullable();
            $table->string('difficulty')->nullable();
            $table->string('imageCover')->nullable();
            $table->integer('maxGroupSize')->nullable();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        /*Schema::table("locations", function(Blueprint $table){
            $table->integer("tour_id")->nullable();
        });*/
    }

    public function down()
    {
        Schema::dropIfExists('tours');

        /* Schema::table("locations", function(Blueprint $table){
            $table->dropColumn("tour_id");
        });*/
    }
};
