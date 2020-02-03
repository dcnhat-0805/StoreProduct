<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
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
                'category_name' => 'Thiết bị điện tử',
                'category_slug' => utf8ToUrl('Thiết bị điện tử'),
                'category_order' => 0,
                'category_status' => 1,
            ],
            [
                'category_name' => 'Phụ kiện điện tử',
                'category_slug' => utf8ToUrl('Phụ kiện điện tử'),
                'category_order' => 1,
                'category_status' => 1,
            ],
            [
                'category_name' => 'TV & Thiết bị điện gia dụng',
                'category_slug' => utf8ToUrl('TV & Thiết bị điện gia dụng'),
                'category_order' => 2,
                'category_status' => 1,
            ],
            [
                'category_name' => 'Sức khỏe & làm đẹp',
                'category_slug' => utf8ToUrl('Sức khỏe & làm đẹp'),
                'category_order' => 3,
                'category_status' => 1,
            ],
            [
                'category_name' => 'Hàng mẹ, bé & đồ chơi',
                'category_slug' => utf8ToUrl('Hàng mẹ, bé & đồ chơi'),
                'category_order' => 4,
                'category_status' => 1,
            ],
            [
                'category_name' => 'Siêu thị tạp hóa',
                'category_slug' => utf8ToUrl('Siêu thị tạp hóa'),
                'category_order' => 5,
                'category_status' => 1,
            ],
            [
                'category_name' => 'Hàng gia dụng & đời sống',
                'category_slug' => utf8ToUrl('Hàng gia dụng & đời sống'),
                'category_order' => 8,
                'category_status' => 1,
            ],
            [
                'category_name' => 'Thời trang nữ',
                'category_slug' => utf8ToUrl('Thời trang nữ'),
                'category_order' => 6,
                'category_status' => 1,
            ],
            [
                'category_name' => 'Thời trang nam',
                'category_slug' => utf8ToUrl('Thời trang nam'),
                'category_order' => 7,
                'category_status' => 1,
            ],
            [
                'category_name' => 'Phụ kiện thời trang',
                'category_slug' => utf8ToUrl('Phụ kiện thời trang'),
                'category_order' => 9,
                'category_status' => 1,
            ],
            [
                'category_name' => 'Thể thao & du lịch',
                'category_slug' => utf8ToUrl('Thể thao & du lịch'),
                'category_order' => 10,
                'category_status' => 1,
            ],
            [
                'category_name' => 'Ô tô, xe máy & thiết bị địng vị',
                'category_slug' => utf8ToUrl('Ô tô, xe máy & thiết bị địng vị'),
                'category_order' => 11,
                'category_status' => 1,
            ],
        ];
        DB::table('categories')->insert($data);
    }
}
