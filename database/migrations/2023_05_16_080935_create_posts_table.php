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
            $table->increments('post_id');
            $table->string('image');
            $table->decimal('latitude', 20, 15);
            $table->decimal('longitude', 20, 15);
            $table->string('photographer');
            $table->string('photographer_username');
            $table->timestamp('shoot_datetime')->nullable();
            $table->timestamps();
        });

        Schema::create('post_comments', function (Blueprint $table) {
            $table->increments('post_comment_id');
            $table->integer('post_id')->unsigned();
            $table->text('comment');
            $table->timestamps();

            $table->foreign('post_id')
                ->references('post_id')->on('posts')
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
