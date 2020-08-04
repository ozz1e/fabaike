<?php

use think\migration\Seeder;

class Banner extends Seeder
{

    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'id'   =>  $faker->unique()->randomDigit,
                'pic'      => $faker->imageUrl($width = 640, $height = 480),
                'url'      => $faker->url,
                'is_index' => 0,
                'sort'     => rand(1000,9999),

            ];
        }

        $this->insert('banner', $data);
    }
}