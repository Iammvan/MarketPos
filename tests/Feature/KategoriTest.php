<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class KategoriTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_store_successfully()
    {
        // Buat role admin jika belum ada
        Role::firstOrCreate(['name' => 'admin']);

        // Buat user dan assign role admin
        $user = User::factory()->create();
        $user->assignRole('admin');

        // Login sebagai user yang baru dibuat
        $this->actingAs($user);

        // Data kategori yang akan dikirim
        $data = [
            'nama_kategori' => 'Kategori Baru',
        ];

        // Kirim POST request ke endpoint '/kategori'
        $response = $this->post('/kategori', $data);

        // Pastikan response melakukan redirect (kode 302)
        $response->assertStatus(302);

        // Jika ada redirect ke halaman kategori, pastikan
        $response->assertRedirect(route('kategori.index'));

        // Pastikan data kategori berhasil tersimpan di database
        $this->assertDatabaseHas('kategoris', [
            'nama_kategori' => 'Kategori Baru',
        ]);
    }
}
