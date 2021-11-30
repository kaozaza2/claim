<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\SubDepartment;
use App\Models\User;
use App\Http\Livewire\Admin\Equipments;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEquipmentTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected $sub;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->sub = SubDepartment::factory()->create();
    }

    public function test_create_equipment()
    {
        $this->actingAs($this->admin);

        Livewire::test(Equipments::class)
            ->set('state', [
                'name' => 'Equipment 1',
                'brand' => 'Acer',
                'category' => 'Monitor',
                'serial_number' => '123456',
                'sub_department_id' => $this->sub->id,
                'detail' => 'none',
            ])->call('store');

        $this->assertTrue(Equipment::whereName('Equipment 1')->exists());
    }

    public function test_update_equipment()
    {
        $this->actingAs($this->admin);

        Equipment::query()->delete();

        $equipment = Equipment::factory()->create([
            'sub_department_id' => $this->sub->id,
        ]);

        $updated = array_merge(
            $equipment->attributesToArray(),
            ['serial_number' => '12355875996']
        );

        Livewire::test(Equipments::class)
            ->set('state', $updated)
            ->set('index', 0)
            ->call('update');

        $this->assertTrue(Equipment::whereSerialNumber('12355875996')->exists());
    }

    public function test_delete_equipment()
    {
        $this->actingAs($this->admin);

        Equipment::query()->delete();

        $equipment = Equipment::factory()->create([
            'sub_department_id' => $this->sub->id,
        ]);

        Livewire::test(Equipments::class)
            ->call('destroy', 0);

        $this->assertFalse(Equipment::whereId($equipment->id)->exists());
        $this->assertTrue(Equipment::all()->isEmpty());
    }
}
