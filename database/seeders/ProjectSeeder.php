<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Sistem Katalog Mebel + Web AR',
                'client' => 'CV Kalingga Jati (Bangsri)',
                'image_path' => '/portfolio_mebel.png',
                'category' => 'Website Katalog 3D',
                'description' => 'Sebuah website katalog produk furnitur mewah dengan teknologi modern Augmented Reality (Web AR). Pelanggan luar kota dapat menaruh visual sofa 3D secara presisi di ruang tamu mereka langsung lewat kamera HP tanpa download aplikasi tambahan.',
                'tech' => ['Laravel 11', 'Vue 3', 'Tailwind v4', 'Inertia.js', 'Model-viewer (3D/AR)'],
                'impact' => 'Meningkatkan closing rate penjualan luar pulau hingga 45% dan mencegah retur salah ukuran.',
                'wa_message' => 'Halo JasaWeb Cluwak, saya tertarik untuk bertanya tentang pembuatan Website Katalog Mebel + Web AR seperti projek CV Kalingga Jati...',
                'is_visible' => true,
                'order_index' => 1,
            ],
            [
                'title' => 'Sistem Kasir & Stok Gudang (ERP POS)',
                'client' => 'UD Berkah Rimba (Donorojo)',
                'image_path' => '/portfolio_pos.png',
                'category' => 'Sistem Internal Kustom',
                'description' => 'Sistem kasir dan manajemen stok kayu kustom yang dirancang khusus untuk industri pengolahan kayu and mebel. Melacak bahan baku kayu gelondong, barang setengah jadi, hingga mebel siap kirim secara real-time.',
                'tech' => ['Laravel', 'Vue 3', 'MySQL', 'Inertia.js', 'Tailwind CSS'],
                'impact' => 'Memotong waktu stock opname dari 3 hari menjadi 30 menit serta menutup celah kebocoran kasir.',
                'wa_message' => 'Halo JasaWeb Cluwak, saya tertarik untuk bertanya tentang Sistem Kasir & Manajemen Stok kustom seperti projek UD Berkah Rimba...',
                'is_visible' => true,
                'order_index' => 2,
            ],
            [
                'title' => 'Sistem Tiketing & Tracking Ekspedisi',
                'client' => 'PO Bus & Cargo Logistik (Pati)',
                'image_path' => '/portfolio_cargo.png',
                'category' => 'Sistem Kustom Web',
                'description' => 'Web portal pelacakan armada ekspedisi mebel real-time terintegrasi Google Maps. Memungkinkan pelanggan mengecek status pengiriman barang furnitur mereka secara mandiri tanpa membebani customer service.',
                'tech' => ['Laravel', 'Inertia.js', 'Google Maps API', 'Vue 3', 'Pusher Real-time'],
                'impact' => 'Mengurangi beban telepon komplain ke admin hingga 80% dan meningkatkan kepercayaan pelanggan.',
                'wa_message' => 'Halo JasaWeb Cluwak, saya tertarik dengan Sistem Tiketing & Cargo Tracking seperti di projek PO Bus & Cargo...',
                'is_visible' => true,
                'order_index' => 3,
            ],
            [
                'title' => 'Elegant Business Profile Landing Page',
                'client' => 'Cluwak Furniture Exporter',
                'image_path' => '/portfolio_profile.png',
                'category' => 'Website Profil Luxury',
                'description' => 'Website profil bisnis eksportir mebel dengan standar desain luxury internasional. Kecepatan loading dioptimalkan secara ekstrem untuk kenyamanan pengunjung luar negeri dengan jaminan mobile responsive.',
                'tech' => ['Vite Vue', 'Tailwind v4', 'Anime.js', 'PostgreSQL'],
                'impact' => 'Membantu meyakinkan pembeli luar negeri dan memantapkan kredibilitas ekspor di pasar global.',
                'wa_message' => 'Halo JasaWeb Cluwak, saya tertarik untuk membuat Website Profil Bisnis Premium / Landing Page seperti di projek Cluwak Furniture Exporter...',
                'is_visible' => true,
                'order_index' => 4,
            ],
            [
                'title' => 'Sistem POS Grosir & E-Commerce',
                'client' => 'UD Lancar Jaya (Tayu)',
                'image_path' => '/portfolio_grosir.png',
                'category' => 'Sistem Internal Kustom',
                'description' => 'Sistem inventory dan kasir terintegrasi e-commerce grosir untuk mendistribusikan kebutuhan sembako lokal. Memungkinkan stock opname harian otomatis dan pencetakan invoice digital.',
                'tech' => ['Laravel 11', 'Vue 3', 'MySQL', 'Inertia.js', 'Tailwind CSS'],
                'impact' => 'Meningkatkan efisiensi penjualan grosir sembako sebesar 60% dan mempercepat rekonsiliasi data.',
                'wa_message' => 'Halo JasaWeb Cluwak, saya tertarik dengan Sistem POS Grosir & E-Commerce kustom seperti projek UD Lancar Jaya Tayu...',
                'is_visible' => true,
                'order_index' => 5,
            ],
            [
                'title' => 'Website Profil PO Bus Pariwisata',
                'client' => 'PO Cluwak Trans (Pati)',
                'image_path' => '/portfolio_bus.png',
                'category' => 'Website Profil Luxury',
                'description' => 'Website company profile pariwisata interaktif dengan sistem cek ketersediaan armada bus, galeri unit premium 360°, dan sistem pemesanan online langsung ke tim marketing.',
                'tech' => ['Vite Vue', 'Tailwind v4', 'Anime.js', 'PostgreSQL'],
                'impact' => 'Mempermudah reservasi bus pariwisata online dan mendongkrak booking armada hingga 70%.',
                'wa_message' => 'Halo JasaWeb Cluwak, saya tertarik untuk membuat Website Profil PO Bus Pariwisata seperti di projek PO Cluwak Trans...',
                'is_visible' => true,
                'order_index' => 6,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
