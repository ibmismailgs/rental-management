<?php

namespace Database\Seeders;

use App\Models\Accounts\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@test.com',
                'type' => 1,
                'password' => Hash::make(1234)
            ],
        ]);

        DB::table('expense_categories')->insert([
            [
                'id' => 1,
                'category_name' => 'Gas Bill',
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'id' => 2,
                'category_name' => 'Water Bill',
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'id' => 3,
                'category_name' => 'Electricity Bill',
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'id' => 4,
                'category_name' => 'Service Charge',
                'status' => 1,
                'created_by' => 1,
            ],
        ]);

        DB::table('mobile_bankings')->insert([
            [
                'id' => 1,
                'name' => 'Bkash',
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Nagad',
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Rocket',
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'id' => 4,
                'name' => 'MCash',
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'id' => 5,
                'name' => 'SureCash',
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'id' => 6,
                'name' => 'Upay',
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'id' => 7,
                'name' => 'T-Cash',
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'id' => 8,
                'name' => 'Ok Wallet',
                'status' => 1,
                'created_by' => 1,
            ]

            ]);

            $banks = [
                [
                    'bank_name' => 'AB Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Agrani Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Al-Arafah Islami Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Bangladesh Commerce Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Bangladesh Development Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Bangladesh Krishi Bank',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Bank Al-Falah Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Bank Asia Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'BASIC Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'BRAC Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],

                [
                    'bank_name' => 'Commercial Bank of Ceylon Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Community Bank Bangladesh Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Dhaka Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Dutch-Bangla Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Eastern Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'EXIM Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'First Security Islami Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Habib Bank Ltd.',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'ICB Islamic Bank Ltd.',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'IFIC Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Islami Bank Bangladesh Ltd.',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Jamuna Bank Ltd.',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Janata Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Meghna Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Mercantile Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Midland Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Modhumoti Bank Ltd.'
                ],
                [
                    'bank_name' => 'Mutual Trust Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'National Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'National Bank of Pakistan',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'National Credit & Commerce Bank Ltd',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'NRB Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'NRB Commercial Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'NRB Global Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'One Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Padma Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Palli Sanchay Bank',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Premier Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Prime Bank Ltd.',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Probashi Kollyan Bank',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Pubali Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Rajshahi Krishi Unnayan Bank',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Rupali Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Shahjalal Islami Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Shimanto Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],

                [
                    'bank_name' => 'Social Islami Bank Ltd.',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Sonali Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'South Bangla Agriculture & Commerce Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Southeast Bank Limited','status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Standard Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Standard Chartered Bank',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'The City Bank Ltd.',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Trust Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Union Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'United Commercial Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],
                [
                    'bank_name' => 'Uttara Bank Limited',
                    'status' => 1,
                    'created_by' => 1,
                ],

            ];
            foreach ($banks as $key => $value) {
                Bank::create($value);
            }
    }
}
