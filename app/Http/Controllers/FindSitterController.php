<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FindSitterController extends Controller
{
    public function index(Request $request) 
    {
        // Get service filter from URL parameter
        $selectedService = $request->query('service');
        
        // Hardcoded sitters data with services
        $allSitters = [
            [
                'id' => 1,
                'name' => 'Sarah Johnson',
                'location' => 'Jakarta Selatan',
                'location_slug' => 'jakarta-selatan',
                'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&size=200&background=FF9800&color=fff',
                'rating' => 4.9,
                'reviews_count' => 127,
                'bio' => 'Experienced cat lover with a cozy home environment. I treat every cat like family!',
                'bookings_count' => 156,
                'experience_years' => 5,
                'price_per_day' => 75000,
                'verified' => true,
                'services' => ['cat-sitting', 'grooming'],
            ],
            [
                'id' => 2,
                'name' => 'Ahmad Pratama',
                'location' => 'Jakarta Pusat',
                'location_slug' => 'jakarta-pusat',
                'avatar' => 'https://ui-avatars.com/api/?name=Ahmad+Pratama&size=200&background=2196F3&color=fff',
                'rating' => 4.8,
                'reviews_count' => 95,
                'bio' => 'Professional groomer with certification. Specialized in Persian and Maine Coon cats.',
                'bookings_count' => 120,
                'experience_years' => 4,
                'price_per_day' => 80000,
                'verified' => true,
                'services' => ['grooming', 'cat-sitting'],
            ],
            [
                'id' => 3,
                'name' => 'Lisa Anderson',
                'location' => 'Jakarta Utara',
                'location_slug' => 'jakarta-utara',
                'avatar' => 'https://ui-avatars.com/api/?name=Lisa+Anderson&size=200&background=4CAF50&color=fff',
                'rating' => 5.0,
                'reviews_count' => 203,
                'bio' => 'Veterinary nurse with 7+ years experience. Your cat is in safe, professional hands.',
                'bookings_count' => 245,
                'experience_years' => 7,
                'price_per_day' => 95000,
                'verified' => true,
                'services' => ['cat-sitting', 'grooming', 'home-visit'],
            ],
            [
                'id' => 4,
                'name' => 'Budi Santoso',
                'location' => 'Jakarta Barat',
                'location_slug' => 'jakarta-barat',
                'avatar' => 'https://ui-avatars.com/api/?name=Budi+Santoso&size=200&background=9C27B0&color=fff',
                'rating' => 4.7,
                'reviews_count' => 78,
                'bio' => 'Love spending time with cats! I have a spacious home with plenty of toys and climbing trees.',
                'bookings_count' => 89,
                'experience_years' => 3,
                'price_per_day' => 65000,
                'verified' => false,
                'services' => ['cat-sitting', 'home-visit'],
            ],
            [
                'id' => 5,
                'name' => 'Michelle Chen',
                'location' => 'Tangerang',
                'location_slug' => 'tangerang',
                'avatar' => 'https://ui-avatars.com/api/?name=Michelle+Chen&size=200&background=F44336&color=fff',
                'rating' => 4.9,
                'reviews_count' => 142,
                'bio' => 'Cat behaviorist and trainer. Perfect for cats with special needs or behavioral issues.',
                'bookings_count' => 167,
                'experience_years' => 6,
                'price_per_day' => 90000,
                'verified' => true,
                'services' => ['cat-sitting', 'grooming', 'home-visit'],
            ],
            [
                'id' => 6,
                'name' => 'Rudi Hermawan',
                'location' => 'Depok',
                'location_slug' => 'depok',
                'avatar' => 'https://ui-avatars.com/api/?name=Rudi+Hermawan&size=200&background=FF5722&color=fff',
                'rating' => 4.6,
                'reviews_count' => 54,
                'bio' => 'Friendly and reliable. I send daily photo updates and keep you informed about your cat.',
                'bookings_count' => 67,
                'experience_years' => 2,
                'price_per_day' => 60000,
                'verified' => false,
                'services' => ['cat-sitting'],
            ],
            [
                'id' => 7,
                'name' => 'Diana Putri',
                'location' => 'Jakarta Timur',
                'location_slug' => 'jakarta-timur',
                'avatar' => 'https://ui-avatars.com/api/?name=Diana+Putri&size=200&background=E91E63&color=fff',
                'rating' => 4.8,
                'reviews_count' => 110,
                'bio' => 'Home visit specialist. I come to your place so your cat stays comfortable in familiar environment.',
                'bookings_count' => 134,
                'experience_years' => 4,
                'price_per_day' => 70000,
                'verified' => true,
                'services' => ['home-visit', 'cat-sitting'],
            ],
            [
                'id' => 8,
                'name' => 'Tommy Lee',
                'location' => 'Jakarta Selatan',
                'location_slug' => 'jakarta-selatan',
                'avatar' => 'https://ui-avatars.com/api/?name=Tommy+Lee&size=200&background=00BCD4&color=fff',
                'rating' => 4.9,
                'reviews_count' => 156,
                'bio' => 'Former vet assistant with medication administration experience. Available 24/7 for emergencies.',
                'bookings_count' => 189,
                'experience_years' => 5,
                'price_per_day' => 85000,
                'verified' => true,
                'services' => ['cat-sitting', 'grooming', 'home-visit'],
            ],
            [
                'id' => 9,
                'name' => 'Siti Nurhaliza',
                'location' => 'Bogor',
                'location_slug' => 'bogor',
                'avatar' => 'https://ui-avatars.com/api/?name=Siti+Nurhaliza&size=200&background=3F51B5&color=fff',
                'rating' => 4.7,
                'reviews_count' => 88,
                'bio' => 'Patient and gentle with shy or anxious cats. I create a calm, stress-free environment.',
                'bookings_count' => 102,
                'experience_years' => 3,
                'price_per_day' => 72000,
                'verified' => true,
                'services' => ['cat-sitting', 'home-visit'],
            ],
            [
                'id' => 10,
                'name' => 'David Wilson',
                'location' => 'Bekasi',
                'location_slug' => 'bekasi',
                'avatar' => 'https://ui-avatars.com/api/?name=David+Wilson&size=200&background=673AB7&color=fff',
                'rating' => 4.8,
                'reviews_count' => 115,
                'bio' => 'Professional groomer with modern equipment. Specializing in long-haired cat breeds.',
                'bookings_count' => 138,
                'experience_years' => 4,
                'price_per_day' => 78000,
                'verified' => true,
                'services' => ['grooming', 'cat-sitting'],
            ],
            [
                'id' => 11,
                'name' => 'Sophia Martinez',
                'location' => 'Tangerang',
                'location_slug' => 'tangerang',
                'avatar' => 'https://ui-avatars.com/api/?name=Sophia+Martinez&size=200&background=FFEB3B&color=333',
                'rating' => 4.9,
                'reviews_count' => 48,
                'bio' => 'Cat behavior specialist who understands feline psychology. Perfect for anxious cats.',
                'bookings_count' => 92,
                'experience_years' => 6,
                'price_per_day' => 88000,
                'verified' => true,
                'services' => ['cat-sitting', 'home-visit'],
            ],
            [
                'id' => 12,
                'name' => 'Kevin Susanto',
                'location' => 'Bekasi',
                'location_slug' => 'bekasi',
                'avatar' => 'https://ui-avatars.com/api/?name=Kevin+Susanto&size=200&background=795548&color=fff',
                'rating' => 4.6,
                'reviews_count' => 20,
                'bio' => 'Reliable and punctual cat sitter. I follow your instructions carefully and maintain routines.',
                'bookings_count' => 35,
                'experience_years' => 2,
                'price_per_day' => 68000,
                'verified' => false,
                'services' => ['cat-sitting', 'home-visit'],
            ],
        ];

        // Filter sitters by service if service parameter exists
        if ($selectedService) {
            $sitters = array_filter($allSitters, function($sitter) use ($selectedService) {
                return in_array($selectedService, $sitter['services']);
            });
            // Re-index array after filter
            $sitters = array_values($sitters);
        } else {
            $sitters = $allSitters;
        }

        // Get service name for display
        $serviceName = null;
        if ($selectedService) {
            $serviceNames = [
                'cat-sitting' => 'Cat Sitting',
                'grooming' => 'Grooming',
                'home-visit' => 'Home Visit'
            ];
            $serviceName = $serviceNames[$selectedService] ?? null;
        }

        return view('pages.dashboard_user.findsitter', compact('sitters', 'selectedService', 'serviceName'));
    }
}