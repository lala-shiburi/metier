<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('openings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('hiring_step_group_id')->nullable();
            $table->string('title');
            $table->string('picture')->nullable();
            $table->text('details');
            $table->string('salary_range')->nullable();
            $table->string('youtube_video')->nullable();
            $table->integer('professional_years')->nullable();
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
        Schema::dropIfExists('openings');
    }
}
