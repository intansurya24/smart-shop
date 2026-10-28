<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::create([
            'name' => 'Administrator SmartShop',
            'email' => 'admin@smartshop.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081269001122',
            'address' => 'Jl. T. Nyak Arief No. 45, Syiah Kuala',
            'city' => 'Kota Banda Aceh',
        ]);

        $customer = User::create([
            'name' => 'Rahmat Hidayat',
            'email' => 'customer@smartshop.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '082165432100',
            'address' => 'Jl. Teuku Umar No. 12, Lamteumen',
            'city' => 'Kota Banda Aceh',
        ]);

        $customer2 = User::create([
            'name' => 'Cut Sarah Melinda',
            'email' => 'cutsarah@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '085277112233',
            'address' => 'Komplek Keude Bireuen No. 8',
            'city' => 'Kabupaten Bireuen',
        ]);

        // 2. Seed Categories (8 categories as specified in mockup)
        $categoriesData = [
            [
                'name' => 'Smartphone & Gadget',
                'slug' => 'smartphone-gadget',
                'icon' => 'fa-mobile-screen-button',
                'description' => 'Smartphone flagship terbaru, tablet canggih, dan aksesoris komunikasi premium.',
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Laptop & Komputer',
                'slug' => 'laptop-komputer',
                'icon' => 'fa-laptop',
                'description' => 'Laptop ultra-thin, PC Gaming performa tinggi, dan workstation profesional.',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Audio & Headset',
                'slug' => 'audio-headset',
                'icon' => 'fa-headphones',
                'description' => 'Headphone noise cancelling, TWS earbuds bass mendalam, dan speaker bluetooth.',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Smart Watch & Band',
                'slug' => 'smart-watch-band',
                'icon' => 'fa-clock',
                'description' => 'Jam tangan pintar pendeteksi kesehatan, GPS olahraga, dan desain elegan.',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Kamera & Fotografi',
                'slug' => 'kamera-fotografi',
                'icon' => 'fa-camera',
                'description' => 'Kamera mirrorless resolusi tinggi, action camera tahan air, dan lensa sinema.',
                'image' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Gaming & Konsol',
                'slug' => 'gaming-konsol',
                'icon' => 'fa-gamepad',
                'description' => 'Konsol gaming generasi terbaru, controller mekanikal, dan peripheral e-sports.',
                'image' => 'https://images.unsplash.com/photo-1600080972464-8e5f35f63d08?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Smart Home & IoT',
                'slug' => 'smart-home-iot',
                'icon' => 'fa-house-signal',
                'description' => 'Lampu pintar automasi, CCTV WiFi 360, robot vacuum, dan asisten rumah digital.',
                'image' => 'https://images.unsplash.com/photo-1558002038-1055907df827?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Aksesoris & Charger',
                'slug' => 'aksesoris-charger',
                'icon' => 'fa-plug',
                'description' => 'Charger GaN fast charging 65W+, kabel braided kuat, dan power bank kapasitas besar.',
                'image' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=400&auto=format&fit=crop&q=80',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cData) {
            $categories[$cData['slug']] = Category::create($cData);
        }

        // 3. Seed Products (12+ realistic products)
        $productsData = [
            [
                'category_slug' => 'smartphone-gadget',
                'name' => 'Ultra Phone Pro X 5G 256GB Titanium Gray',
                'price' => 14999000,
                'original_price' => 16499000,
                'stock' => 15,
                'weight' => 210,
                'is_featured' => true,
                'rating_avg' => 4.9,
                'rating_count' => 18,
                'image' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1580910051074-3eb694886505?w=800&auto=format&fit=crop&q=80',
                ],
                'description' => "Ultra Phone Pro X 5G menghadirkan performa tingkat atas dengan prosesor generasi terkini Octa-Core 4nm, layar Dynamic AMOLED 2X 120Hz adaptif, dan bodi berbalut Titanium kelas aerospace yang kokoh sekaligus ringan di tangan.\n\nDilengkapi sistem kamera Pro Quad 200MP dengan sensor ISOCELL terbaru yang mampu menangkap detail menakjubkan dalam pencahayaan malam ekstrem sekalipun. Daya tahan baterai 5000mAh mendukung fast charging 65W dan wireless charging 25W.",
                'specification' => "• Layar: 6.8 inch Dynamic AMOLED 2X QHD+ 120Hz HDR10+\n• Chipset: Snapdragon 8 Gen 3 (4nm)\n• RAM & Storage: 12GB LPDDR5X / 256GB UFS 4.0\n• Kamera Belakang: 200MP (OIS) + 50MP Periscope Telephoto + 12MP Ultrawide\n• Kamera Depan: 32MP Auto-focus 4K 60fps\n• Baterai: 5000 mAh, Fast Charging 65W, Qi Wireless Charging\n• Fitur Lain: IP68 Water & Dust Resistant, Gorilla Glass Armor, Stereo Speakers AKG",
            ],
            [
                'category_slug' => 'laptop-komputer',
                'name' => 'ZenBook Aero 14 OLED Intel Core Ultra 7 32GB RAM 1TB SSD',
                'price' => 18499000,
                'original_price' => 20999000,
                'stock' => 8,
                'weight' => 1200,
                'is_featured' => true,
                'rating_avg' => 4.8,
                'rating_count' => 12,
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800&auto=format&fit=crop&q=80',
                ],
                'description' => "Laptop ultra-ringan dengan bobot hanya 1.2 kg, ditenagai prosesor bertenaga kecerdasan buatan (NPU AI) terintegrasi. Layar Lumina OLED 2.8K 120Hz memanjakan mata dengan warna 100% DCI-P3 akurat untuk para konten kreator dan pebisnis profesional.",
                'specification' => "• Prosesor: Intel Core Ultra 7 155H (16 Cores, up to 4.8 GHz)\n• Grafis: Intel Arc Graphics terintegrasi\n• Layar: 14.0 inch 2.8K (2880 x 1800) OLED 16:10, 120Hz 0.2ms, 600 nits\n• Memori: 32GB LPDDR5X on-board\n• Penyimpanan: 1TB M.2 NVMe PCIe 4.0 SSD\n• Bobot: 1.20 kg dengan baterai 75Wh tahan hingga 15 jam\n• Konektivitas: 2x Thunderbolt 4, Wi-Fi 7, Bluetooth 5.4",
            ],
            [
                'category_slug' => 'audio-headset',
                'name' => 'Studio Wireless ANC Headphone BassBoost Pro',
                'price' => 2499000,
                'original_price' => 3199000,
                'stock' => 25,
                'weight' => 280,
                'is_featured' => true,
                'rating_avg' => 5.0,
                'rating_count' => 34,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&auto=format&fit=crop&q=80',
                ],
                'description' => "Nikmati suara audio resolusi tinggi tanpa gangguan bising dengan teknologi Active Noise Cancelling (ANC) hibrida tercanggih. Earpad memory foam mewah memastikan kenyamanan pemakaian sepanjang hari.",
                'specification' => "• Driver: 40mm Custom High-Res Dynamic Drivers\n• ANC: Hibrida 4-Microphone Active Noise Cancellation up to -42dB\n• Baterai: 60 Jam Non-Stop (ANC Off) / 45 Jam (ANC On)\n• Fast Charging: 10 menit charge untuk 5 jam playback\n• Codec: LDAC, AAC, SBC, Bluetooth 5.3 Multipoint Connection",
            ],
            [
                'category_slug' => 'smart-watch-band',
                'name' => 'Apex Pro Smartwatch Titanium Case Sapphire Glass GPS',
                'price' => 4299000,
                'original_price' => 4999000,
                'stock' => 19,
                'weight' => 65,
                'is_featured' => true,
                'rating_avg' => 4.7,
                'rating_count' => 22,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=800&auto=format&fit=crop&q=80',
                ],
                'description' => "Smartwatch adventure tangguh berbalut casing Titanium dan kaca Sapphire anti gores. Dilengkapi sensor kesehatan presisi untuk ECG, detak jantung, SpO2, pola tidur, serta navigasi GPS frekuensi ganda.",
                'specification' => "• Material: Bodi Titanium Aerospasial & Kaca Safir Kristal\n• Layar: 1.43 inch AMOLED Always-on Display, 1000 nits\n• Ketahanan Air: 5 ATM (Hingga 50 meter) tahan berenang & diving\n• Baterai: Hingga 14 hari pemakaian normal\n• Sensor: Detak Jantung Optik 24 Jam, SpO2, ECG, Barometer Altimeter, Dual GPS",
            ],
            [
                'category_slug' => 'kamera-fotografi',
                'name' => 'Lumix Alpha 7 IV Mirrorless Camera Body Only 33MP 4K60p',
                'price' => 26999000,
                'original_price' => 29499000,
                'stock' => 6,
                'weight' => 658,
                'is_featured' => true,
                'rating_avg' => 4.9,
                'rating_count' => 15,
                'image' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800&auto=format&fit=crop&q=80',
                ],
                'description' => "Kamera hybrid standar emas industri foto & video. Sensor full-frame Exmor R 33MP dipadukan mesin pemroses BIONZ XR menghadirkan autofokus Real-time Eye AF secepat kilat untuk manusia, hewan, dan burung.",
                'specification' => "• Sensor: 33MP Full-Frame Exmor R Back-Illuminated CMOS\n• Perekaman: 4K 60p 10-Bit 4:2:2, S-Cinetone, S-Log3\n• Stabilisasi: 5.5-Stop 5-Axis In-Body Image Stabilization\n• Autofokus: 759-Point Phase Detection AF dengan AI Tracking\n• Slot: Dual Card Slots (CFexpress Type A / SD UHS-II)",
            ],
            [
                'category_slug' => 'gaming-konsol',
                'name' => 'NextGen Gaming Station 5 Slim Digital Edition 1TB SSD',
                'price' => 7899000,
                'original_price' => 8499000,
                'stock' => 10,
                'weight' => 2600,
                'is_featured' => true,
                'rating_avg' => 5.0,
                'rating_count' => 45,
                'image' => 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1600080972464-8e5f35f63d08?w=800&auto=format&fit=crop&q=80',
                ],
                'description' => "Rasakan pengalaman bermain game generasi terbaru dengan loading secepat kedipan mata berkat SSD custom 1TB ultra-high speed, haptic feedback controller nirkabel, dan grafis ray tracing 4K 120 FPS memukau.",
                'specification' => "• CPU: x86-64-AMD Ryzen Zen 2 (8 Cores / 16 Threads)\n• GPU: AMD Radeon RDNA 2-based Graphics Engine 10.3 TFLOPS\n• Memori: GDDR6 16GB dengan bandwidth 448 GB/s\n• SSD: 1TB Custom High-Speed NVMe PCIe 4.0\n• Audio: Tempest 3D AudioTech untuk suara spasial realistis",
            ],
            [
                'category_slug' => 'smart-home-iot',
                'name' => 'Smart Clean Robot Vacuum & Mop Auto-Empty Station 5000Pa',
                'price' => 5499000,
                'original_price' => 6299000,
                'stock' => 14,
                'weight' => 4500,
                'is_featured' => false,
                'rating_avg' => 4.6,
                'rating_count' => 9,
                'image' => 'https://images.unsplash.com/photo-1558002038-1055907df827?w=800&auto=format&fit=crop&q=80',
                'gallery' => [],
                'description' => "Solusi kebersihan rumah pintar otomatis. Menyedot debu dengan daya hisap badai 5000Pa sekaligus mengepel lantai secara cerdas. Dilengkapi dock pengosongan debu otomatis tahan hingga 60 hari tanpa sentuhan tangan.",
                'specification' => "• Daya Hisap: 5000Pa Hurricane Suction\n• Navigasi: LiDAR LDS 360 Laser Mapping & 3D Obstacle Avoidance\n• Fungsi: Sapu + Pel Elektrik dengan tekanan konstan\n• Baterai: 5200 mAh, sanggup membersihkan area hingga 250 m²\n• Kontrol: Aplikasi Android/iOS, integrasi Google Home & Alexa",
            ],
            [
                'category_slug' => 'aksesoris-charger',
                'name' => 'PowerVolt 100W GaN Fast Charger 4-Port Type-C PD3.0',
                'price' => 499000,
                'original_price' => 699000,
                'stock' => 50,
                'weight' => 200,
                'is_featured' => false,
                'rating_avg' => 4.9,
                'rating_count' => 40,
                'image' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=800&auto=format&fit=crop&q=80',
                'gallery' => [],
                'description' => "Satu charger untuk semua gadget Anda! Menggunakan teknologi Semikonduktor Gallium Nitride (GaN III) yang menjaga ukuran 40% lebih ringkas dengan efisiensi daya tinggi dan kontrol suhu dingin maksimal.",
                'specification' => "• Total Output: 100W Max\n• Port: 3x USB Type-C + 1x USB-A\n• Kompatibilitas: MacBook Pro/Air, Laptop Windows, iPhone, iPad, Samsung 45W PPS\n• Proteksi: Over-Voltage, Over-Current, Short Circuit, Smart Temp Guard",
            ],
            [
                'category_slug' => 'smartphone-gadget',
                'name' => 'SmartPad Air 11-inch M2 Chip 128GB Wi-Fi Space Gray',
                'price' => 10999000,
                'original_price' => 11999000,
                'stock' => 12,
                'weight' => 462,
                'is_featured' => true,
                'rating_avg' => 4.8,
                'rating_count' => 19,
                'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800&auto=format&fit=crop&q=80',
                'gallery' => [],
                'description' => "Tablet bertenaga chip M2 legendaris yang menghadirkan performa grafis 35% lebih kencang untuk ilustrasi digital, editing video 4K, dan multitasking intensif dengan layar Liquid Retina cerah.",
                'specification' => "• Layar: 11 inch Liquid Retina Display dengan True Tone & P3 Wide Color\n• Chip: Apple M2 (8-Core CPU, 10-Core GPU)\n• Kamera: 12MP Wide Depan Center Stage + 12MP Belakang\n• Aksesoris Pendukung: Magic Keyboard & Apple Pencil Pro",
            ],
            [
                'category_slug' => 'audio-headset',
                'name' => 'AirBeats Pro True Wireless Earbuds ANC Spatial Audio',
                'price' => 1899000,
                'original_price' => 2399000,
                'stock' => 30,
                'weight' => 50,
                'is_featured' => false,
                'rating_avg' => 4.7,
                'rating_count' => 28,
                'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=800&auto=format&fit=crop&q=80',
                'gallery' => [],
                'description' => "Earbuds TWS kelas flagship dengan dentuman bass solid, isolasi suara aktif ANC adaptif, mikrofon peredam angin berteknologi AI untuk panggilan suara jernih di keramaian.",
                'specification' => "• Suara: 11mm Wool-Composite Dynamic Drivers\n• Fitur: Active Noise Cancelling (ANC), Transparency Mode, 360 Spatial Audio\n• Daya Tahan: 8 Jam (Earbuds) + 28 Jam (Charging Case)\n• Ketahanan: IPX5 Splash & Sweat Resistant",
            ],
            [
                'category_slug' => 'gaming-konsol',
                'name' => 'CyberPulse Mechanical Wireless RGB Gaming Keyboard Hot-Swappable',
                'price' => 1250000,
                'original_price' => 1550000,
                'stock' => 22,
                'weight' => 850,
                'is_featured' => false,
                'rating_avg' => 4.9,
                'rating_count' => 16,
                'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&auto=format&fit=crop&q=80',
                'gallery' => [],
                'description' => "Keyboard mekanikal 75% compact dengan switch gateron factory lubed super empuk dan sound profile 'thocky' yang memuaskan. Tri-mode koneksi nirkabel Bluetooth 5.1, 2.4GHz Dongle, dan USB-C.",
                'specification' => "• Layout: 75% Compact (82 Keys) dengan Volume Rotary Knob Alumunium\n• Switch: Hot-Swappable Linear Silver Switches (5-Pin PCB)\n• Keycaps: PBT Double-Shot OEM Profile tahan kilap\n• Baterai: 4000 mAh rechargeable dengan lampu RGB 16.8 Juta Warna",
            ],
            [
                'category_slug' => 'aksesoris-charger',
                'name' => 'ArmorShield Heavy-Duty Braided 100W USB-C to USB-C Cable 2 Meter',
                'price' => 129000,
                'original_price' => 189000,
                'stock' => 75,
                'weight' => 80,
                'is_featured' => false,
                'rating_avg' => 5.0,
                'rating_count' => 52,
                'image' => 'https://images.unsplash.com/photo-1616440347437-b1c73416efc2?w=800&auto=format&fit=crop&q=80',
                'gallery' => [],
                'description' => "Kabel data dan charging bersertifikasi E-Marker chip mendukung daya hingga 100W (20V/5A). Lapisan nilon balistik tebal tahan tekukan hingga 30.000 kali uji laboratorium.",
                'specification' => "• Panjang: 2.0 Meter\n• Daya Dukung: 100W Fast Charging Power Delivery (PD 3.0 / QC 4.0)\n• Kecepatan Data: USB 2.0 480 Mbps\n• Material: Zinc Alloy Shell + High-Density Nylon Braided Wire",
            ],
        ];

        $seededProducts = [];
        foreach ($productsData as $p) {
            $cat = $categories[$p['category_slug']];
            $prod = Product::create([
                'category_id' => $cat->id,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => $p['description'],
                'specification' => $p['specification'],
                'price' => $p['price'],
                'original_price' => $p['original_price'],
                'stock' => $p['stock'],
                'weight' => $p['weight'],
                'image' => $p['image'],
                'gallery' => $p['gallery'] ?? [],
                'is_featured' => $p['is_featured'],
                'rating_avg' => $p['rating_avg'],
                'rating_count' => $p['rating_count'],
            ]);
            $seededProducts[] = $prod;
        }

        // 4. Seed Dummy Orders with Aceh Regencies
        $order1 = Order::create([
            'order_number' => 'ORD-20261028-AC001',
            'user_id' => $customer->id,
            'total_product_amount' => 14999000,
            'shipping_cost' => 10000,
            'total_amount' => 15009000,
            'payment_status' => 'paid',
            'order_status' => 'shipped',
            'recipient_name' => 'Rahmat Hidayat',
            'recipient_phone' => '082165432100',
            'shipping_city' => 'Kota Banda Aceh',
            'shipping_address' => 'Jl. Teuku Umar No. 12, Lamteumen Barat',
            'shipping_courier' => 'JNE Express',
            'tracking_number' => 'JNE-BND-8899210291',
            'notes' => 'Tolong bubble wrap ekstra tebal ya gan.',
            'paid_at' => now()->subDays(1),
            'shipped_at' => now()->subHours(8),
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $seededProducts[0]->id,
            'product_name' => $seededProducts[0]->name,
            'product_image' => $seededProducts[0]->image,
            'price' => $seededProducts[0]->price,
            'quantity' => 1,
            'subtotal' => $seededProducts[0]->price,
        ]);

        $order2 = Order::create([
            'order_number' => 'ORD-20261028-AC002',
            'user_id' => $customer->id,
            'total_product_amount' => 2499000,
            'shipping_cost' => 15000,
            'total_amount' => 2514000,
            'payment_status' => 'paid',
            'order_status' => 'completed',
            'recipient_name' => 'Rahmat Hidayat',
            'recipient_phone' => '082165432100',
            'shipping_city' => 'Kabupaten Bireuen',
            'shipping_address' => 'Jl. Medan-Banda Aceh Km 217, Gandapura',
            'shipping_courier' => 'SiCepat REG',
            'tracking_number' => 'SCP-BIR-99018231',
            'paid_at' => now()->subDays(3),
            'shipped_at' => now()->subDays(2),
            'completed_at' => now()->subDay(),
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $seededProducts[2]->id,
            'product_name' => $seededProducts[2]->name,
            'product_image' => $seededProducts[2]->image,
            'price' => $seededProducts[2]->price,
            'quantity' => 1,
            'subtotal' => $seededProducts[2]->price,
        ]);

        $order3 = Order::create([
            'order_number' => 'ORD-20261028-AC003',
            'user_id' => $customer->id,
            'total_product_amount' => 499000,
            'shipping_cost' => 12000,
            'total_amount' => 511000,
            'payment_status' => 'unpaid',
            'order_status' => 'pending',
            'recipient_name' => 'Rahmat Hidayat',
            'recipient_phone' => '082165432100',
            'shipping_city' => 'Kabupaten Pidie',
            'shipping_address' => 'Jl. Prof. A. Majid Ibrahim No. 55, Sigli',
            'shipping_courier' => 'J&T Express',
            'notes' => 'Segera bayar via Virtual Account.',
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $seededProducts[7]->id,
            'product_name' => $seededProducts[7]->name,
            'product_image' => $seededProducts[7]->image,
            'price' => $seededProducts[7]->price,
            'quantity' => 1,
            'subtotal' => $seededProducts[7]->price,
        ]);

        // 5. Seed Reviews
        Review::create([
            'user_id' => $customer->id,
            'product_id' => $seededProducts[2]->id,
            'order_id' => $order2->id,
            'rating' => 5,
            'comment' => 'Kualitas audio mantap luar biasa! Suara bass empuk dan noise cancelling benar-benar memutus suara bising di sekitar. Pengiriman ke Bireuen juga sangat kilat!',
            'is_approved' => true,
        ]);

        Review::create([
            'user_id' => $customer2->id,
            'product_id' => $seededProducts[0]->id,
            'rating' => 5,
            'comment' => 'Barang original 100%, segel garansi resmi. Layar AMOLED luar biasa jernih dan kamera tajam banget. Rekomendasi belanja gadget terpercaya di Aceh!',
            'is_approved' => true,
        ]);

        Review::create([
            'user_id' => $customer2->id,
            'product_id' => $seededProducts[5]->id,
            'rating' => 5,
            'comment' => 'Konsol idaman akhirnya sampai dengan selamat. Packaging kayu dan bubble wrap sangat aman. Game lancar di 120fps!',
            'is_approved' => true,
        ]);
    }
}
