<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();          // wajib @mhs.unesa.ac.id (divalidasi di aplikasi)
            $table->string('nim', 20)->nullable()->unique();
            $table->string('faculty')->nullable();
            $table->string('study_program')->nullable();
            $table->string('whatsapp', 20)->nullable();  // format 628xxxxxxxxxx
            $table->string('avatar')->nullable();        // path di storage/app/public/avatars
            $table->string('password');

            // Verifikasi OTP
            $table->string('otp_code')->nullable();      // disimpan ter-hash
            $table->timestamp('otp_expires_at')->nullable();
            $table->timestamp('otp_sent_at')->nullable(); // untuk cooldown 60 detik
            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};