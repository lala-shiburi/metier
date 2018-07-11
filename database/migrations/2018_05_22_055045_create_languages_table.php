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
        Schema::create('programming_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('tag_name');
            $table->timestamps();
        });

        $languages = [
            ['Swift','swift'],
            ['Ruby','ruby'],
            ['Python','python'],
            ['PHP','php'],
            ['Javascript','javascript'],
            ['Go','go'],
            ['C++','cPlusPlus'],
            ['C#','csharp'],
            ['Perl','perl'],
            ['SQL','sql'],
            ['VB.NET','vb'],
            ['C','c'],
            ['TypeScript','typescript'],
        ];

        foreach($languages as $language){
            \DB::table('programming_languages')->insert([
                'name'=>$language[0],
                'tag_name'=>$language[1],
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
        Schema::dropIfExists('programming_languages');
    }
}
