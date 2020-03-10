<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Document::insert([
            [
                'name' => 'Word',
                'file_name' => 'word.docx',
                'version' => 1.0,
                'category_id' => 6,
                'updatedBy_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Excel',
                'file_name' => 'excel.xlsx',
                'version' => 1.0,
                'category_id' => 7,
                'updatedBy_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Powerpoint',
                'file_name' => 'powerpoint.pptx',
                'version' => 1.0,
                'category_id' => 8,
                'updatedBy_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
