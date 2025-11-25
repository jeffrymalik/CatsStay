<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectServiceController extends Controller
{
    public function index()
    {
        $services = [
            [
                'id' => 1,
                'name' => 'Cat Sitting',
                'slug' => 'cat-sitting',
                'icon' => '🏠',
                'description' => 'Your cat stays at a trusted sitter\'s home with full attention and care. Perfect for longer trips when you want your cat to have a cozy, home-like environment.',
                'price_note' => 'Varies by sitter',
                'features' => [
                    'Daily feeding & fresh water',
                    'Playtime & interaction',
                    'Litter box maintenance',
                    'Daily photo updates',
                    'Medication administration (if needed)',
                    'Comfortable sleeping area'
                ]
            ],
            [
                'id' => 2,
                'name' => 'Grooming',
                'slug' => 'grooming',
                'icon' => '✂️',
                'description' => 'Professional grooming services to keep your cat clean, healthy, and looking great. Gentle handling by experienced sitters.',
                'price_note' => 'Varies by sitter',
                'features' => [
                    'Bath with cat-safe shampoo',
                    'Brushing & de-shedding',
                    'Nail trimming',
                    'Ear cleaning',
                    'Eye cleaning',
                    'Blow dry & styling'
                ]
            ],
            [
                'id' => 3,
                'name' => 'Home Visit',
                'slug' => 'home-visit',
                'icon' => '🏡',
                'description' => 'Your cat stays comfortable in their own home. A trusted sitter visits to provide food, care, and companionship on your schedule.',
                'price_note' => 'Varies by sitter',
                'features' => [
                    'Feeding & fresh water',
                    'Playtime & cuddles',
                    'Litter box cleaning',
                    'Basic health check',
                    'Home security check',
                    'Plants watering (bonus!)'
                ]
            ]
        ];

        return view('pages.dashboard_user.services.selectservice', compact('services'));
    }

    public function select(Request $request, $slug)
    {
        // Validate service slug
        $validServices = ['cat-sitting', 'grooming', 'home-visit'];
        
        if (!in_array($slug, $validServices)) {
            return redirect()->route('select.service')->with('error', 'Service not found');
        }

        // Service data
        $services = [
            'cat-sitting' => [
                'id' => 1,
                'name' => 'Cat Sitting',
                'slug' => 'cat-sitting'
            ],
            'grooming' => [
                'id' => 2,
                'name' => 'Grooming',
                'slug' => 'grooming'
            ],
            'home-visit' => [
                'id' => 3,
                'name' => 'Home Visit',
                'slug' => 'home-visit'
            ]
        ];

        // Store in session for later use (optional, for booking flow)
        session(['selected_service' => $services[$slug]]);

        // Redirect to Find Sitter page with service parameter
        // Option 1: If you have named route 'sitters.index'
        // return redirect()->route('sitters.index', ['service' => $slug]);
        
        // Option 2: Direct URL redirect (more reliable)
        return redirect('/find-sitter?service=' . $slug);
    }
}