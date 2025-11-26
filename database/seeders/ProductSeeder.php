<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder; 
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        if (Product::count() > 0) {
            return; // Already seeded
        }

        $response = Http::get('https://fakestoreapi.com/products');
        if ($response->successful()) {
            $data = $response->json();
            foreach ($data as $item) {
                Product::create([
                    'name' => $item['title'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'category' => $item['category'],
                ]);
            }
        }
    }
}