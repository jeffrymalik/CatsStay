<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class SelectServiceController extends Controller
{
    public function index()
    {
        // Get active services from database
        $services = Service::active()
                          ->orderBy('id')
                          ->get()
                          ->map(function($service) {
                              return [
                                  'id' => $service->id,
                                  'name' => $service->name,
                                  'slug' => $service->slug,
                                  'icon' => $service->icon,
                                  'description' => $service->description,
                                  'price_note' => $service->price_note,
                                  'features' => $service->features, // Already array
                              ];
                          });

        return view('pages.dashboard_user.services.selectservice', compact('services'));
    }

    public function select(Request $request, $slug)
    {
        // Validate service exists
        $service = Service::where('slug', $slug)
                         ->where('is_active', true)
                         ->first();
        
        if (!$service) {
            return redirect()->route('select.service')
                ->with('error', 'Service not found');
        }

        // Store in session
        session(['selected_service' => [
            'id' => $service->id,
            'name' => $service->name,
            'slug' => $service->slug
        ]]);

        // Redirect to Find Sitter
        return redirect('/find-sitter?service=' . $slug);
    }
}