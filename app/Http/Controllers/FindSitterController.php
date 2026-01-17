<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Add this import

class FindSitterController extends Controller
{
    public function index(Request $request) 
    {
        $selectedService = $request->query('service');
        
        // Get all verified and available sitters
        $query = User::where('role', 'sitter')
                    ->where('status', 'active')
                    ->whereHas('sitterProfile', function($q) {
                        $q->where('is_verified', true)
                          ->where('is_available', true);
                    })
                    ->with(['sitterProfile', 'addresses']);

        // Filter by service if provided
        if ($selectedService) {
            $offerField = 'offers_' . str_replace('-', '_', $selectedService);
            $priceField = str_replace('-', '_', $selectedService) . '_price';
            
            $query->whereHas('sitterProfile', function($q) use ($offerField, $priceField) {
                $q->where($offerField, true)
                  ->whereNotNull($priceField);
            });
        }

        $sitters = $query->get()->map(function($sitter) use ($selectedService) {
            $profile = $sitter->sitterProfile;
            $address = $sitter->addresses->first();
            
            // Get price for selected service
            $pricePerDay = null;
            if ($selectedService) {
                $priceField = str_replace('-', '_', $selectedService) . '_price';
                $pricePerDay = $profile->{$priceField};
            }
            
            // Get services offered
            $services = [];
            if ($profile->offers_cat_sitting) $services[] = 'cat-sitting';
            if ($profile->offers_grooming) $services[] = 'grooming';
            if ($profile->offers_home_visit) $services[] = 'home-visit';
            
            return [
                'id' => $sitter->id,
                'name' => $sitter->name,
                'location' => $address->city ?? 'N/A',
                'location_slug' => $address ? Str::slug($address->city) : 'na', // Changed here
                'avatar' => $sitter->avatar_url,
                'rating' => $profile->rating_average,
                'reviews_count' => $profile->total_reviews,
                'bio' => $sitter->bio,
                'bookings_count' => $profile->total_bookings,
                'experience_years' => $profile->years_of_experience,
                'price_per_day' => $pricePerDay ?? $profile->cat_sitting_price ?? 0,
                'verified' => $profile->is_verified,
                'services' => $services,
            ];
        });

        // Get service name for display
        $serviceName = null;
        if ($selectedService) {
            $service = Service::where('slug', $selectedService)->first();
            $serviceName = $service->name ?? null;
        }

        return view('pages.dashboard_user.findsitter', compact('sitters', 'selectedService', 'serviceName'));
    }
}