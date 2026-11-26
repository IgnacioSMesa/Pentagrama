<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotasAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_invitado_es_redirigido_al_login(): void
    {
        $this -> get('/') -> assertRedirect(route('login'));
    }

    public function test_usuario_logado_ve_notas_sin_cache(): void
    {
        $this -> withoutVite();

        $response = $this -> actingAs(User::factory() -> create()) -> get('/');

        $response -> assertOk();
        $this -> assertStringContainsString('no-store', $response -> headers->get('Cache-Control'));
    }
}
