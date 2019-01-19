<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(StudentsTableSeeder::class);

        $tags = ['うどん', 'そば', 'ラーメン', 'フォー'];
        foreach ($tags as $tag) App\Tag::create(['name' => $tag]);
    }
}
