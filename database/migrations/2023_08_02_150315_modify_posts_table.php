<?php

use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->bigInteger('status')->unsigned()->nullable();

            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('cascade');

            $table->foreign('project_id')
                ->references('id')->on('projects')
                ->onDelete('cascade');

            $table->foreign('status')
                ->references('id')->on('status')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('posts_customer_id_foreign');
            $table->dropIndex('posts_customer_id_foreign');

            $table->dropForeign('posts_project_id_foreign');
            $table->dropIndex('posts_project_id_foreign');

            $table->dropForeign('posts_status_foreign');
            $table->dropIndex('posts_status_foreign');

            $table->dropColumn(['customer_id']);
            $table->dropColumn(['project_id']);
            $table->dropColumn(['status']);
        });
    }
};
