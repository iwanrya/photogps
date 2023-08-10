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
        Schema::table('user_auths', function (Blueprint $table) {
            $table->bigInteger('create_user_id')->unsigned()->nullable();

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
        Schema::table('user_auths', function (Blueprint $table) {
            $table->dropForeign('user_auths_create_user_id_foreign');
            $table->dropIndex('user_auths_create_user_id_foreign');

            $table->dropColumn('create_user_id');
        });
    }
};
