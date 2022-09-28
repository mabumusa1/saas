<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Make the features array.
     *
     * @param string $item
     *
     *
     * @return array<string>
     */
    public function addFeatures(string $item): array
    {
        $features = ['Backups', 'Hosting', 'Security', 'Scalablity'];
        $temp = $features;

        return Arr::prepend($temp, $item);
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $options = ['backups', 'hosting'];
        $plans = [
            's1' => [
                'name' => 's1',
                'display_name' => 'Small - 2,500 Contacts',
                'short_description' => 'Small Mautic installation supports up to 2,500 Contacts',
                'monthly_price' => 50,
                'yearly_price' => 500,
                'features' => $this->addFeatures('2,500 Contacts'),
                'contacts' => 2500,
                'options' =>  $options,
                'archived' => false,
                'available' => true,
            ],
            's2' => [
                'name' => 's2',
                'display_name' => 'Small - 5,000 Contacts',
                'short_description' => 'Small Mautic installation supports up to 5,000 Contacts',
                'monthly_price' => 90,
                'yearly_price' => 900,
                'contacts' => 5000,
                'features' => $this->addFeatures('5,000 Contacts'),
                'options' => $options,
                'archived' => false,
                'available' => true,

            ],
            's3' => [
                'name' => 's3',
                'display_name' => 'Small  - 10,000 Contacts',
                'short_description' => 'Small Mautic installation supports up to 10,000 Contacts',
                'monthly_price' => 160,
                'yearly_price' => 1600,
                'contacts' => 10000,
                'features' => $this->addFeatures('10,000 Contacts'),
                'options' => $options,
                'archived' => false,
                'available' => true,
            ],
            's4' => [
                'name' => 's4',
                'display_name' => 'Medium  - 25,000 Contacts',
                'short_description' => 'Medium Mautic installation supports up to 25,000 Contacts',
                'monthly_price' => 420,
                'yearly_price' => 4200,
                'contacts' => 25000,
                 'features' => $this->addFeatures('25,000 Contacts'),
                'options' => $options,
                'archived' => false,
                'available' => true,

            ],
            's5' => [
                'name' => 's5',
                'display_name' => 'Medium  - 50,000 Contacts',
                'short_description' => 'Medium Mautic installation supports up to 50,000 Contacts',
                'monthly_price' => 800,
                'yearly_price' => 8000,
                'contacts' => 50000,
                 'features' => $this->addFeatures('50,000 Contacts'),
                'options' => $options,
                'archived' => false,
                'available' => true,
            ],
            'e1' => [
                'name' => 'e1',
                'display_name' => 'Medium  - 100,000 Contacts',
                'short_description' => 'Medium Mautic installation supports up to 100,000 Contacts',
                'monthly_price' => 1500,
                'yearly_price' => 15000,
                'contacts' => 100000,
                 'features' => $this->addFeatures('100,000 Contacts'),
                'options' => $options,
                'archived' => false,
                'available' => true,
            ],
            'e2' => [
                'name' => 'e2',
                'display_name' => 'Large  - 500,000 Contacts',
                'short_description' => 'Large Mautic installation supports up to 500,000 Contacts',
                'monthly_price' => 5417,
                'yearly_price' => 65000,
                'contacts' => 5000000,
                 'features' => $this->addFeatures('500,000 Contacts'),
                'options' => $options,
                'archived' => false,
                'available' => true,
            ],
            'e3' => [
                'name' => 'e3',
                'display_name' => 'Large  - 1 Million Contacts',
                'short_description' => 'Large Mautic installation supports up to 1 Million Contacts',
                'monthly_price' => 10833,
                'yearly_price' => 130000,
                'contacts' => 1000000,
                'features' => $this->addFeatures('1 Million Contacts'),
                'options' => $options,
                'archived' => false,
                'available' => true,
            ],
            'e4' => [
                'name' => 'e4',
                'display_name' => 'Large  - 1.5 Million Contacts',
                'short_description' => 'Large Mautic installation supports up to 1.5 Million Contacts',
                'monthly_price' => 15833,
                'yearly_price' => 190000,
                'contacts' => 1500000,
                'features' => $this->addFeatures('1.5 Million Contacts'),
                'options' => $options,
                'archived' => false,
                'available' => true,
            ],
        ];

        if (App::environment(['local', 'CI'])) {
            //Make the plans use the testing stripe account
            $plans['s1']['stripe_product_id'] = 'prod_MVEPWB3RPLdOEI';
            $plans['s1']['stripe_monthly_price_id'] = 'price_1LmDwTQtw9T5bCK19IZz3F3M';
            $plans['s1']['stripe_yearly_price_id'] = 'price_1LmDwTQtw9T5bCK17rTR7gjr';

            $plans['s2']['stripe_product_id'] = 'prod_MVETjTi3IupeLK';
            $plans['s2']['stripe_monthly_price_id'] = 'price_1LmE0IQtw9T5bCK1zZHjxT9Y';
            $plans['s2']['stripe_yearly_price_id'] = 'price_1LmE0IQtw9T5bCK1vLuWjLgn';

            $plans['s3']['stripe_product_id'] = 'prod_MVET2KjcsZ7W5y';
            $plans['s3']['stripe_monthly_price_id'] = 'price_1LmE0zQtw9T5bCK1NRBCLlIa';
            $plans['s3']['stripe_yearly_price_id'] = 'price_1LmE10Qtw9T5bCK1stIK9tBl';

            $plans['s4']['stripe_product_id'] = 'prod_MVEVdq2OMamGIU';
            $plans['s4']['stripe_monthly_price_id'] = 'price_1LmE28Qtw9T5bCK1pcKrSStI';
            $plans['s4']['stripe_yearly_price_id'] = 'price_1LmE28Qtw9T5bCK1EPwRLTDr';

            $plans['s5']['stripe_product_id'] = 'prod_MVEVKdcQOLPor0';
            $plans['s5']['stripe_monthly_price_id'] = 'price_1LmE2sQtw9T5bCK1tmX9KqQW';
            $plans['s5']['stripe_yearly_price_id'] = 'price_1LmE2sQtw9T5bCK1ot35LH1b';

            $plans['e1']['stripe_product_id'] = 'prod_MVEXLWkblHPmlD';
            $plans['e1']['stripe_monthly_price_id'] = 'price_1LmE4qQtw9T5bCK1QC9dPHdS';
            $plans['e1']['stripe_yearly_price_id'] = 'price_1LmE4qQtw9T5bCK1BQCyhln7';

            $plans['e2']['stripe_product_id'] = 'prod_MVErUfACAC8NoG';
            $plans['e2']['stripe_monthly_price_id'] = 'price_1LmENQQtw9T5bCK1xgkqPngj';
            $plans['e2']['stripe_yearly_price_id'] = 'price_1LmENQQtw9T5bCK1Ln6lRDmS';

            $plans['e3']['stripe_product_id'] = 'prod_MVErgjaP5vyM2w';
            $plans['e3']['stripe_monthly_price_id'] = 'price_1LmEO7Qtw9T5bCK1q4ztCcuL';
            $plans['e3']['stripe_yearly_price_id'] = 'price_1LmEO7Qtw9T5bCK1dmCY4ZFI';

            $plans['e4']['stripe_product_id'] = 'prod_MVEsFhVBOq0V8a';
            $plans['e4']['stripe_monthly_price_id'] = 'price_1LmEObQtw9T5bCK1x0KrJQMZ';
            $plans['e4']['stripe_yearly_price_id'] = 'price_1LmEObQtw9T5bCK1AWbucvmR';
        } elseif (App::environment('production')) {
            //Make the plans use the production stripe account
            //TODO: ADD Stripe account from the live system
        }

        foreach ($plans as $plan) {
            $m = new Plan($plan);
            $m->save();
        }

        $this->call([
            AdminSeeder::class,
            UsersSeeder::class,
            AccountWithBillingSeeder::class,
            AccountWithoutBillingSeeder::class,
        ]);
    }
}
