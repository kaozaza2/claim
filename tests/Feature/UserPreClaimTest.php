<?php

namespace Tests\Feature;

use App\Models\PreClaim;
use App\Models\Equipment;
use App\Models\SubDepartment;
use App\Models\User;
use App\Http\Livewire\User\ClaimReport;
use App\Http\Livewire\User\PreClaimTable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserPreClaimTest extends TestCase
{
    use RefreshDatabase;

    protected $sub;

    protected $equipment;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->sub = SubDepartment::factory()->create();
        $this->equipment = Equipment::factory()->create([
            'sub_department_id' => $this->sub->id,
        ]);
        $this->user = User::factory()->create([
            'sub_department_id' => $this->sub->id,
            'role' => 'admin',
        ]);
    }

    public function test_create_pre_claim()
    {
        $this->actingAs($this->user);

        Livewire::test(ClaimReport::class)
            ->set('state', [
                'equipment' => $this->equipment->id,
                'problem' => 'Some problem',
            ])->call('store');

        $this->assertTrue(PreClaim::whereProblem('Some problem')->exists());
    }

    public function test_cancel_pre_claim()
    {
        $this->actingAs($this->user);

        PreClaim::query()->delete();

        $pre = PreClaim::factory()->create([
            'equipment_id' => $this->equipment->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::test(PreClaimTable::class)
            ->call('destroy', 0);

        $this->assertFalse(PreClaim::whereId($pre->id)->exists());
        $this->assertTrue(PreClaim::all()->isEmpty());
    }
}
