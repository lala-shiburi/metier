<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $languages = [
            'Swift',
            'Ruby',
            'Python',
            'PHP',
            'Javascript',
            'Java',
            'Go',
            'C++',
            'C#',
            'Perl',
            'SQL',
            'VB.NET',
            'C',
            'TypeScript',
        ];

        foreach($languages as $language){
            \DB::table('languages')->insert([
                'name'=>$language,
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
        Schema::dropIfExists('languages');
    }
}
