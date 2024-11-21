<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_can_access_index()
    {
        $user = User::factory()->create();
        $permission = Permission::create(['name' => 'ver role']);
        $user->givePermissionTo($permission);

        $this->actingAs($user)
             ->get(route('funcoes.index'))
             ->assertStatus(200);
    }

    public function test_user_without_permission_cannot_access_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->get(route('funcoes.index'))
             ->assertStatus(403);
    }
}