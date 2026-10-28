-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Okt 2026 pada 09.58
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_shop`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(2, 4, 2, 1, '2026-10-28 08:54:06', '2026-10-28 08:54:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'fa-tag',
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Smartphone & Gadget', 'smartphone-gadget', 'fa-mobile-screen-button', 'Smartphone flagship terbaru, tablet canggih, dan aksesoris komunikasi premium.', 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&auto=format&fit=crop&q=80', '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(2, 'Laptop & Komputer', 'laptop-komputer', 'fa-laptop', 'Laptop ultra-thin, PC Gaming performa tinggi, dan workstation profesional.', 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&auto=format&fit=crop&q=80', '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(3, 'Audio & Headset', 'audio-headset', 'fa-headphones', 'Headphone noise cancelling, TWS earbuds bass mendalam, dan speaker bluetooth.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&auto=format&fit=crop&q=80', '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(4, 'Smart Watch & Band', 'smart-watch-band', 'fa-clock', 'Jam tangan pintar pendeteksi kesehatan, GPS olahraga, dan desain elegan.', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&auto=format&fit=crop&q=80', '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(5, 'Kamera & Fotografi', 'kamera-fotografi', 'fa-camera', 'Kamera mirrorless resolusi tinggi, action camera tahan air, dan lensa sinema.', 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=400&auto=format&fit=crop&q=80', '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(6, 'Gaming & Konsol', 'gaming-konsol', 'fa-gamepad', 'Konsol gaming generasi terbaru, controller mekanikal, dan peripheral e-sports.', 'https://images.unsplash.com/photo-1600080972464-8e5f35f63d08?w=400&auto=format&fit=crop&q=80', '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(7, 'Smart Home & IoT', 'smart-home-iot', 'fa-house-signal', 'Lampu pintar automasi, CCTV WiFi 360, robot vacuum, dan asisten rumah digital.', 'https://images.unsplash.com/photo-1558002038-1055907df827?w=400&auto=format&fit=crop&q=80', '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(8, 'Aksesoris & Charger', 'aksesoris-charger', 'fa-plug', 'Charger GaN fast charging 65W+, kabel braided kuat, dan power bank kapasitas besar.', 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=400&auto=format&fit=crop&q=80', '2026-10-28 08:51:33', '2026-10-28 08:51:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_28_000001_create_categories_table', 1),
(5, '2026_10_28_000002_create_products_table', 1),
(6, '2026_10_28_000003_create_cart_items_table', 1),
(7, '2026_10_28_000004_create_orders_table', 1),
(8, '2026_10_28_000005_create_order_items_table', 1),
(9, '2026_10_28_000006_create_reviews_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_product_amount` decimal(15,2) NOT NULL,
  `shipping_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL,
  `payment_status` enum('unpaid','paid','failed','expired') NOT NULL DEFAULT 'unpaid',
  `order_status` enum('pending','processing','shipped','completed','cancelled') NOT NULL DEFAULT 'pending',
  `snap_token` varchar(255) DEFAULT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `recipient_phone` varchar(255) NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_courier` varchar(255) NOT NULL DEFAULT 'JNE',
  `tracking_number` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `total_product_amount`, `shipping_cost`, `total_amount`, `payment_status`, `order_status`, `snap_token`, `recipient_name`, `recipient_phone`, `shipping_city`, `shipping_address`, `shipping_courier`, `tracking_number`, `notes`, `paid_at`, `shipped_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 'ORD-20261028-AC001', 2, 14999000.00, 10000.00, 15009000.00, 'paid', 'shipped', NULL, 'Rahmat Hidayat', '082165432100', 'Kota Banda Aceh', 'Jl. Teuku Umar No. 12, Lamteumen Barat', 'JNE Express', 'JNE-BND-8899210291', 'Tolong bubble wrap ekstra tebal ya gan.', '2026-10-27 08:51:33', '2026-10-28 00:51:33', NULL, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(2, 'ORD-20261028-AC002', 2, 2499000.00, 15000.00, 2514000.00, 'paid', 'completed', NULL, 'Rahmat Hidayat', '082165432100', 'Kabupaten Bireuen', 'Jl. Medan-Banda Aceh Km 217, Gandapura', 'SiCepat REG', 'SCP-BIR-99018231', NULL, '2026-10-25 08:51:33', '2026-10-26 08:51:33', '2026-10-27 08:51:33', '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(3, 'ORD-20261028-AC003', 2, 499000.00, 12000.00, 511000.00, 'unpaid', 'pending', NULL, 'Rahmat Hidayat', '082165432100', 'Kabupaten Pidie', 'Jl. Prof. A. Majid Ibrahim No. 55, Sigli', 'J&T Express', NULL, 'Segera bayar via Virtual Account.', NULL, NULL, NULL, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(4, 'ORD-20261028-PTSAA', 4, 14999000.00, 10000.00, 15009000.00, 'unpaid', 'pending', '71cebf2c-9794-4383-aabc-988fb80c14c8', 'User', '089512345678', 'Kota Banda Aceh', 'perhubungan', 'JNE Express', NULL, NULL, NULL, NULL, NULL, '2026-10-28 08:52:50', '2026-10-28 08:52:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_image`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Ultra Phone Pro X 5G 256GB Titanium Gray', 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=800&auto=format&fit=crop&q=80', 14999000.00, 1, 14999000.00, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(2, 2, 3, 'Studio Wireless ANC Headphone BassBoost Pro', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&auto=format&fit=crop&q=80', 2499000.00, 1, 2499000.00, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(3, 3, 8, 'PowerVolt 100W GaN Fast Charger 4-Port Type-C PD3.0', 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=800&auto=format&fit=crop&q=80', 499000.00, 1, 499000.00, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(4, 4, 1, 'Ultra Phone Pro X 5G 256GB Titanium Gray', 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=800&auto=format&fit=crop&q=80', 14999000.00, 1, 14999000.00, '2026-10-28 08:52:50', '2026-10-28 08:52:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `specification` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `original_price` decimal(15,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `weight` int(11) NOT NULL DEFAULT 500,
  `image` varchar(255) NOT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `rating_avg` decimal(3,2) NOT NULL DEFAULT 5.00,
  `rating_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `specification`, `price`, `original_price`, `stock`, `weight`, `image`, `gallery`, `is_featured`, `rating_avg`, `rating_count`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ultra Phone Pro X 5G 256GB Titanium Gray', 'ultra-phone-pro-x-5g-256gb-titanium-gray', 'Ultra Phone Pro X 5G menghadirkan performa tingkat atas dengan prosesor generasi terkini Octa-Core 4nm, layar Dynamic AMOLED 2X 120Hz adaptif, dan bodi berbalut Titanium kelas aerospace yang kokoh sekaligus ringan di tangan.\r\n\r\nDilengkapi sistem kamera Pro Quad 200MP dengan sensor ISOCELL terbaru yang mampu menangkap detail menakjubkan dalam pencahayaan malam ekstrem sekalipun. Daya tahan baterai 5000mAh mendukung fast charging 65W dan wireless charging 25W.', '• Layar: 6.8 inch Dynamic AMOLED 2X QHD+ 120Hz HDR10+\r\n• Chipset: Snapdragon 8 Gen 3 (4nm)\r\n• RAM & Storage: 12GB LPDDR5X / 256GB UFS 4.0\r\n• Kamera Belakang: 200MP (OIS) + 50MP Periscope Telephoto + 12MP Ultrawide\r\n• Kamera Depan: 32MP Auto-focus 4K 60fps\r\n• Baterai: 5000 mAh, Fast Charging 65W, Qi Wireless Charging\r\n• Fitur Lain: IP68 Water & Dust Resistant, Gorilla Glass Armor, Stereo Speakers AKG', 14999000.00, 16499000.00, 15, 210, 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=800&auto=format&fit=crop&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1511707171634-5f897ff02aa9?w=800&auto=format&fit=crop&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1580910051074-3eb694886505?w=800&auto=format&fit=crop&q=80\"]', 1, 4.90, 18, '2026-10-28 08:51:33', '2026-10-28 08:56:36'),
(2, 2, 'ZenBook Aero 14 OLED Intel Core Ultra 7 32GB RAM 1TB SSD', 'zenbook-aero-14-oled-intel-core-ultra-7-32gb-ram-1tb-ssd', 'Laptop ultra-ringan dengan bobot hanya 1.2 kg, ditenagai prosesor bertenaga kecerdasan buatan (NPU AI) terintegrasi. Layar Lumina OLED 2.8K 120Hz memanjakan mata dengan warna 100% DCI-P3 akurat untuk para konten kreator dan pebisnis profesional.', '• Prosesor: Intel Core Ultra 7 155H (16 Cores, up to 4.8 GHz)\n• Grafis: Intel Arc Graphics terintegrasi\n• Layar: 14.0 inch 2.8K (2880 x 1800) OLED 16:10, 120Hz 0.2ms, 600 nits\n• Memori: 32GB LPDDR5X on-board\n• Penyimpanan: 1TB M.2 NVMe PCIe 4.0 SSD\n• Bobot: 1.20 kg dengan baterai 75Wh tahan hingga 15 jam\n• Konektivitas: 2x Thunderbolt 4, Wi-Fi 7, Bluetooth 5.4', 18499000.00, 20999000.00, 8, 1200, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1517336714731-489689fd1ca8?w=800&auto=format&fit=crop&q=80\"]', 1, 4.80, 12, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(3, 3, 'Studio Wireless ANC Headphone BassBoost Pro', 'studio-wireless-anc-headphone-bassboost-pro', 'Nikmati suara audio resolusi tinggi tanpa gangguan bising dengan teknologi Active Noise Cancelling (ANC) hibrida tercanggih. Earpad memory foam mewah memastikan kenyamanan pemakaian sepanjang hari.', '• Driver: 40mm Custom High-Res Dynamic Drivers\n• ANC: Hibrida 4-Microphone Active Noise Cancellation up to -42dB\n• Baterai: 60 Jam Non-Stop (ANC Off) / 45 Jam (ANC On)\n• Fast Charging: 10 menit charge untuk 5 jam playback\n• Codec: LDAC, AAC, SBC, Bluetooth 5.3 Multipoint Connection', 2499000.00, 3199000.00, 25, 280, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&auto=format&fit=crop&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1484704849700-f032a568e944?w=800&auto=format&fit=crop&q=80\"]', 1, 5.00, 34, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(4, 4, 'Apex Pro Smartwatch Titanium Case Sapphire Glass GPS', 'apex-pro-smartwatch-titanium-case-sapphire-glass-gps', 'Smartwatch adventure tangguh berbalut casing Titanium dan kaca Sapphire anti gores. Dilengkapi sensor kesehatan presisi untuk ECG, detak jantung, SpO2, pola tidur, serta navigasi GPS frekuensi ganda.', '• Material: Bodi Titanium Aerospasial & Kaca Safir Kristal\n• Layar: 1.43 inch AMOLED Always-on Display, 1000 nits\n• Ketahanan Air: 5 ATM (Hingga 50 meter) tahan berenang & diving\n• Baterai: Hingga 14 hari pemakaian normal\n• Sensor: Detak Jantung Optik 24 Jam, SpO2, ECG, Barometer Altimeter, Dual GPS', 4299000.00, 4999000.00, 19, 65, 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&auto=format&fit=crop&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1508685096489-7aacd43bd3b1?w=800&auto=format&fit=crop&q=80\"]', 1, 4.70, 22, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(5, 5, 'Lumix Alpha 7 IV Mirrorless Camera Body Only 33MP 4K60p', 'lumix-alpha-7-iv-mirrorless-camera-body-only-33mp-4k60p', 'Kamera hybrid standar emas industri foto & video. Sensor full-frame Exmor R 33MP dipadukan mesin pemroses BIONZ XR menghadirkan autofokus Real-time Eye AF secepat kilat untuk manusia, hewan, dan burung.', '• Sensor: 33MP Full-Frame Exmor R Back-Illuminated CMOS\n• Perekaman: 4K 60p 10-Bit 4:2:2, S-Cinetone, S-Log3\n• Stabilisasi: 5.5-Stop 5-Axis In-Body Image Stabilization\n• Autofokus: 759-Point Phase Detection AF dengan AI Tracking\n• Slot: Dual Card Slots (CFexpress Type A / SD UHS-II)', 26999000.00, 29499000.00, 6, 658, 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&auto=format&fit=crop&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1516035069371-29a1b244cc32?w=800&auto=format&fit=crop&q=80\"]', 1, 4.90, 15, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(6, 6, 'NextGen Gaming Station 5 Slim Digital Edition 1TB SSD', 'nextgen-gaming-station-5-slim-digital-edition-1tb-ssd', 'Rasakan pengalaman bermain game generasi terbaru dengan loading secepat kedipan mata berkat SSD custom 1TB ultra-high speed, haptic feedback controller nirkabel, dan grafis ray tracing 4K 120 FPS memukau.', '• CPU: x86-64-AMD Ryzen Zen 2 (8 Cores / 16 Threads)\n• GPU: AMD Radeon RDNA 2-based Graphics Engine 10.3 TFLOPS\n• Memori: GDDR6 16GB dengan bandwidth 448 GB/s\n• SSD: 1TB Custom High-Speed NVMe PCIe 4.0\n• Audio: Tempest 3D AudioTech untuk suara spasial realistis', 7899000.00, 8499000.00, 10, 2600, 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=800&auto=format&fit=crop&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1600080972464-8e5f35f63d08?w=800&auto=format&fit=crop&q=80\"]', 1, 5.00, 45, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(7, 7, 'Smart Clean Robot Vacuum & Mop Auto-Empty Station 5000Pa', 'smart-clean-robot-vacuum-mop-auto-empty-station-5000pa', 'Solusi kebersihan rumah pintar otomatis. Menyedot debu dengan daya hisap badai 5000Pa sekaligus mengepel lantai secara cerdas. Dilengkapi dock pengosongan debu otomatis tahan hingga 60 hari tanpa sentuhan tangan.', '• Daya Hisap: 5000Pa Hurricane Suction\n• Navigasi: LiDAR LDS 360 Laser Mapping & 3D Obstacle Avoidance\n• Fungsi: Sapu + Pel Elektrik dengan tekanan konstan\n• Baterai: 5200 mAh, sanggup membersihkan area hingga 250 m²\n• Kontrol: Aplikasi Android/iOS, integrasi Google Home & Alexa', 5499000.00, 6299000.00, 14, 4500, 'https://images.unsplash.com/photo-1558002038-1055907df827?w=800&auto=format&fit=crop&q=80', '[]', 0, 4.60, 9, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(8, 8, 'PowerVolt 100W GaN Fast Charger 4-Port Type-C PD3.0', 'powervolt-100w-gan-fast-charger-4-port-type-c-pd30', 'Satu charger untuk semua gadget Anda! Menggunakan teknologi Semikonduktor Gallium Nitride (GaN III) yang menjaga ukuran 40% lebih ringkas dengan efisiensi daya tinggi dan kontrol suhu dingin maksimal.', '• Total Output: 100W Max\n• Port: 3x USB Type-C + 1x USB-A\n• Kompatibilitas: MacBook Pro/Air, Laptop Windows, iPhone, iPad, Samsung 45W PPS\n• Proteksi: Over-Voltage, Over-Current, Short Circuit, Smart Temp Guard', 499000.00, 699000.00, 50, 200, 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=800&auto=format&fit=crop&q=80', '[]', 0, 4.90, 40, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(9, 1, 'SmartPad Air 11-inch M2 Chip 128GB Wi-Fi Space Gray', 'smartpad-air-11-inch-m2-chip-128gb-wi-fi-space-gray', 'Tablet bertenaga chip M2 legendaris yang menghadirkan performa grafis 35% lebih kencang untuk ilustrasi digital, editing video 4K, dan multitasking intensif dengan layar Liquid Retina cerah.', '• Layar: 11 inch Liquid Retina Display dengan True Tone & P3 Wide Color\n• Chip: Apple M2 (8-Core CPU, 10-Core GPU)\n• Kamera: 12MP Wide Depan Center Stage + 12MP Belakang\n• Aksesoris Pendukung: Magic Keyboard & Apple Pencil Pro', 10999000.00, 11999000.00, 12, 462, 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800&auto=format&fit=crop&q=80', '[]', 1, 4.80, 19, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(10, 3, 'AirBeats Pro True Wireless Earbuds ANC Spatial Audio', 'airbeats-pro-true-wireless-earbuds-anc-spatial-audio', 'Earbuds TWS kelas flagship dengan dentuman bass solid, isolasi suara aktif ANC adaptif, mikrofon peredam angin berteknologi AI untuk panggilan suara jernih di keramaian.', '• Suara: 11mm Wool-Composite Dynamic Drivers\n• Fitur: Active Noise Cancelling (ANC), Transparency Mode, 360 Spatial Audio\n• Daya Tahan: 8 Jam (Earbuds) + 28 Jam (Charging Case)\n• Ketahanan: IPX5 Splash & Sweat Resistant', 1899000.00, 2399000.00, 30, 50, 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=800&auto=format&fit=crop&q=80', '[]', 0, 4.70, 28, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(11, 6, 'CyberPulse Mechanical Wireless RGB Gaming Keyboard Hot-Swappable', 'cyberpulse-mechanical-wireless-rgb-gaming-keyboard-hot-swappable', 'Keyboard mekanikal 75% compact dengan switch gateron factory lubed super empuk dan sound profile \'thocky\' yang memuaskan. Tri-mode koneksi nirkabel Bluetooth 5.1, 2.4GHz Dongle, dan USB-C.', '• Layout: 75% Compact (82 Keys) dengan Volume Rotary Knob Alumunium\n• Switch: Hot-Swappable Linear Silver Switches (5-Pin PCB)\n• Keycaps: PBT Double-Shot OEM Profile tahan kilap\n• Baterai: 4000 mAh rechargeable dengan lampu RGB 16.8 Juta Warna', 1250000.00, 1550000.00, 22, 850, 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&auto=format&fit=crop&q=80', '[]', 0, 4.90, 16, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(12, 8, 'ArmorShield Heavy-Duty Braided 100W USB-C to USB-C Cable 2 Meter', 'armorshield-heavy-duty-braided-100w-usb-c-to-usb-c-cable-2-meter', 'Kabel data dan charging bersertifikasi E-Marker chip mendukung daya hingga 100W (20V/5A). Lapisan nilon balistik tebal tahan tekukan hingga 30.000 kali uji laboratorium.', '• Panjang: 2.0 Meter\n• Daya Dukung: 100W Fast Charging Power Delivery (PD 3.0 / QC 4.0)\n• Kecepatan Data: USB 2.0 480 Mbps\n• Material: Zinc Alloy Shell + High-Density Nylon Braided Wire', 129000.00, 189000.00, 75, 80, 'https://images.unsplash.com/photo-1616440347437-b1c73416efc2?w=800&auto=format&fit=crop&q=80', '[]', 0, 5.00, 52, '2026-10-28 08:51:33', '2026-10-28 08:51:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `comment` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `order_id`, `rating`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 2, 5, 'Kualitas audio mantap luar biasa! Suara bass empuk dan noise cancelling benar-benar memutus suara bising di sekitar. Pengiriman ke Bireuen juga sangat kilat!', 1, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(2, 3, 1, NULL, 5, 'Barang original 100%, segel garansi resmi. Layar AMOLED luar biasa jernih dan kamera tajam banget. Rekomendasi belanja gadget terpercaya di Aceh!', 1, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(3, 3, 6, NULL, 5, 'Konsol idaman akhirnya sampai dengan selamat. Packaging kayu dan bubble wrap sangat aman. Game lancar di 120fps!', 1, '2026-10-28 08:51:33', '2026-10-28 08:51:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `city`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator SmartShop', 'admin@smartshop.com', NULL, '$2y$12$VIVkMO3a9IsbOU9XzhFoi.c/i7WJdxKTt6iYt1taO8rwYqSF.KmXG', 'admin', '081269001122', 'Jl. T. Nyak Arief No. 45, Syiah Kuala', 'Kota Banda Aceh', NULL, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(2, 'Rahmat Hidayat', 'customer@smartshop.com', NULL, '$2y$12$27BN6hntr1To3bS4jxdIk.kMVKFYm2rTkHtiWqdeHP9juwJ88OB3e', 'customer', '082165432100', 'Jl. Teuku Umar No. 12, Lamteumen', 'Kota Banda Aceh', NULL, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(3, 'Cut Sarah Melinda', 'cutsarah@gmail.com', NULL, '$2y$12$hL..cvm37KsnL9h6HB7VkOU7Q.zAEQouUPCdlNU8rs28M9En9WkTa', 'customer', '085277112233', 'Komplek Keude Bireuen No. 8', 'Kabupaten Bireuen', NULL, '2026-10-28 08:51:33', '2026-10-28 08:51:33'),
(4, 'User', 'user@gmail.com', NULL, '$2y$12$03nMT6cfC0D3/0AufZg8U.DntrYDv7TjBa7F/wAQjECA3EDVYzPQq', 'customer', '089512345678', NULL, NULL, NULL, '2026-10-28 08:52:26', '2026-10-28 08:52:26'),
(5, 'Admin', 'admin@gmail.com', NULL, '$2y$12$k1ca9d0dwO//PWe.itTzqebXB4jLjngwZCPeBwt6Lyfjljc6ibcNW', 'admin', '081265637364', NULL, NULL, NULL, '2026-10-28 08:55:02', '2026-10-28 08:55:02');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_order_id_foreign` (`order_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
