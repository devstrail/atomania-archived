<?php

namespace Database\Seeders;

use App\Models\FarmingTool;
use App\Models\User;
use Illuminate\Database\Seeder;

class FarmingToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = User::factory(10)->withUserType('Vendor')->create();
        foreach ($vendors as $vendor) {
            FarmingTool::factory(10)->withVendor($vendor->id)->create();
        }
    }
}
