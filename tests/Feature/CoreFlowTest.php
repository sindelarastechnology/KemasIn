<?php

namespace Tests\Feature;

use App\Models\BahanBaku;
use App\Models\Kemasan;
use App\Models\Pengguna;
use App\Models\Pengemasan;
use App\Models\ProgresPengemasan;
use App\Models\Produk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoreFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $operator;
    protected $pemilik;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->create([
            'username' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $this->operator = Pengguna::factory()->create([
            'username' => 'operator1',
            'role' => 'operator',
            'password' => bcrypt('operator123'),
        ]);

        $this->pemilik = Pengguna::factory()->create([
            'username' => 'pemilik',
            'role' => 'pemilik',
            'password' => bcrypt('pemilik123'),
        ]);
    }

    public function test_login_as_admin()
    {
        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_login_as_operator()
    {
        $response = $this->post('/login', [
            'username' => 'operator1',
            'password' => 'operator123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->operator);
    }

    public function test_admin_can_access_bahan_baku()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('bahan-baku.index'));
        $response->assertStatus(200);

        $response = $this->get(route('bahan-baku.create'));
        $response->assertStatus(200);
    }

    public function test_operator_cannot_access_bahan_baku()
    {
        $this->actingAs($this->operator);

        $response = $this->get(route('bahan-baku.index'));
        $response->assertStatus(403);
    }

    public function test_pemilik_can_access_bahan_baku()
    {
        $this->actingAs($this->pemilik);

        $response = $this->get(route('bahan-baku.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_manage_produk()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('produk.index'));
        $response->assertStatus(200);

        $response = $this->post(route('produk.store'), [
            'nama_produk' => 'Kue Kering',
            'stok_tersedia' => 100,
            'stok_minimum' => 10,
            'harga_produk' => 25000,
        ]);

        $response->assertRedirect(route('produk.index'));
        $this->assertDatabaseHas('tbl_produk', ['nama_produk' => 'Kue Kering', 'stok_sudah_dikemas' => 0]);
    }

    public function test_pengemasan_mengurangi_stok_belum_dikemas_dan_menambah_stok_sudah_dikemas()
    {
        $this->actingAs($this->admin);

        $produk = Produk::factory()->create([
            'nama_produk' => 'Kue Nastar',
            'stok_tersedia' => 50,
            'stok_sudah_dikemas' => 0,
            'stok_minimum' => 10,
            'harga_produk' => 50000,
        ]);

        $bahan = BahanBaku::factory()->create([
            'nama_bahan' => 'Kardus',
            'satuan' => 'pcs',
            'stok_tersedia' => 100,
            'stok_minimum' => 10,
            'harga_per_satuan' => 2000,
        ]);

        $kemasan = Kemasan::factory()
            ->withBahan($bahan->id_bahan, 1)
            ->create([
                'nama_kemasan' => 'Box Premium',
                'ukuran' => '20x20cm',
            ]);

        $this->post(route('pengemasan.store'), [
            'id_produk' => $produk->id_produk,
            'id_kemasan' => $kemasan->id_kemasan,
            'tgl_pengemasan' => now()->format('Y-m-d'),
            'target_jumlah' => 10,
            'expired_date' => now()->addMonths(6)->format('Y-m-d'),
        ]);

        $pengemasan = Pengemasan::first();

        $this->actingAs($this->operator);
        $response = $this->post(route('pengemasan.tambahProgres', $pengemasan->id_pengemasan), [
            'jumlah_dikemas' => 5,
        ]);

        $response->assertSessionHas('success');

        $bahan->refresh();
        $this->assertEquals(95, $bahan->stok_tersedia);

        $produk->refresh();
        $this->assertEquals(45, $produk->stok_tersedia);
        $this->assertEquals(5, $produk->stok_sudah_dikemas);
    }

    public function test_stok_belum_dikemas_tidak_cukup_ditolak()
    {
        $this->actingAs($this->admin);

        $produk = Produk::factory()->create([
            'stok_tersedia' => 3,
            'stok_sudah_dikemas' => 0,
        ]);
        $bahan = BahanBaku::factory()->create(['stok_tersedia' => 100]);
        $kemasan = Kemasan::factory()->withBahan($bahan->id_bahan, 1)->create();

        $this->post(route('pengemasan.store'), [
            'id_produk' => $produk->id_produk,
            'id_kemasan' => $kemasan->id_kemasan,
            'tgl_pengemasan' => now()->format('Y-m-d'),
            'target_jumlah' => 10,
            'expired_date' => now()->addMonths(6)->format('Y-m-d'),
        ]);

        $pengemasan = Pengemasan::first();

        $this->actingAs($this->operator);
        $response = $this->post(route('pengemasan.tambahProgres', $pengemasan->id_pengemasan), [
            'jumlah_dikemas' => 5,
        ]);

        $response->assertSessionHas('error');

        $produk->refresh();
        $this->assertEquals(3, $produk->stok_tersedia);
        $this->assertEquals(0, $produk->stok_sudah_dikemas);
    }

    public function test_bahan_baku_tidak_cukup_ditolak()
    {
        $this->actingAs($this->admin);

        $produk = Produk::factory()->create(['stok_tersedia' => 50]);
        $bahan = BahanBaku::factory()->create(['stok_tersedia' => 10]);
        $kemasan = Kemasan::factory()->withBahan($bahan->id_bahan, 3)->create();

        $response = $this->post(route('pengemasan.store'), [
            'id_produk' => $produk->id_produk,
            'id_kemasan' => $kemasan->id_kemasan,
            'tgl_pengemasan' => now()->format('Y-m-d'),
            'target_jumlah' => 10,
            'expired_date' => now()->addMonths(6)->format('Y-m-d'),
        ]);

        $response->assertSessionHas('error', fn ($msg) => str_contains($msg, 'tidak mencukupi'));

        $this->assertDatabaseMissing('tbl_pengemasan', ['id_produk' => $produk->id_produk]);
    }

    public function test_edit_ditolak_jika_sudah_ada_progres()
    {
        $this->actingAs($this->admin);

        $produk = Produk::factory()->create(['stok_tersedia' => 50]);
        $bahan = BahanBaku::factory()->create(['stok_tersedia' => 100]);
        $kemasan = Kemasan::factory()->withBahan($bahan->id_bahan, 1)->create();

        $this->post(route('pengemasan.store'), [
            'id_produk' => $produk->id_produk,
            'id_kemasan' => $kemasan->id_kemasan,
            'tgl_pengemasan' => now()->format('Y-m-d'),
            'target_jumlah' => 10,
            'expired_date' => now()->addMonths(6)->format('Y-m-d'),
        ]);

        $pengemasan = Pengemasan::first();

        $this->actingAs($this->operator);
        $this->post(route('pengemasan.tambahProgres', $pengemasan->id_pengemasan), ['jumlah_dikemas' => 3]);

        $this->actingAs($this->admin);
        $response = $this->put(route('pengemasan.update', $pengemasan->id_pengemasan), [
            'id_produk' => $produk->id_produk,
            'id_kemasan' => $kemasan->id_kemasan,
            'tgl_pengemasan' => now()->format('Y-m-d'),
            'target_jumlah' => 20,
            'expired_date' => now()->addMonths(6)->format('Y-m-d'),
        ]);

        $response->assertSessionHas('error');
    }

    public function test_batalkan_mengembalikan_stok()
    {
        $this->actingAs($this->admin);

        $produk = Produk::factory()->create([
            'stok_tersedia' => 50,
            'stok_sudah_dikemas' => 10,
        ]);
        $bahan = BahanBaku::factory()->create(['stok_tersedia' => 50]);
        $kemasan = Kemasan::factory()->withBahan($bahan->id_bahan, 2)->create();

        $this->post(route('pengemasan.store'), [
            'id_produk' => $produk->id_produk,
            'id_kemasan' => $kemasan->id_kemasan,
            'tgl_pengemasan' => now()->format('Y-m-d'),
            'target_jumlah' => 10,
            'expired_date' => now()->addMonths(6)->format('Y-m-d'),
        ]);

        $pengemasan = Pengemasan::first();

        $this->actingAs($this->operator);
        $this->post(route('pengemasan.tambahProgres', $pengemasan->id_pengemasan), ['jumlah_dikemas' => 4]);

        $bahan->refresh();
        $this->assertEquals(42, $bahan->stok_tersedia);
        $produk->refresh();
        $this->assertEquals(46, $produk->stok_tersedia);
        $this->assertEquals(14, $produk->stok_sudah_dikemas);

        $this->actingAs($this->admin);
        $response = $this->post(route('pengemasan.batalkan', $pengemasan->id_pengemasan));
        $response->assertSessionHas('success');

        $bahan->refresh();
        $this->assertEquals(50, $bahan->stok_tersedia);

        $produk->refresh();
        $this->assertEquals(50, $produk->stok_tersedia);
        $this->assertEquals(10, $produk->stok_sudah_dikemas);
    }

    public function test_admin_can_manage_users()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('pengguna.index'));
        $response->assertStatus(200);

        $response = $this->get(route('pengguna.create'));
        $response->assertStatus(200);

        $response = $this->post(route('pengguna.store'), [
            'username' => 'operator2',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_lengkap' => 'Operator Dua',
            'role' => 'operator',
        ]);

        $response->assertRedirect(route('pengguna.index'));
        $this->assertDatabaseHas('tbl_pengguna', ['username' => 'operator2']);
    }

    public function test_operator_cannot_manage_users()
    {
        $this->actingAs($this->operator);

        $response = $this->get(route('pengguna.index'));
        $response->assertStatus(403);
    }

    public function test_operator_hanya_melihat_history_sendiri()
    {
        $operator2 = Pengguna::factory()->create([
            'username' => 'operator2',
            'role' => 'operator',
            'password' => bcrypt('operator123'),
        ]);

        $this->actingAs($this->admin);

        $produk = Produk::factory()->create(['stok_tersedia' => 100]);
        $bahan = BahanBaku::factory()->create(['stok_tersedia' => 100]);
        $kemasan = Kemasan::factory()->withBahan($bahan->id_bahan, 1)->create();

        $this->post(route('pengemasan.store'), [
            'id_produk' => $produk->id_produk,
            'id_kemasan' => $kemasan->id_kemasan,
            'tgl_pengemasan' => now()->format('Y-m-d'),
            'target_jumlah' => 50,
            'expired_date' => now()->addMonths(6)->format('Y-m-d'),
        ]);

        $pengemasan = Pengemasan::first();

        $this->actingAs($this->operator);
        $this->post(route('pengemasan.tambahProgres', $pengemasan->id_pengemasan), ['jumlah_dikemas' => 3]);

        $this->actingAs($operator2);
        $this->post(route('pengemasan.tambahProgres', $pengemasan->id_pengemasan), ['jumlah_dikemas' => 5]);

        $this->actingAs($this->operator);
        $response = $this->get(route('history.pengemasan'));
        $response->assertStatus(200);

        $this->assertEquals(1, ProgresPengemasan::where('id_pengguna', $this->operator->id_pengguna)->count());
        $this->assertEquals(1, ProgresPengemasan::where('id_pengguna', $operator2->id_pengguna)->count());

        $response = $this->get(route('history.bahanBaku'));
        $response->assertStatus(200);
    }

    public function test_admin_melihat_semua_history()
    {
        $operator2 = Pengguna::factory()->create([
            'username' => 'operator2',
            'role' => 'operator',
            'password' => bcrypt('operator123'),
        ]);

        $this->actingAs($this->admin);

        $produk = Produk::factory()->create(['stok_tersedia' => 100]);
        $bahan = BahanBaku::factory()->create(['stok_tersedia' => 100]);
        $kemasan = Kemasan::factory()->withBahan($bahan->id_bahan, 1)->create();

        $this->post(route('pengemasan.store'), [
            'id_produk' => $produk->id_produk,
            'id_kemasan' => $kemasan->id_kemasan,
            'tgl_pengemasan' => now()->format('Y-m-d'),
            'target_jumlah' => 50,
            'expired_date' => now()->addMonths(6)->format('Y-m-d'),
        ]);

        $pengemasan = Pengemasan::first();

        $this->actingAs($this->operator);
        $this->post(route('pengemasan.tambahProgres', $pengemasan->id_pengemasan), ['jumlah_dikemas' => 3]);

        $this->actingAs($operator2);
        $this->post(route('pengemasan.tambahProgres', $pengemasan->id_pengemasan), ['jumlah_dikemas' => 5]);

        $this->actingAs($this->admin);
        $response = $this->get(route('history.pengemasan'));
        $response->assertStatus(200);
        $response->assertSee('3');
        $response->assertSee('5 unit');
    }

    public function test_dashboard_shows_stats()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
    }

    public function test_laporan_download_csv()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('laporan.exportPengemasan'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }
}
