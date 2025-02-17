<?php
namespace Database\Seeders;
use App\Enums\RoleCode;
use Illuminate\Database\Seeder;
use App\Models\User;
class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchant = User::whereEmail('merchant@test.com')->first();
        if ($merchant) {
            $merchant->roles()->attach(RoleCode::merchant);
        }
    }
}