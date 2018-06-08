<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('name');
            $table->date('birth_date')->after('id');
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('gender')->after('last_name');
            $table->string('citizenship')->after('gender');
            $table->integer('photo')->after('citizenship');
            $table->integer('cover_photo')->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function(Blueprint $table){
            $table->string('name');
            $table->dropColumn('birth_date');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('gender');
            $table->dropColumn('citizenship');
            $table->dropColumn('photo');
            $table->dropColumn('cover_photo');
        });
    }
}
