<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chat_thread_id');
            $table->unsignedBigInteger('sender_user_id');
            $table->text('message');
            $table->string('attachment')->nullable();
            $table->boolean('seen')->default(0);
            $table->timestamps();

            $table->foreign('chat_thread_id')->references('id')->on('chat_threads');
            $table->foreign('sender_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
