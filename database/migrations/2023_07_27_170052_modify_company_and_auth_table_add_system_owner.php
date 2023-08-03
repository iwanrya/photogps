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
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('is_system_owner')->default(false);
        });

        Schema::table('user_auths', function (Blueprint $table) {
            $table->boolean('is_system_owner')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['is_system_owner']);
        });

        Schema::table('user_auths', function (Blueprint $table) {
            $table->dropColumn(['is_system_owner']);
        });
    }
};
