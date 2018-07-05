<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id');
            $table->string('employee_count')->nullable();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('email');
            $table->string('website_url')->nullable();
            $table->string('photo')->nullable();
            $table->string('cover')->nullable();
            $table->string('province')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
