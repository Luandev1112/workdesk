<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_category_id');
            $table->char('type', 20)->comment('fixed/hourly/long_term');
            $table->unsignedBigInteger('client_user_id');
            $table->string('name');
            $table->text('excerpt');
            $table->longText('description')->nullable();
            $table->double('price', 8, 2);
            $table->longText('skills')->nullable();
            $table->boolean('biddable')->default(1);
            $table->boolean('private')->default(0);
            $table->boolean('closed')->default(0);
            $table->timestamps();

            $table->foreign('project_category_id')->references('id')->on('project_categories');
            $table->foreign('client_user_id')->references('id')->on('users');
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
