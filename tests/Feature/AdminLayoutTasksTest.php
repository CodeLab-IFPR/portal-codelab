<?php

namespace Tests\Feature;

use App\Models\Certificado;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminLayoutTasksTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'cache.default' => 'array',
            'session.driver' => 'array',
        ]);
        DB::purge('sqlite');
        $this->artisan('migrate', ['--database' => 'sqlite', '--force' => true])->assertSuccessful();
        $this->seed(PermissionsSeeder::class);
        $this->admin = User::create([
            'name' => 'Membro de teste',
            'email' => 'admin-layout@example.test',
            'cpf' => '00000000000',
            'password' => 'test-password',
        ]);
        $this->admin->forceFill(['email_verified_at' => now()])->save();
        $this->admin->assignRole('Admin');
        $this->actingAs($this->admin);
    }

    public function test_permissions_are_grouped_without_losing_existing_or_custom_names(): void
    {
        Permission::create(['name' => 'Ação personalizada']);
        $response = $this->get(route('funcoes.create'))->assertOk();
        $groups = $response->viewData('gruposPermissoes');

        $this->assertCount(Permission::count(), $groups->flatten());
        $this->assertEqualsCanonicalizing(
            ['Visualizar Mensagem', 'Deletar Mensagem', 'Marcar como Lida', 'Marcar como Não Lida', 'Alterar Status da Mensagem'],
            $groups['Mensagem']->pluck('name')->all()
        );
        $this->assertTrue($groups->flatten()->contains('name', 'Ação personalizada'));
        $response->assertSee('Selecionar tudo')->assertSee('Limpar seleção');
    }

    public function test_role_creation_keeps_the_current_permission_contract(): void
    {
        $permissions = ['Criar Certificado', 'Visualizar Certificado'];
        $this->post(route('funcoes.store'), ['name' => 'Certificador', 'permissao' => $permissions])
            ->assertRedirect(route('funcoes.index'));
        $this->assertEqualsCanonicalizing($permissions, Role::findByName('Certificador')->permissions->pluck('name')->all());

        $this->from(route('funcoes.create'))->post(route('funcoes.store'), [
            'name' => 'Certificador', 'permissao' => $permissions,
        ])->assertSessionHasErrors('name')->assertSessionHasInput('permissao', $permissions);
    }

    public function test_role_list_has_limited_chips_and_confirmation(): void
    {
        $this->get(route('funcoes.index'))->assertOk()
            ->assertSee('admin-ui-permission-chip')
            ->assertSee('+'.(Permission::count() - 4).' mais')
            ->assertSee('Data de atualização')
            ->assertSee('confirmDeleteRoleModal');
    }

    public function test_manual_certificate_requires_all_fields_before_writing(): void
    {
        $this->from(route('certificados.create'))->post(route('certificados.store'), [
            'manual_certificado' => ['user_id' => '', 'horas' => '', 'data' => '', 'descricao' => ''],
        ])->assertRedirect(route('certificados.create'))->assertSessionHasErrors([
            'manual_certificado.user_id', 'manual_certificado.horas', 'manual_certificado.data', 'manual_certificado.descricao',
        ]);
        $this->assertDatabaseCount('certificados', 0);
        $this->get(route('certificados.create'))->assertOk()
            ->assertSee('Selecione um membro.')
            ->assertSee('O campo horas é obrigatório.')
            ->assertSee('O campo data é obrigatório.')
            ->assertSee('O campo descrição é obrigatório.');
    }

    public function test_batch_validation_is_complete_before_any_certificate_is_saved(): void
    {
        $valid = $this->certificateData();
        $invalid = ['user_id' => 999999, 'horas' => 'abc', 'data' => 'invalid', 'descricao' => str_repeat('a', 521)];
        $this->from(route('certificados.create'))->post(route('certificados.store'), [
            'certificados' => [$valid, $invalid],
        ])->assertSessionHasErrors([
            'certificados.1.user_id', 'certificados.1.horas', 'certificados.1.data', 'certificados.1.descricao',
        ])->assertSessionHasInput('certificados.0.descricao', $valid['descricao']);
        $this->assertDatabaseCount('certificados', 0);
        $this->get(route('certificados.create'))->assertOk()
            ->assertSee('certificados[1][user_id]', false)
            ->assertSee('Selecione um membro cadastrado.')
            ->assertSee('O campo horas deve ser um número inteiro.');
    }

    public function test_manual_and_batch_certificate_creation_remain_available(): void
    {
        $this->post(route('certificados.store'), ['manual_certificado' => $this->certificateData()])
            ->assertSessionHasNoErrors()->assertRedirect(route('certificados.index'));
        $batch = array_replace($this->certificateData(), ['descricao' => 'Certificado em lote']);
        $this->post(route('certificados.store'), ['certificados' => [$batch]])
            ->assertSessionHasNoErrors()->assertRedirect(route('certificados.index'));
        $this->assertDatabaseCount('certificados', 2);
    }

    public function test_certificate_search_by_member_returns_the_new_table_and_pagination(): void
    {
        for ($index = 0; $index < 6; $index++) {
            Certificado::forceCreate($this->certificateData() + ['token' => 'test'.$index]);
        }
        $response = $this->getJson(route('certificados.index', ['search' => $this->admin->name]), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()->assertJsonStructure(['table']);
        $this->assertStringContainsString($this->admin->name, $response->json('table'));
        $this->assertStringContainsString('admin-ui-pagination', $response->json('table'));
        $this->assertStringContainsString('bi-sliders2', $response->json('table'));
        $this->get(route('certificados.index', ['search' => 'sem resultado']))
            ->assertOk()->assertSee('Não há certificados cadastrados.');
    }

    public function test_role_edit_preserves_permissions_and_can_clear_them(): void
    {
        $role = Role::create(['name' => 'Editor de teste']);
        $role->givePermissionTo('Visualizar Certificado');
        $response = $this->get(route('funcoes.edit', $role))->assertOk();
        $this->assertCount(Permission::count(), $response->viewData('gruposPermissoes')->flatten());
        $response->assertSee('value="Editor de teste"', false);
        $this->assertMatchesRegularExpression('/value="Visualizar Certificado"\s+checked/', $response->getContent());

        $this->from(route('funcoes.edit', $role))->put(route('funcoes.update', $role), ['name' => ''])
            ->assertSessionHasErrors('name');
        $response = $this->get(route('funcoes.edit', $role))->assertOk();
        $this->assertDoesNotMatchRegularExpression('/value="Visualizar Certificado"\s+checked/', $response->getContent());

        $this->put(route('funcoes.update', $role), ['name' => 'Editor atualizado'])
            ->assertSessionHasNoErrors()->assertRedirect(route('funcoes.index'));
        $this->assertSame('Editor atualizado', $role->fresh()->name);
        $this->assertCount(0, $role->fresh()->permissions);
    }

    public function test_certificate_edit_loads_and_saves_the_selected_member(): void
    {
        $certificate = Certificado::forceCreate($this->certificateData() + ['token' => 'edit-test']);
        $member = User::create([
            'name' => 'Outro membro', 'email' => 'other@example.test',
            'cpf' => '11111111111', 'password' => 'test-password',
        ]);
        $response = $this->get(route('certificados.edit', $certificate))->assertOk();
        $response->assertSee('value="'.$this->admin->id.'" selected', false)
            ->assertSee('Atividade de extensão')->assertSee('value="2026-09-22"', false);

        $data = array_replace($this->certificateData(), ['user_id' => $member->id, 'horas' => 24]);
        $this->put(route('certificados.update', $certificate), $data)
            ->assertSessionHasNoErrors()->assertRedirect(route('certificados.index'));
        $this->assertDatabaseHas('certificados', ['id' => $certificate->id] + $data);

        $this->from(route('certificados.edit', $certificate))->put(route('certificados.update', $certificate),
            array_replace($data, ['user_id' => $this->admin->id, 'horas' => '']))
            ->assertSessionHasErrors('horas');
        $this->get(route('certificados.edit', $certificate))->assertOk()
            ->assertSee('value="'.$this->admin->id.'" selected', false)
            ->assertSee('O campo horas é obrigatório');
        $this->assertSame($member->id, $certificate->fresh()->user_id);
    }

    private function certificateData(): array
    {
        return ['user_id' => $this->admin->id, 'horas' => 12, 'data' => '2026-09-22', 'descricao' => 'Atividade de extensão'];
    }
}
