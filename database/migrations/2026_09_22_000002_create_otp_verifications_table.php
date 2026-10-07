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
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('otp_code', 6);
            $table->string('action')->default('register'); // register, login, reset_password
            $table->json('payload')->nullable(); // holds registration metadata (name, nip, jabatan, etc.)
            $table->timestamp('expires_at');
            $table->integer('attempts')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
    }
};
