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
        Schema::create('post_photos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id')->unsigned();
            $table->string('image');
            $table->float('latitude');
            $table->float('longitude');
            $table->timestamp('shoot_datetime')->nullable();
            $table->bigInteger('create_user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('post_photos');
    }
};
