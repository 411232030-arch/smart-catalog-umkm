<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Produk;
use App\Models\StokMasuk;
use App\Models\TransaksiPenjualan;
use App\Models\User;
use Tests\TestCase;

class StructureTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_category_model_exists()
    {
        $this->assertTrue(class_exists(Category::class));
    }

    public function test_produk_model_exists()
    {
        $this->assertTrue(class_exists(Produk::class));
    }

    public function test_produk_has_category_relation()
    {
        $produk = new Produk();
        $this->assertTrue(method_exists($produk, 'category'));
    }

    public function test_category_has_produk_relation()
    {
        $category = new Category();
        $this->assertTrue(method_exists($category, 'produk'));
    }

    public function test_transaksi_penjualan_model_exists()
    {
        $this->assertTrue(class_exists(TransaksiPenjualan::class));
    }

    public function test_stok_masuk_model_exists()
    {
        $this->assertTrue(class_exists(StokMasuk::class));
    }

    public function test_dashboard_route_requires_auth()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_dashboard_accessible_for_authenticated_user()
    {
        $response = $this->actingAs($this->user)->get('/dashboard');
        if ($response->status() !== 200) {
            echo "\n\nResponse Status: " . $response->status();
            echo "\n\nResponse: ";
            echo $response->getContent();
            echo "\n\n";
        }
        $response->assertStatus(200);
    }

    public function test_menu_route_requires_auth()
    {
        $response = $this->get('/menu');
        $response->assertRedirect('/login');
    }

    public function test_pesanan_route_requires_auth()
    {
        $response = $this->get('/pesanan');
        $response->assertRedirect('/login');
    }

    public function test_laporan_route_requires_auth()
    {
        $response = $this->get('/laporan');
        $response->assertRedirect('/login');
    }

    public function test_login_route_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_register_route_accessible()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }
}
