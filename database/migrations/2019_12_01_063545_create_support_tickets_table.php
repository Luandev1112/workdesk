<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('support_category_id');
            $table->unsignedBigInteger('sender_user_id');
            $table->unsignedBigInteger('assigned_user_id');
            $table->string('subject');
            $table->text('description');
            $table->char('priority', 20)->nullable()->default('regular')->comment('regular/low/medium/high');
            $table->boolean('status')->default(0)->comment('0-pending, 1-solved');
            $table->boolean('seen')->default(0)->comment('0-unseen, 1-seen');
            $table->string('attachment')->nullable();
            $table->timestamps();

            $table->foreign('support_category_id')->references('id')->on('support_categories');
            $table->foreign('sender_user_id')->references('id')->on('users');
            $table->foreign('assigned_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_tickets');
    }
}
