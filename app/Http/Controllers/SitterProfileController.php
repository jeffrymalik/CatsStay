<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitterProfileController extends Controller
{
    public function show($id)
    {
        // Hardcoded sitters data (same as FindSitter but with more details)
        $allSitters = [
            [
                'id' => 1,
                'name' => 'Sarah Johnson',
                'location' => 'Jakarta Selatan',
                'location_slug' => 'jakarta-selatan',
                'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&size=400&background=FF9800&color=fff',
                'rating' => 4.9,
                'reviews_count' => 127,
                'bio' => 'Experienced cat lover with a cozy home environment. I treat every cat like family! I have been taking care of cats for over 5 years and absolutely love spending time with these adorable creatures. My home is cat-proofed with plenty of toys, scratching posts, and comfortable spaces for cats to relax.',
                'bookings_count' => 156,
                'experience_years' => 5,
                'verified' => true,
                'response_time' => '30 minutes',
                'services' => [
                    [
                        'type' => 'cat-sitting',
                        'name' => 'Cat Sitting',
                        'price' => 75000,
                        'description' => 'Full day care at my place with feeding, playing, and monitoring'
                    ],
                    [
                        'type' => 'grooming',
                        'name' => 'Grooming',
                        'price' => 50000,
                        'description' => 'Professional grooming including bathing, brushing, and nail trimming'
                    ],
                ],
                'gallery' => [
                    'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=500',
                    'https://images.unsplash.com/photo-1573865526739-10c1dd7e1d0f?w=500',
                    'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?w=500',
                    'https://images.unsplash.com/photo-1519052537078-e6302a4968d4?w=500',
                ],
                'reviews' => [
                    [
                        'user' => 'Amanda Putri',
                        'rating' => 5,
                        'date' => '2 days ago',
                        'comment' => 'Sarah took amazing care of my cat Luna! She sent daily photos and updates. Luna seemed so happy and comfortable. Highly recommend!',
                        'avatar' => 'https://ui-avatars.com/api/?name=Amanda+Putri&size=100&background=E91E63&color=fff'
                    ],
                    [
                        'user' => 'Ryan Wijaya',
                        'rating' => 5,
                        'date' => '1 week ago',
                        'comment' => 'Very professional and caring. My cat has special dietary needs and Sarah followed all instructions perfectly.',
                        'avatar' => 'https://ui-avatars.com/api/?name=Ryan+Wijaya&size=100&background=2196F3&color=fff'
                    ],
                    [
                        'user' => 'Linda Chen',
                        'rating' => 4,
                        'date' => '2 weeks ago',
                        'comment' => 'Great experience overall. Sarah is very communicative and sent lots of cute photos of my cats playing.',
                        'avatar' => 'https://ui-avatars.com/api/?name=Linda+Chen&size=100&background=4CAF50&color=fff'
                    ],
                ],
            ],
            [
                'id' => 2,
                'name' => 'Ahmad Pratama',
                'location' => 'Jakarta Pusat',
                'location_slug' => 'jakarta-pusat',
                'avatar' => 'https://ui-avatars.com/api/?name=Ahmad+Pratama&size=400&background=2196F3&color=fff',
                'rating' => 4.8,
                'reviews_count' => 95,
                'bio' => 'Professional groomer with certification. Specialized in Persian and Maine Coon cats. I have completed professional grooming courses and have experience handling all cat breeds. My grooming studio is equipped with modern tools and pet-safe products.',
                'bookings_count' => 120,
                'experience_years' => 4,
                'verified' => true,
                'response_time' => '1 hour',
                'services' => [
                    [
                        'type' => 'grooming',
                        'name' => 'Grooming',
                        'price' => 80000,
                        'description' => 'Premium grooming service with professional equipment'
                    ],
                    [
                        'type' => 'cat-sitting',
                        'name' => 'Cat Sitting',
                        'price' => 70000,
                        'description' => 'Day care service at my certified facility'
                    ],
                ],
                'gallery' => [
                    'https://images.unsplash.com/photo-1574158622682-e40e69881006?w=500',
                    'https://images.unsplash.com/photo-1543852786-1cf6624b9987?w=500',
                    'https://images.unsplash.com/photo-1529778873920-4da4926a72c2?w=500',
                    'https://images.unsplash.com/photo-1415369629372-26f2fe60c467?w=500',
                ],
                'reviews' => [
                    [
                        'user' => 'Siti Rahayu',
                        'rating' => 5,
                        'date' => '3 days ago',
                        'comment' => 'Ahmad is an excellent groomer! My Persian cat looks absolutely beautiful after his grooming session.',
                        'avatar' => 'https://ui-avatars.com/api/?name=Siti+Rahayu&size=100&background=9C27B0&color=fff'
                    ],
                    [
                        'user' => 'Michael Tan',
                        'rating' => 5,
                        'date' => '1 week ago',
                        'comment' => 'Very skilled and patient with cats. My cat was nervous at first but Ahmad handled it professionally.',
                        'avatar' => 'https://ui-avatars.com/api/?name=Michael+Tan&size=100&background=FF5722&color=fff'
                    ],
                    [
                        'user' => 'Diana Lestari',
                        'rating' => 4,
                        'date' => '2 weeks ago',
                        'comment' => 'Great grooming service! My Maine Coon looks fluffy and clean. Will definitely book again.',
                        'avatar' => 'https://ui-avatars.com/api/?name=Diana+Lestari&size=100&background=00BCD4&color=fff'
                    ],
                ],
            ],
            [
                'id' => 3,
                'name' => 'Lisa Anderson',
                'location' => 'Jakarta Utara',
                'location_slug' => 'jakarta-utara',
                'avatar' => 'https://ui-avatars.com/api/?name=Lisa+Anderson&size=400&background=4CAF50&color=fff',
                'rating' => 5.0,
                'reviews_count' => 203,
                'bio' => 'Veterinary nurse with 7+ years experience. Your cat is in safe, professional hands. I have medical training and can administer medications if needed. I understand cat behavior and health signs, ensuring your pet receives the best possible care.',
                'bookings_count' => 245,
                'experience_years' => 7,
                'verified' => true,
                'response_time' => '15 minutes',
                'services' => [
                    [
                        'type' => 'cat-sitting',
                        'name' => 'Cat Sitting',
                        'price' => 95000,
                        'description' => 'Professional cat care with medical knowledge and experience'
                    ],
                    [
                        'type' => 'grooming',
                        'name' => 'Grooming',
                        'price' => 75000,
                        'description' => 'Gentle grooming with health check included'
                    ],
                    [
                        'type' => 'home-visit',
                        'name' => 'Home Visit',
                        'price' => 60000,
                        'description' => 'Visit your home to feed and check on your cat'
                    ],
                ],
                'gallery' => [
                    'https://images.unsplash.com/photo-1478098711619-5ab0b478d6e6?w=500',
                    'https://images.unsplash.com/photo-1511044568932-338cba0ad803?w=500',
                    'https://images.unsplash.com/photo-1513245543132-31f507417b26?w=500',
                    'https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13?w=500',
                ],
                'reviews' => [
                    [
                        'user' => 'Robert Johnson',
                        'rating' => 5,
                        'date' => '1 day ago',
                        'comment' => 'Lisa is amazing! She noticed my cat was not feeling well and advised me to take him to vet. Very observant and caring.',
                        'avatar' => 'https://ui-avatars.com/api/?name=Robert+Johnson&size=100&background=3F51B5&color=fff'
                    ],
                    [
                        'user' => 'Dewi Sartika',
                        'rating' => 5,
                        'date' => '4 days ago',
                        'comment' => 'Best cat sitter ever! My cat needed medication and Lisa handled it perfectly. Very professional and knowledgeable.',
                        'avatar' => 'https://ui-avatars.com/api/?name=Dewi+Sartika&size=100&background=F44336&color=fff'
                    ],
                    [
                        'user' => 'Tommy Lee',
                        'rating' => 5,
                        'date' => '1 week ago',
                        'comment' => 'I trust Lisa completely with my cats. She has medical knowledge which gives me peace of mind when traveling.',
                        'avatar' => 'https://ui-avatars.com/api/?name=Tommy+Lee&size=100&background=673AB7&color=fff'
                    ],
                ],
            ],
            // Add more sitters as needed...
        ];

        // Find sitter by ID
        $sitter = collect($allSitters)->firstWhere('id', $id);

        // If sitter not found, redirect back or show 404
        if (!$sitter) {
            abort(404, 'Sitter not found');
        }

        return view('pages.dashboard_user.sitter-profile', compact('sitter'));
    }
}