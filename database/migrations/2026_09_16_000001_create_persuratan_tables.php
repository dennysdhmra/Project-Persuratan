<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Master Klasifikasi Surat
        Schema::create('master_klasifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->string('nama');
            $table->string('kategori')->default('Kebijakan Transportasi');
            $table->timestamps();
        });

        // 2. Surat Masuk
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('no_agenda', 50)->unique();
            $table->string('no_surat_asal');
            $table->string('asal_instansi');
            $table->string('perihal');
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima');
            $table->enum('sifat_surat', ['Sangat Segera', 'Segera', 'Biasa', 'Rahasia'])->default('Biasa');
            $table->string('klasifikasi_kode', 30)->default('PR.102');
            $table->text('ringkasan_isi')->nullable();
            $table->string('file_lampiran')->nullable();
            $table->enum('status', ['Baru Masuk', 'Telah Didisposisi', 'Sedang Ditindaklanjuti', 'Selesai'])->default('Baru Masuk');
            $table->text('catatan_penerima')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 3. Disposisi Surat Masuk
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained('surat_masuk')->onDelete('cascade');
            $table->foreignId('dari_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kepada_user_id')->constrained('users')->onDelete('cascade');
            $table->json('instruksi'); // ['Tindak Lanjuti', 'Pelajari/Kaji', dll]
            $table->text('catatan_disposisi')->nullable();
            $table->date('batas_waktu')->nullable();
            $table->enum('status', ['Menunggu', 'Sedang Dikerjakan', 'Selesai'])->default('Menunggu');
            $table->text('tanggapan_pegawai')->nullable();
            $table->string('file_laporan')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();
        });

        // 4. Surat Keluar
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat', 100)->unique();
            $table->string('tujuan_surat');
            $table->string('perihal');
            $table->date('tanggal_surat');
            $table->enum('sifat_surat', ['Sangat Segera', 'Segera', 'Biasa', 'Rahasia'])->default('Biasa');
            $table->string('klasifikasi_kode', 30)->default('PR.102');
            $table->text('ringkasan_isi')->nullable();
            $table->longText('isi_surat')->nullable();
            $table->string('file_lampiran')->nullable();
            $table->enum('status', [
                'Draft Konsep',
                'Review Staf',
                'Menunggu Paraf Kabid',
                'Menunggu TTE Kapus',
                'Disetujui/TTE',
                'Terkirim'
            ])->default('Draft Konsep');
            $table->foreignId('konseptor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('paraf_kabid_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('paraf_kabid_at')->nullable();
            $table->text('paraf_kabid_catatan')->nullable();
            $table->foreignId('tte_kapus_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('tte_kapus_at')->nullable();
            $table->text('tte_kapus_catatan')->nullable();
            $table->string('qr_code_token', 64)->unique();
            $table->timestamps();
        });

        // 5. Activity Logs (Audit Trail)
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 60);
            $table->text('description');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('surat_keluar');
        Schema::dropIfExists('disposisi');
        Schema::dropIfExists('surat_masuk');
        Schema::dropIfExists('master_klasifikasi');
    }
};
