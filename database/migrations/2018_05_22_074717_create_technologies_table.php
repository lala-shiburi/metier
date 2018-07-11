<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technologies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('tag_name');
            $table->timestamps();
        });

        $technologies = [
            ['AngularJS','angular'],
            ['ReactJS','react'],
            ['NodeJS','node'],
            ['Laravel','laravel'],
            ['CodeIgniter','codeigniter'],
            ['Vue','vue'],
            ['JQuery','jquery'],
        ];

        foreach($technologies as $technology){
            \DB::table('technologies')->insert([
                "name"=>$technology[0],
                "tag_name"=>$technology[1],
                "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
                "updated_at" => \Carbon\Carbon::now(),  # \Datetime()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technologies');
    }
}
