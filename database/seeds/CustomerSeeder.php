<?php

use think\migration\Seeder;

class CustomerSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'customer_id'   =>  $faker->randomNumber(),
                'wechat_name'      => $faker->userName,
                'avatar'      => $faker->imageUrl($width = 640, $height = 480),
                'phone_number' => $faker->phoneNumber,
                'type'         => 1,
                'account_balance'    => $faker->randomNumber(6),
                'identity_card'     => rand(10000,99999),
                'regtime'       => time(),
            ];
        }

        $this->insert('customer', $data);
    }
}