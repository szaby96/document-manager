<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Category::insert([
            [
                'name' => 'Docs',
                'parent_category_id' => null
            ],
            [
                'name' => 'Photos',
                'parent_category_id' => null
            ],
            [
                'name' => 'Videos',
                'parent_category_id' => null
            ],
            [
                'name' => 'Games',
                'parent_category_id' => null
            ],
            [
                'name' => 'Books',
                'parent_category_id' => null
            ]
        ]);
    }
}
