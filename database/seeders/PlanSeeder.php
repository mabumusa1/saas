<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sandboxPlans = [
            [
                'name' => 'Small Installs',
                'short_description' => 'Small installs hosting up to 2500',
                'monthly_id' => 24528,
                'yearly_id' => 24531,
                'monthly_price' => 50,
                'yearly_price' => 500,
                'features' => [
                    '2500 Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ],
                'options' => [
                    'backups',
                    'hosting',
                ],

            ],
            [
                'name' => 'Medium Installs',
                'short_description' => 'Medium installs hosting up to 5000',
                'monthly_id' => 24529,
                'yearly_id' => 24532,
                'monthly_price' => 100,
                'yearly_price' => 1000,
                'features' => [
                    '500 Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ],
                'options' => [
                    'backups',
                    'hosting',
                ],

            ],
            [
                'name' => 'Large Installs',
                'short_description' => 'Large installs hosting up to 5000',
                'monthly_id' => 24530,
                'yearly_id' => 24533,
                'monthly_price' => 200,
                'yearly_price' => 2000,
                'features' => [
                    '500 Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ],
                'options' => [
                    'backups',
                    'hosting',
                ],

            ],
            [
                'name' => 'Enteprise Small',
                'short_description' => 'Enterpirse Install 1',
                'monthly_id' => 24534,
                'yearly_id' => 24537,
                'monthly_price' => 1000,
                'yearly_price' => 10000,
                'features' => [
                    '500 Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ],
                'options' => [
                    'backups',
                    'hosting',
                ],
            ],
            [
                'name' => 'Enteprise Medium',
                'short_description' => 'Enterpirse Install 2',
                'monthly_id' => 24535,
                'yearly_id' => 24538,
                'monthly_price' => 5000,
                'yearly_price' => 50000,
                'features' => [
                    '500 Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ],
                'options' => [
                    'backups',
                    'hosting',
                ],

            ],
            [
                'name' => 'Enteprise Large',
                'short_description' => 'Enterpirse Install 3',
                'monthly_id' => 24536,
                'yearly_id' => 24539,
                'monthly_price' => 10000,
                'yearly_price' => 100000,
                'features' => [
                    '500 Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ],
                'options' => [
                    'backups',
                    'hosting',
                ],

            ],
        ];

        foreach ($sandboxPlans as $plan) {
            $plan = new Plan($plan);
            $plan->save();
        }
    }
}
