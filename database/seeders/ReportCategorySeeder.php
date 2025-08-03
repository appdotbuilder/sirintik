<?php

namespace Database\Seeders;

use App\Models\ReportCategory;
use App\Models\ReportTemplateField;
use Illuminate\Database\Seeder;

class ReportCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tanaman Pangan
        $tanamanPangan = ReportCategory::create([
            'name' => 'Tanaman Pangan',
            'slug' => 'tanaman-pangan',
            'description' => 'Laporan tentang tanaman pangan seperti padi, jagung, kedelai, dll.',
            'is_active' => true,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $tanamanPangan->id,
            'field_name' => 'Jenis Tanaman',
            'field_key' => 'jenis_tanaman',
            'field_type' => 'select',
            'field_options' => ['Padi', 'Jagung', 'Kedelai', 'Kacang Tanah', 'Ubi Kayu', 'Ubi Jalar'],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $tanamanPangan->id,
            'field_name' => 'Luas Lahan (Ha)',
            'field_key' => 'luas_lahan',
            'field_type' => 'number',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $tanamanPangan->id,
            'field_name' => 'Produksi (Ton)',
            'field_key' => 'produksi',
            'field_type' => 'number',
            'is_required' => true,
            'sort_order' => 3,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $tanamanPangan->id,
            'field_name' => 'Harga Jual (Rp/Kg)',
            'field_key' => 'harga_jual',
            'field_type' => 'number',
            'is_required' => true,
            'sort_order' => 4,
        ]);

        // Hortikultura
        $hortikultura = ReportCategory::create([
            'name' => 'Hortikultura',
            'slug' => 'hortikultura',
            'description' => 'Laporan tentang tanaman hortikultura seperti sayuran dan buah-buahan.',
            'is_active' => true,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $hortikultura->id,
            'field_name' => 'Jenis Tanaman',
            'field_key' => 'jenis_tanaman',
            'field_type' => 'select',
            'field_options' => ['Cabai', 'Tomat', 'Terong', 'Kentang', 'Bawang Merah', 'Kangkung', 'Bayam', 'Mangga', 'Jeruk', 'Pisang'],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $hortikultura->id,
            'field_name' => 'Luas Lahan (Ha)',
            'field_key' => 'luas_lahan',
            'field_type' => 'number',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $hortikultura->id,
            'field_name' => 'Produksi (Ton)',
            'field_key' => 'produksi',
            'field_type' => 'number',
            'is_required' => true,
            'sort_order' => 3,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $hortikultura->id,
            'field_name' => 'Kendala Utama',
            'field_key' => 'kendala_utama',
            'field_type' => 'textarea',
            'is_required' => false,
            'sort_order' => 4,
        ]);

        // Perkebunan
        $perkebunan = ReportCategory::create([
            'name' => 'Perkebunan',
            'slug' => 'perkebunan',
            'description' => 'Laporan tentang tanaman perkebunan seperti kelapa sawit, karet, kopi, dll.',
            'is_active' => true,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $perkebunan->id,
            'field_name' => 'Jenis Komoditas',
            'field_key' => 'jenis_komoditas',
            'field_type' => 'select',
            'field_options' => ['Kelapa Sawit', 'Karet', 'Kopi', 'Kakao', 'Kelapa', 'Tebu', 'Tembakau'],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $perkebunan->id,
            'field_name' => 'Luas Areal (Ha)',
            'field_key' => 'luas_areal',
            'field_type' => 'number',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $perkebunan->id,
            'field_name' => 'Status',
            'field_key' => 'status',
            'field_type' => 'select',
            'field_options' => ['Produksi', 'Non-Produksi'],
            'is_required' => true,
            'sort_order' => 3,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $perkebunan->id,
            'field_name' => 'Tahun Tanam',
            'field_key' => 'tahun_tanam',
            'field_type' => 'number',
            'is_required' => false,
            'sort_order' => 4,
        ]);

        // Peternakan
        $peternakan = ReportCategory::create([
            'name' => 'Peternakan',
            'slug' => 'peternakan',
            'description' => 'Laporan tentang peternakan dan produksi hewan ternak.',
            'is_active' => true,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $peternakan->id,
            'field_name' => 'Jenis Hewan Ternak',
            'field_key' => 'jenis_hewan_ternak',
            'field_type' => 'select',
            'field_options' => ['Sapi', 'Kerbau', 'Kambing', 'Domba', 'Ayam', 'Bebek', 'Ikan'],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $peternakan->id,
            'field_name' => 'Jumlah Ternak',
            'field_key' => 'jumlah_ternak',
            'field_type' => 'number',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $peternakan->id,
            'field_name' => 'Angka Kematian',
            'field_key' => 'angka_kematian',
            'field_type' => 'number',
            'is_required' => false,
            'sort_order' => 3,
        ]);

        ReportTemplateField::create([
            'report_category_id' => $peternakan->id,
            'field_name' => 'Produksi (Kg/Liter)',
            'field_key' => 'produksi',
            'field_type' => 'number',
            'is_required' => false,
            'sort_order' => 4,
        ]);
    }
}