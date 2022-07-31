<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('type', 20)->comment('client/freelancer');
            $table->string('name');
            $table->double('price', 8, 2);
            $table->unsignedInteger('number_of_projects')->nullable();
            $table->unsignedInteger('number_of_days')->default(0);
            $table->double('commission', 8, 2)->nullable();
            $table->char('commission_type', 20)->nullable()->comment('flat/percenage');
            $table->double('minimum_withdraw', 8, 2)->nullable();
            $table->string('badge')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('active')->default(0)->comment('0-inactve, 1-active');
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
        Schema::dropIfExists('packages');
    }
}
