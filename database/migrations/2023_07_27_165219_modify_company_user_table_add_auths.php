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
        Schema::table('company_users', function (Blueprint $table) {
            $table->bigInteger('auth')->unsigned()->default(1);

            $table->foreign('auth')
                ->references('id')->on('user_auths')
                ->onDelete('cascade');

            $table->primary(['company_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_users', function (Blueprint $table) {
            $table->dropForeign('company_users_auth_foreign');
            $table->dropIndex('company_users_auth_foreign');

            $table->dropColumn(['auth']);
        });
    }
};
