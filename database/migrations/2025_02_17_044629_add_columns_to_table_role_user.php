<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->string('slug')->nullable();
        });

        DB::statement("UPDATE role_user SET slug = 'admin' WHERE role_id = 1");
        DB::statement("UPDATE role_user SET slug = 'merchant' WHERE role_id = 2");
        DB::statement("UPDATE role_user SET slug = 'driver' WHERE role_id = 3");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropColumn('slug');

            DB::statement("UPDATE role_user SET slug = NULL");
        });
    }
};
