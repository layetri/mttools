<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            // name
            $table->string('name');
            // description
            $table->longText('description');
            // href
            $table->string('href')->nullable();
            // image
            $table->string('image');
            // category
            $table->string('label');
            // personal/school (bool)
            $table->boolean('personal')->default(0);
            // interactive (bool)
            $table->boolean('interactive')->default(0);
            // github
            $table->string('github')->nullable();

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
        Schema::dropIfExists('projects');
    }
}
