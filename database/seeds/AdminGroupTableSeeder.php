<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'permission_name' => 'System Management',
                'permission' => '1',
            ],
            [
                'permission_name' => 'Category',
                'permission' => '2',
            ],
            [
                'permission_name' => 'Product Category',
                'permission' => '3',
            ],
            [
                'permission_name' => 'Product Type',
                'permission' => '4',
            ],
            [
                'permission_name' => 'Product',
                'permission' => '5',
            ],
        ];
        DB::table('admin_groups')->insert($data);
    }
}
