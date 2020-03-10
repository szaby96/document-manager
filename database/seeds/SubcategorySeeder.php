<?php

use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
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
                'name' => 'Word',
                'parent_category_id' => '1'
            ],
            [
                'name' => 'Excel',
                'parent_category_id' => '1'
            ],
            [
                'name' => 'PowerPoint',
                'parent_category_id' => '1'
            ],
            [
                'name' => 'Cats',
                'parent_category_id' => '2'
            ],
            [
                'name' => 'Cars',
                'parent_category_id' => '2'
            ]
        ]);
    }
}
