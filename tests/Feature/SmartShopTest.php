<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\ShippingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmartShopTest extends TestCase
{
    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('SmartShop');
        $response->assertSee('Kategori Pilihan');
    }

    public function test_products_catalog_loads_with_filters(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('Semua');
    }

    public function test_product_detail_page_loads(): void
    {
        $product = Product::first();
        $this->assertNotNull($product);

        $response = $this->get('/products/' . $product->slug);
        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee('+ Keranjang');
        $response->assertSee('Beli Sekarang');
    }

    public function test_aceh_shipping_rates_match_requirements(): void
    {
        // 1. Banda Aceh, Aceh Besar = Rp 10.000
        $this->assertEquals(10000, ShippingService::calculateShippingFee('Kota Banda Aceh'));
        $this->assertEquals(10000, ShippingService::calculateShippingFee('Kabupaten Aceh Besar'));

        // 2. Pidie, Pidie Jaya = Rp 12.000
        $this->assertEquals(12000, ShippingService::calculateShippingFee('Kabupaten Pidie'));
        $this->assertEquals(12000, ShippingService::calculateShippingFee('Kabupaten Pidie Jaya'));

        // 3. Lhokseumawe, Aceh Utara, Bireuen = Rp 15.000
        $this->assertEquals(15000, ShippingService::calculateShippingFee('Kota Lhokseumawe'));
        $this->assertEquals(15000, ShippingService::calculateShippingFee('Kabupaten Aceh Utara'));
        $this->assertEquals(15000, ShippingService::calculateShippingFee('Kabupaten Bireuen'));

        // 4. Aceh Barat, Aceh Barat Daya, Nagan Raya = Rp 18.000
        $this->assertEquals(18000, ShippingService::calculateShippingFee('Kabupaten Aceh Barat'));
        $this->assertEquals(18000, ShippingService::calculateShippingFee('Kabupaten Aceh Barat Daya'));
        $this->assertEquals(18000, ShippingService::calculateShippingFee('Kabupaten Nagan Raya'));

        // 5. Langsa, Aceh Tamiang, Aceh Timur = Rp 20.000
        $this->assertEquals(20000, ShippingService::calculateShippingFee('Kota Langsa'));
        $this->assertEquals(20000, ShippingService::calculateShippingFee('Kabupaten Aceh Tamiang'));
        $this->assertEquals(20000, ShippingService::calculateShippingFee('Kabupaten Aceh Timur'));

        // 6. Aceh Tengah, Bener Meriah, Gayo Lues = Rp 22.000
        $this->assertEquals(22000, ShippingService::calculateShippingFee('Kabupaten Aceh Tengah'));
        $this->assertEquals(22000, ShippingService::calculateShippingFee('Kabupaten Bener Meriah'));
        $this->assertEquals(22000, ShippingService::calculateShippingFee('Kabupaten Gayo Lues'));

        // 7. Sabang, Simeulue, Aceh Singkil, Subulussalam, Aceh Selatan, Aceh Tenggara = Rp 25.000
        $this->assertEquals(25000, ShippingService::calculateShippingFee('Kota Sabang'));
        $this->assertEquals(25000, ShippingService::calculateShippingFee('Kabupaten Simeulue'));
        $this->assertEquals(25000, ShippingService::calculateShippingFee('Kabupaten Aceh Singkil'));
        $this->assertEquals(25000, ShippingService::calculateShippingFee('Kota Subulussalam'));
        $this->assertEquals(25000, ShippingService::calculateShippingFee('Kabupaten Aceh Selatan'));
        $this->assertEquals(25000, ShippingService::calculateShippingFee('Kabupaten Aceh Tenggara'));
    }

    public function test_admin_redirected_to_admin_dashboard_on_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@smartshop.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
    }

    public function test_customer_redirected_to_home_on_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'customer@smartshop.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
    }

    public function test_customer_cannot_access_admin_dashboard(): void
    {
        $customer = User::where('role', 'customer')->first();

        $response = $this->actingAs($customer)->get('/admin/dashboard');
        $response->assertRedirect('/');
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Utama');
        $response->assertSee('Total Pendapatan');
    }

    public function test_cart_and_checkout_flow(): void
    {
        $customer = User::where('role', 'customer')->first();
        $product = Product::first();

        // 1. Add to cart
        $cartResponse = $this->actingAs($customer)->post('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $cartResponse->assertRedirect();

        // 2. View Cart
        $viewCart = $this->actingAs($customer)->get('/cart');
        $viewCart->assertStatus(200);
        $viewCart->assertSee($product->name);

        // 3. View Checkout
        $viewCheckout = $this->actingAs($customer)->get('/checkout');
        $viewCheckout->assertStatus(200);
        $viewCheckout->assertSee('Kota Banda Aceh');

        // 4. Process Checkout to Pidie (Rp 12.000)
        $processCheckout = $this->actingAs($customer)->post('/checkout/process', [
            'recipient_name' => 'Rahmat Test',
            'recipient_phone' => '081234567890',
            'shipping_city' => 'Kabupaten Pidie',
            'shipping_address' => 'Jl. Merdeka No. 10, Sigli',
            'shipping_courier' => 'JNE Express',
            'notes' => 'Test order',
        ]);

        $order = Order::where('recipient_name', 'Rahmat Test')->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals(12000, $order->shipping_cost);
        $this->assertEquals('unpaid', $order->payment_status);

        $processCheckout->assertRedirect(route('orders.payment', $order->id));

        // 5. Simulate payment success in sandbox
        $simulate = $this->actingAs($customer)->post(route('orders.simulateSuccess', $order->id));
        $simulate->assertRedirect(route('orders.tracking', $order->id));

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('processing', $order->order_status);
    }

    public function test_midtrans_webhook_updates_order_status(): void
    {
        $order = Order::first();
        $this->assertNotNull($order);

        $serverKey = config('midtrans.server_key');
        $statusCode = '200';
        $grossAmount = number_format($order->total_amount, 2, '.', '');
        $signature = hash('sha512', $order->order_number . $statusCode . $grossAmount . $serverKey);

        $payload = [
            'order_id' => $order->order_number,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'settlement',
        ];

        $response = $this->postJson('/api/midtrans/notification', $payload);
        $response->assertStatus(200);

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('processing', $order->order_status);
    }
}

