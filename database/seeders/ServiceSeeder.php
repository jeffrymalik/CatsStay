<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Cat Sitting',
                'slug' => 'cat-sitting',
                'icon' => '🏠', // atau 'fa-home'
                'short_description' => 'Your cat stays at a trusted sitter\'s home with full attention and care',
                'description' => 'Your cat stays at a trusted sitter\'s home with full attention and care. Perfect for longer trips when you want your cat to have a cozy, home-like environment.',
                'features' => json_encode([
                    'Daily feeding & fresh water',
                    'Playtime & interaction',
                    'Litter box maintenance',
                    'Daily photo updates',
                    'Medication administration (if needed)',
                    'Comfortable sleeping area'
                ]),
                'price_note' => 'Varies by sitter',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grooming',
                'slug' => 'grooming',
                'icon' => '✂️', // atau 'fa-cut'
                'short_description' => 'Professional grooming services to keep your cat clean and healthy',
                'description' => 'Professional grooming services to keep your cat clean, healthy, and looking great. Gentle handling by experienced sitters.',
                'features' => json_encode([
                    'Bath with cat-safe shampoo',
                    'Brushing & de-shedding',
                    'Nail trimming',
                    'Ear cleaning',
                    'Eye cleaning',
                    'Blow dry & styling'
                ]),
                'price_note' => 'Varies by sitter',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Home Visit',
                'slug' => 'home-visit',
                'icon' => '🏡', // atau 'fa-walking'
                'short_description' => 'Daily visits to your home to care for your cat',
                'description' => 'Your cat stays comfortable in their own home. A trusted sitter visits to provide food, care, and companionship on your schedule.',
                'features' => json_encode([
                    'Feeding & fresh water',
                    'Playtime & cuddles',
                    'Litter box cleaning',
                    'Basic health check',
                    'Home security check',
                    'Plants watering (bonus!)'
                ]),
                'price_note' => 'Varies by sitter',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('services')->insert($services);
    }
}