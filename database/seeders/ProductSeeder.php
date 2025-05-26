<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $products = [
            // Легкие товары
            [
                'name' => 'Мобильный телефон iPhone 15',
                'description' => 'Современный смартфон с отличной камерой и производительностью',
                'price' => 89990.00,
                'category' => 'легкий'
            ],
            [
                'name' => 'Беспроводные наушники AirPods',
                'description' => 'Качественные беспроводные наушники с шумоподавлением',
                'price' => 24990.00,
                'category' => 'легкий'
            ],
            [
                'name' => 'Книга "Программирование на PHP"',
                'description' => 'Учебник по веб-разработке для начинающих',
                'price' => 1500.50,
                'category' => 'легкий'
            ],
            [
                'name' => 'USB флешка 64GB',
                'description' => 'Компактная флешка для хранения данных',
                'price' => 890.00,
                'category' => 'легкий'
            ],

            // Хрупкие товары
            [
                'name' => 'Керамическая ваза',
                'description' => 'Декоративная ваза ручной работы',
                'price' => 3500.00,
                'category' => 'хрупкий'
            ],
            [
                'name' => 'Стеклянный набор посуды',
                'description' => 'Набор из 12 стеклянных тарелок и стаканов',
                'price' => 5600.99,
                'category' => 'хрупкий'
            ],
            [
                'name' => 'Монитор Dell 27"',
                'description' => '4K монитор для работы и игр',
                'price' => 35000.00,
                'category' => 'хрупкий'
            ],
            [
                'name' => 'Хрустальная люстра',
                'description' => 'Элегантная люстра для гостиной',
                'price' => 45000.00,
                'category' => 'хрупкий'
            ],

            // Тяжелые товары
            [
                'name' => 'Стиральная машина LG',
                'description' => 'Автоматическая стиральная машина 8 кг',
                'price' => 65000.00,
                'category' => 'тяжелый'
            ],
            [
                'name' => 'Холодильник Samsung',
                'description' => 'Двухкамерный холодильник No Frost 350л',
                'price' => 85000.00,
                'category' => 'тяжелый'
            ],
            [
                'name' => 'Диван 3-местный',
                'description' => 'Удобный диван из натуральной кожи',
                'price' => 120000.00,
                'category' => 'тяжелый'
            ],
            [
                'name' => 'Тренажер беговая дорожка',
                'description' => 'Профессиональная беговая дорожка для дома',
                'price' => 150000.00,
                'category' => 'тяжелый'
            ],
        ];

        foreach ($products as $product) {
            $category = $categories->where('name', $product['category'])->first();

            Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'category_id' => $category->id,
            ]);
        }
    }
}
