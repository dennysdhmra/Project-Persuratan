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
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('active')->after('role'); // active, pending, suspended
            $table->string('sso_provider')->nullable()->after('status'); // kemenhub, google
            $table->string('sso_id')->nullable()->after('sso_provider');
            $table->string('sso_avatar')->nullable()->after('sso_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'sso_provider', 'sso_id', 'sso_avatar']);
        });
    }
};
