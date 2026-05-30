<?php

namespace Database\Seeders;

use App\Models\PricingPackage;
use Illuminate\Database\Seeder;

class PricingPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PricingPackage::create([
            'name' => 'Paket Starter',
            'tagline' => 'Layanan Web Profesional JasaWeb, Harga Transparan',
            'price' => 'Rp 2.999.000',
            'slashed_price' => 'Rp 3.500.000',
            'features' => [
                '5 Halaman Web',
                'Hosting Standar',
                'Domain .com (1 Tahun)',
                'Desain Modern',
                'Integrasi WhatsApp Dasar',
            ],
            'is_popular' => false,
            'wa_text' => 'Halo JasaWeb Cluwak, saya tertarik untuk memesan Paket Starter untuk bisnis saya...',
            'order_index' => 0,
        ]);

        PricingPackage::create([
            'name' => 'Paket Bisnis Pro',
            'tagline' => 'Layanan Web Profesional JasaWeb, Harga Transparan',
            'price' => 'Rp 6.499.000',
            'slashed_price' => 'Rp 7.500.000',
            'features' => [
                '15 Halaman Web',
                'Hosting Lebih Besar',
                'Desain Kustom Unik',
                'Katalog Produk Interaktif',
                'Integrasi SEO Dasar',
                'Support WhatsApp',
            ],
            'is_popular' => true,
            'wa_text' => 'Halo JasaWeb Cluwak, saya tertarik dengan Paket Bisnis Pro yang sangat populer...',
            'order_index' => 1,
        ]);

        PricingPackage::create([
            'name' => 'Paket Premium AR & Kasir',
            'tagline' => 'Layanan Web Profesional JasaWeb, Harga Transparan',
            'price' => 'Harga Kustom',
            'slashed_price' => null,
            'features' => [
                'Halaman Tanpa Batas',
                'Hosting Premium',
                'Desain Eksklusif',
                'Fitur Katalog Mebel 3D (Web AR)',
                'Sistem Kasir Kustom Pati',
                'Integrasi Pembayaran Bertahap',
                'Support Prioritas + Pelatihan',
            ],
            'is_popular' => false,
            'wa_text' => 'Halo JasaWeb Cluwak, saya ingin berkonsultasi mengenai Paket Premium AR & Kasir untuk alur bisnis saya...',
            'order_index' => 2,
        ]);
    }
}
