<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('create_user_id')->unsigned();
            $table->string('image');
            $table->float('latitude');
            $table->float('longitude');
            $table->string('photographer');
            $table->string('photographer_username');
            $table->timestamp('shoot_datetime')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('create_user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('post_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->bigInteger('create_user_id')->unsigned();
            $table->text('comment');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');

            $table->foreign('create_user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_comments');
        Schema::dropIfExists('posts');
    }
};
