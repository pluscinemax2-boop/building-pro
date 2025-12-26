<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electricity',
            'Maintenance',
            'Security',
            'Water',
            'Cleaning',
            'Lift',
            'Garden',
            'Other',
        ];
        foreach ($categories as $cat) {
            ExpenseCategory::firstOrCreate(['name' => $cat]);
        }
    }
}
