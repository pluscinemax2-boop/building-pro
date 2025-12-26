<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Basic Plan
        Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'description' => 'Perfect for small communities',
            'price' => 199.00,
            'billing_cycle' => 'monthly',
            'max_flats' => 50,
            'features' => [
                'Up to 50 Flats',
                'Complaint Management',
                'Resident Access',
                'Basic Reports',
            ],
            'is_active' => true,
        ]);

        // Professional Plan
        Plan::create([
            'name' => 'Professional',
            'slug' => 'professional',
            'description' => 'For growing residential complexes',
            'price' => 499.00,
            'billing_cycle' => 'monthly',
            'max_flats' => 250,
            'features' => [
                'Up to 250 Flats',
                'Visitor Management',
                'Emergency Alerts',
                'Advanced Reports',
                'Priority Support',
                'Multi-manager Support',
            ],
            'is_active' => true,
        ]);

        // Enterprise Plan
        Plan::create([
            'name' => 'Enterprise',
            'slug' => 'enterprise',
            'description' => 'For large communities and organizations',
            'price' => 999.00,
            'billing_cycle' => 'monthly',
            'max_flats' => null, // unlimited
            'features' => [
                'Unlimited Flats',
                'Visitor Management',
                'Emergency Alerts',
                'Advanced Analytics',
                '24/7 Support',
                'Unlimited Managers',
                'Custom Integrations',
                'Dedicated Account Manager',
            ],
            'is_active' => true,
        ]);
    }
}
