<?php

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->delete();
        // $faker = Faker::create('ja_JP');
        $faker = Faker\Factory::create('ja_JP');

        for ($i = 0; $i < 10; $i++) {
            App\Student::create([
                'name' => $faker->name(),
                'email' => $faker->email(),
                'tel' => $faker->phoneNumber(),
            ]);
        }
    }
}
