<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_activity', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('tag_id')->unsigned();
            $table->integer('activity_id')->unsigned();

            # Make Foreign Keys
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('activity_id')->references('id')->on('activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_activity');
    }
}
