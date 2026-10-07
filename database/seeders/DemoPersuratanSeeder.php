<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Disposisi;
use App\Models\MasterKlasifikasi;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoPersuratanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Master Klasifikasi
        $klasifikasis = [
            ['kode' => 'PR.102', 'nama' => 'Penyusunan Kebijakan Teknis Sarana Transportasi', 'kategori' => 'Kebijakan'],
            ['kode' => 'PL.201', 'nama' => 'Kajian & Rekomendasi Standardisasi Sarana Multimoda', 'kategori' => 'Rekomendasi'],
            ['kode' => 'OT.001', 'nama' => 'Tata Kelola Organisasi & Naskah Dinas PKST', 'kategori' => 'Tata Usaha'],
            ['kode' => 'UM.002', 'nama' => 'Undangan Rapat Koordinasi & Forum Kebijakan', 'kategori' => 'Koordinasi'],
            ['kode' => 'KU.001', 'nama' => 'Pengelolaan Anggaran Penelitian & Telaah Kebijakan', 'kategori' => 'Keuangan'],
            ['kode' => 'HM.201', 'nama' => 'Diseminasi Hasil Riset & Kebijakan Sarana', 'kategori' => 'Publikasi'],
        ];

        foreach ($klasifikasis as $k) {
            MasterKlasifikasi::updateOrCreate(['kode' => $k['kode']], $k);
        }

        // 2. Seed Users (RBAC: Admin, Pegawai, Kepala Bidang, Kepala Pusat)
        $users = [
            [
                'name' => 'Rian Pratama, S.Kom.',
                'nip' => '19920415 201802 1 003',
                'email' => 'admin@bkt.dephub.go.id',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'jabatan' => 'Pranata Komputer / Pengelola Persuratan',
                'unit_kerja' => 'Pusat Kebijakan Sarana Transportasi',
            ],
            [
                'name' => 'Dimas Surya Wicaksana, S.T., M.Sc.',
                'nip' => '19950720 202012 1 002',
                'email' => 'pegawai@bkt.dephub.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pegawai',
                'jabatan' => 'Analis Kebijakan Sarana Transportasi Darat & Multimoda',
                'unit_kerja' => 'Pusat Kebijakan Sarana Transportasi',
            ],
            [
                'name' => 'Annisa Putri Rahmawati, S.Tr.Tra.',
                'nip' => '19970912 202203 2 004',
                'email' => 'annisa@bkt.dephub.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pegawai',
                'jabatan' => 'Analis Kebijakan Sarana Perkeretaapian & Laut',
                'unit_kerja' => 'Pusat Kebijakan Sarana Transportasi',
            ],
            [
                'name' => 'Ir. H. Agus Wahyudi, M.Sc.',
                'nip' => '19780812 200312 1 002',
                'email' => 'kabid@bkt.dephub.go.id',
                'password' => Hash::make('password123'),
                'role' => 'kepala_bidang',
                'jabatan' => 'Kepala Bidang Sarana Transportasi Darat & Perkeretaapian',
                'unit_kerja' => 'Pusat Kebijakan Sarana Transportasi',
            ],
            [
                'name' => 'Dr. Ir. Bambang Priyanto, M.T.',
                'nip' => '19730514 199803 1 001',
                'email' => 'kapus@bkt.dephub.go.id',
                'password' => Hash::make('password123'),
                'role' => 'kepala_pusat',
                'jabatan' => 'Kepala Pusat Kebijakan Sarana Transportasi',
                'unit_kerja' => 'Pusat Kebijakan Sarana Transportasi',
            ],
        ];

        $userMap = [];
        foreach ($users as $u) {
            $created = User::updateOrCreate(['email' => $u['email']], $u);
            $userMap[$u['role']] = $created;
        }

        $admin = $userMap['admin'];
        $dimas = $userMap['pegawai'];
        $annisa = User::where('email', 'annisa@bkt.dephub.go.id')->first();
        $kabid = $userMap['kepala_bidang'];
        $kapus = $userMap['kepala_pusat'];

        // 3. Seed Surat Masuk
        $sm1 = SuratMasuk::create([
            'no_agenda' => 'AGD/PKST/2026/001',
            'no_surat_asal' => 'UM.202/1/4/DJPD-2026',
            'asal_instansi' => 'Direktorat Jenderal Perhubungan Darat',
            'perihal' => 'Permohonan Rekomendasi Kebijakan Standardisasi Armada Bus Listrik Perkotaan',
            'tanggal_surat' => now()->subDays(4)->toDateString(),
            'tanggal_diterima' => now()->subDays(3)->toDateString(),
            'sifat_surat' => 'Segera',
            'klasifikasi_kode' => 'PR.102',
            'ringkasan_isi' => 'Permohonan analisis dan telaah kebijakan mengenai kesiapan ekosistem sarana bus listrik perkotaan dan standar keselamatan baterai untuk angkutan massal Buy The Service (BTS).',
            'file_lampiran' => 'lampiran_kajian_bus_listrik.pdf',
            'status' => 'Sedang Ditindaklanjuti',
            'catatan_penerima' => 'Diterima melalui loket persuratan elektronik Pusat Kebijakan Sarana Transportasi.',
            'created_by' => $admin->id,
        ]);

        $sm2 = SuratMasuk::create([
            'no_agenda' => 'AGD/PKST/2026/002',
            'no_surat_asal' => 'ND.450/BKT.1/PKST/2026',
            'asal_instansi' => 'Sekretariat Badan Kebijakan Transportasi',
            'perihal' => 'Penyusunan Agenda Prioritas Riset & Kebijakan Sarana Transportasi Semester II 2026',
            'tanggal_surat' => now()->subDays(2)->toDateString(),
            'tanggal_diterima' => now()->subDays(1)->toDateString(),
            'sifat_surat' => 'Sangat Segera',
            'klasifikasi_kode' => 'OT.001',
            'ringkasan_isi' => 'Instruksi penyampaian matriks capaian kajian sarana semester I dan rencana percepatan telaah kebijakan sarana perkeretaapian cepat dan sarana pelabuhan penyeberangan.',
            'file_lampiran' => 'nota_dinas_sekretariat_bkt.pdf',
            'status' => 'Telah Didisposisi',
            'catatan_penerima' => 'Segera laporkan kepada Bapak Kapus untuk arahan disposisi berjenjang.',
            'created_by' => $admin->id,
        ]);

        $sm3 = SuratMasuk::create([
            'no_agenda' => 'AGD/PKST/2026/003',
            'no_surat_asal' => 'KCIC/DIR-TEK/VIII/2026-109',
            'asal_instansi' => 'PT Kereta Cepat Indonesia China (KCIC)',
            'perihal' => 'Usulan Forum Kebijakan Pengujian Sarana EMU Kereta Cepat Lintas Jakarta-Bandung Ext.',
            'tanggal_surat' => now()->subDay()->toDateString(),
            'tanggal_diterima' => now()->toDateString(),
            'sifat_surat' => 'Biasa',
            'klasifikasi_kode' => 'UM.002',
            'ringkasan_isi' => 'Permohonan kehadiran pimpinan dan analis kebijakan PKST BKT dalam Focus Group Discussion (FGD) kesiapan teknis sarana kereta cepat generasi terbaru.',
            'file_lampiran' => 'undangan_fgd_kcic.pdf',
            'status' => 'Baru Masuk',
            'catatan_penerima' => 'Dokumen fisik dan digital telah diverifikasi.',
            'created_by' => $dimas->id,
        ]);

        $sm4 = SuratMasuk::create([
            'no_agenda' => 'AGD/PKST/2026/004',
            'no_surat_asal' => 'PL.002/3/8/DITKAPEL-2026',
            'asal_instansi' => 'Direktorat Perkapalan dan Kepelautan, Ditjen Hubla',
            'perihal' => 'Laporan Akhir Uji Kelaikan Sarana Kapal Ro-Ro Penyeberangan Lintas Merak-Bakauheni',
            'tanggal_surat' => now()->subDays(10)->toDateString(),
            'tanggal_diterima' => now()->subDays(8)->toDateString(),
            'sifat_surat' => 'Biasa',
            'klasifikasi_kode' => 'PL.201',
            'ringkasan_isi' => 'Penyampaian data statistik kelaikan sarana kapal penyeberangan untuk bahan penyusunan rekomendasi peremajaan sarana transportasi laut komersial.',
            'file_lampiran' => 'laporan_kelaikan_kapal_roro.pdf',
            'status' => 'Selesai',
            'catatan_penerima' => 'Arsip kajian telah lengkap.',
            'created_by' => $admin->id,
        ]);

        // 4. Seed Disposisi (Hierarki: Kapus -> Kabid -> Pegawai)
        Disposisi::create([
            'surat_masuk_id' => $sm1->id,
            'dari_user_id' => $kabid->id,
            'kepada_user_id' => $dimas->id,
            'instruksi' => ['Pelajari / Kaji', 'Siapkan Bahan / Tanggapan', 'Koordinasikan'],
            'catatan_disposisi' => 'Sdr. Dimas, tindak lanjuti disposisi Bapak Kapus: lakukan telaah komprehensif terhadap spesifikasi teknis baterai bus listrik dan sinkronkan dengan regulasi keselamatan. Siapkan draf telaah dalam 3 hari kerja.',
            'batas_waktu' => now()->addDays(2)->toDateString(),
            'status' => 'Sedang Dikerjakan',
            'tanggapan_pegawai' => 'Siap laksanakan arahan Pak Kabid dan Pak Kapus. Saat ini tim analis sedang menyusun matriks komparasi standar bus listrik dengan UN ECE R100.',
            'created_at' => now()->subDays(2),
        ]);

        Disposisi::create([
            'surat_masuk_id' => $sm2->id,
            'dari_user_id' => $kapus->id,
            'kepada_user_id' => $kabid->id,
            'instruksi' => ['Tindak Lanjuti', 'Selesaikan'],
            'catatan_disposisi' => 'Pak Kabid Sarana Darat, tolong pimpin perumusan agenda prioritas riset sarana dan kordinasikan dengan seluruh staf analis kebijakan.',
            'batas_waktu' => now()->addDays(3)->toDateString(),
            'status' => 'Menunggu',
            'created_at' => now()->subDay(),
        ]);

        Disposisi::create([
            'surat_masuk_id' => $sm4->id,
            'dari_user_id' => $kabid->id,
            'kepada_user_id' => $annisa->id,
            'instruksi' => ['Pelajari / Kaji', 'Simpan / Arsipkan'],
            'catatan_disposisi' => 'Sdri. Annisa, data ini sangat baik untuk melengkapi policy brief peremajaan sarana laut. Rangkum saripatinya dan simpan ke database arsip PKST.',
            'batas_waktu' => now()->subDays(2)->toDateString(),
            'status' => 'Selesai',
            'tanggapan_pegawai' => 'Laporan telah diringkas ke dalam Policy Brief No. 14/PB/PKST/2026 dan telah dipublikasikan ke repositori BKT.',
            'file_laporan' => 'policy_brief_peremajaan_sarana_laut.pdf',
            'tanggal_selesai' => now()->subDays(1),
            'created_at' => now()->subDays(7),
        ]);

        // 5. Seed Surat Keluar (Workflow: Konsep -> Paraf Kabid -> TTE Kapus -> Terkirim)
        $sk1 = SuratKeluar::create([
            'no_surat' => 'PR.102/1/2/PKST-BKT/2026',
            'tujuan_surat' => 'Direktur Jenderal Perhubungan Darat',
            'perihal' => 'Rekomendasi Kebijakan Standardisasi Sarana Bus Listrik dan Uji Berkala Baterai Kendaraan Massal Perkotaan',
            'tanggal_surat' => now()->toDateString(),
            'sifat_surat' => 'Segera',
            'klasifikasi_kode' => 'PR.102',
            'ringkasan_isi' => 'Rekomendasi teknis dan kebijakan Pusat Kebijakan Sarana Transportasi tentang tata kelola sertifikasi kelaikan sarana bus listrik perkotaan dan fasilitas pengisian daya cepat.',
            'isi_surat' => "Sehubungan dengan permohonan kajian implementasi bus listrik perkotaan, Pusat Kebijakan Sarana Transportasi Badan Kebijakan Transportasi menyampaikan rekomendasi strategis berikut:\n\n1. Penetapan standar sertifikasi baterai mengacu pada regulasi internasional demi menjamin keselamatan penumpang.\n2. Pembentukan protokol tanggap darurat kecelakaan sarana bertenaga listrik pada koridor Buy The Service (BTS).\n3. Pelaksanaan uji kelaikan berkala sarana kendaraan bermotor listrik berbasis baterai secara digital dan terintegrasi.",
            'file_lampiran' => 'draft_rekomendasi_bus_listrik.pdf',
            'status' => 'Menunggu Paraf Kabid',
            'konseptor_id' => $dimas->id,
            'qr_code_token' => Str::random(32),
            'created_at' => now()->subHours(5),
        ]);

        $sk2 = SuratKeluar::create([
            'no_surat' => 'ND.088/BKT/PKST/2026',
            'tujuan_surat' => 'Kepala Badan Kebijakan Transportasi',
            'perihal' => 'Nota Dinas Laporan Kajian Kelayakan Sarana LRT Multimoda dan Integrasi Moda Kawasan Aglomerasi',
            'tanggal_surat' => now()->subDays(2)->toDateString(),
            'sifat_surat' => 'Sangat Segera',
            'klasifikasi_kode' => 'PL.201',
            'ringkasan_isi' => 'Laporan komprehensif telaah kebijakan integrasi sarana transportasi rel ringan dengan angkutan penghubung (feeder).',
            'isi_surat' => "Bersama ini kami laporkan hasil telaah kebijakan integrasi sarana LRT Jabodebek dengan angkutan pengumpan. Rekomendasi telah divalidasi bersama para pakar transportasi sarana dan disahkan oleh Kepala Pusat Kebijakan Sarana Transportasi.",
            'file_lampiran' => 'nota_dinas_lrt_sarana.pdf',
            'status' => 'Disetujui/TTE',
            'konseptor_id' => $dimas->id,
            'paraf_kabid_by' => $kabid->id,
            'paraf_kabid_at' => now()->subDay(),
            'paraf_kabid_catatan' => 'Materi telaah telah diteliti bersama tim teknis bidang. Disetujui untuk pengesahan TTE Kepala Pusat.',
            'tte_kapus_by' => $kapus->id,
            'tte_kapus_at' => now()->subHours(10),
            'tte_kapus_catatan' => 'Telah ditandatangani secara elektronik (TTE) bersertifikat BSrE oleh Kepala Pusat Kebijakan Sarana Transportasi.',
            'qr_code_token' => 'BKT-PKST-TTE-2026-9874128471',
            'created_at' => now()->subDays(2),
        ]);

        $sk3 = SuratKeluar::create([
            'no_surat' => 'UM.015/PKST-BKT/2026',
            'tujuan_surat' => 'Para Anggota Tim Kelompok Kerja Sarana Transportasi Perkeretaapian',
            'perihal' => 'Undangan Rapat Koordinasi Penyusunan Pedoman Kelaikan Sarana Kereta Cepat',
            'tanggal_surat' => now()->subDays(4)->toDateString(),
            'sifat_surat' => 'Biasa',
            'klasifikasi_kode' => 'UM.002',
            'ringkasan_isi' => 'Undangan rapat hybrid teknis sarana kereta cepat bertempat di Ruang Rapat Lt. 4 Badan Kebijakan Transportasi, Jl. Medan Merdeka Timur No. 5 Jakarta.',
            'isi_surat' => "Mengharap kehadiran Bapak/Ibu dalam rapat koordinasi teknis penyusunan pedoman uji tipe sarana perkeretaapian cepat...",
            'file_lampiran' => 'undangan_rakor_kcic.pdf',
            'status' => 'Terkirim',
            'konseptor_id' => $annisa->id,
            'paraf_kabid_by' => $kabid->id,
            'paraf_kabid_at' => now()->subDays(3),
            'tte_kapus_by' => $kapus->id,
            'tte_kapus_at' => now()->subDays(3),
            'qr_code_token' => 'BKT-PKST-TTE-2026-1122334455',
            'created_at' => now()->subDays(4),
        ]);

        // 6. Seed Activity Logs
        ActivityLog::record($admin->id, 'SYSTEM_INIT', 'Inisialisasi sistem database E-Surat PKST BKT Kemenhub berhasil.');
        ActivityLog::record($dimas->id, 'REGISTRASI_SURAT_MASUK', 'Mencatat Surat Masuk baru No. KCIC/DIR-TEK/VIII/2026-109 dari PT KCIC.');
        ActivityLog::record($kapus->id, 'DISPOSISI_SURAT', 'Kepala Pusat membuat lembar disposisi untuk Surat No. ND.450/BKT.1/PKST/2026 kepada Kepala Bidang.');
        ActivityLog::record($kabid->id, 'DISPOSISI_SURAT', 'Kepala Bidang meneruskan disposisi teknis kepada Analis Kebijakan.');
        ActivityLog::record($kabid->id, 'PARAF_DIGITAL', 'Kepala Bidang memberikan Paraf Koordinasi pada Surat Keluar ND.088/BKT/PKST/2026.');
        ActivityLog::record($kapus->id, 'TTE_DIGITAL', 'Kepala Pusat mengesahkan Tanda Tangan Elektronik (TTE) ber-QR Code untuk Nota Dinas Kelayakan Sarana LRT.');
    }
}
