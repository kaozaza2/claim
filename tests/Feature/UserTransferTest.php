<?php

namespace Tests\Feature;

use App\Models\Transfer;
use App\Models\Equipment;
use App\Models\SubDepartment;
use App\Models\User;
use App\Http\Livewire\User\TransferReport;
use App\Http\Livewire\User\TransferTable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserTransferTest extends TestCase
{
    use RefreshDatabase;

    protected $equipment;

    protected $user;

    protected $sub;

    public function setUp(): void
    {
        parent::setUp();
        $this->sub = SubDepartment::factory()->create();
        $this->equipment = Equipment::factory()->create([
            'sub_department_id' => $this->sub->id,
        ]);
        $this->user = User::factory()->create([
            'sub_department_id' => $this->sub->id,
        ]);
    }

    public function test_create_transfer()
    {
        $this->actingAs($this->user);

        Transfer::query()->delete();

        Livewire::test(TransferReport::class)
            ->set('state', [
                'equipment' => $this->equipment->id,
                'to' => SubDepartment::factory()->create()->id,
            ])->call('store');

        $this->assertEquals(Transfer::all()->count(), 1);
    }

    public function test_cancel_transfer()
    {
        $this->actingAs($this->user);

        Transfer::query()->delete();

        $transfer = Transfer::factory()->create([
            'equipment_id' => $this->equipment->id,
            'user_id' => $this->user->id,
            'from_sub_department_id' => $this->sub->id,
            'to_sub_department_id' => SubDepartment::factory()->create()->id,
        ]);

        Livewire::test(TransferTable::class)
            ->call('destroy', 0);

        $this->assertFalse(Transfer::whereId($transfer->id)->exists());
        $this->assertTrue(Transfer::all()->isEmpty());
    }
}
