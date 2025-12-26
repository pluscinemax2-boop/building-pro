<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Building;
use App\Models\Payment;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PdfReportTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $buildingAdmin;
    protected User $resident;
    protected Building $building;

    public function setUp(): void
    {
        parent::setUp();

        // Create roles
        $adminRole = Role::create(['name' => 'Admin']);
        $buildingAdminRole = Role::create(['name' => 'Building Admin']);
        $residentRole = Role::create(['name' => 'Resident']);

        // Create users
        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('pass'),
            'role_id' => $adminRole->id,
        ]);

        $this->buildingAdmin = User::create([
            'name' => 'Building Admin',
            'email' => 'badmin@test.com',
            'password' => bcrypt('pass'),
            'role_id' => $buildingAdminRole->id,
        ]);

        $this->resident = User::create([
            'name' => 'Resident',
            'email' => 'resident@test.com',
            'password' => bcrypt('pass'),
            'role_id' => $residentRole->id,
        ]);

        // Create building
        $this->building = Building::create([
            'name' => 'Test Building',
            'address' => '123 Main St',
            'city' => 'City',
            'state' => 'ST',
            'zip_code' => '12345',
            'admin_id' => $this->buildingAdmin->id,
            'slug' => 'test-bldg',
        ]);
    }


    public function test_payment_receipt_preview_accessible()
    {
        $payment = Payment::create([
            'user_id' => $this->resident->id,
            'building_id' => $this->building->id,
            'status' => 'completed',
            'amount' => 100,
            'total_amount' => 100,
            'payment_method' => 'card',
            'transaction_id' => 'TEST-001',
        ]);

        $response = $this->actingAs($this->resident)
            ->get(route('payment.receipt.preview', $payment));

        $response->assertSuccessful();
    }

    public function test_billing_report_preview_accessible()
    {
        Payment::create([
            'user_id' => $this->resident->id,
            'building_id' => $this->building->id,
            'status' => 'completed',
            'amount' => 100,
            'total_amount' => 100,
            'payment_method' => 'card',
            'transaction_id' => 'TEST-002',
        ]);

        $response = $this->actingAs($this->buildingAdmin)
            ->get(route('billing.preview', [
                'building' => $this->building,
                'month' => now()->format('Y-m'),
            ]));

        $response->assertSuccessful();
    }

    public function test_complaint_report_preview_accessible()
    {
        $response = $this->actingAs($this->buildingAdmin)
            ->get(route('complaint.preview', [
                'building' => $this->building,
                'month' => now()->format('Y-m'),
            ]));

        $response->assertSuccessful();
    }

    public function test_resident_denied_billing_report()
    {
        $response = $this->actingAs($this->resident)
            ->get(route('billing.preview', [
                'building' => $this->building,
                'month' => now()->format('Y-m'),
            ]));

        $response->assertStatus(403);
    }

    public function test_unauthenticated_denied_payment_receipt()
    {
        $payment = Payment::create([
            'user_id' => $this->resident->id,
            'building_id' => $this->building->id,
            'status' => 'completed',
            'amount' => 100,
            'total_amount' => 100,
            'payment_method' => 'card',
            'transaction_id' => 'TEST-003',
        ]);

        $this->get(route('payment.receipt.preview', $payment))
            ->assertRedirect(route('login'));
    }

    public function test_resident_cannot_view_others_receipt()
    {
        $other = User::create([
            'name' => 'Other',
            'email' => 'other@test.com',
            'password' => bcrypt('pass'),
            'role_id' => Role::where('name', 'Resident')->first()->id,
        ]);

        $payment = Payment::create([
            'user_id' => $other->id,
            'building_id' => $this->building->id,
            'status' => 'completed',
            'amount' => 100,
            'total_amount' => 100,
            'payment_method' => 'card',
            'transaction_id' => 'TEST-004',
        ]);

        $this->actingAs($this->resident)
            ->get(route('payment.receipt.download', $payment))
            ->assertStatus(403);
    }
}
