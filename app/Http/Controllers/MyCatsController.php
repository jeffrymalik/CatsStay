<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyCatsController extends Controller
{
    // Hardcoded cats data
    private function getAllCats()
    {
        return [
            [
                'id' => 1,
                'name' => 'Luna',
                'breed' => 'Persian',
                'age' => '2 years',
                'birth_date' => '2022-03-15',
                'gender' => 'Female',
                'weight' => '4.5 kg',
                'color' => 'White with gray patches',
                'photo' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=400',
                'medical_notes' => 'Vaccinated (last: Jan 2024). Allergic to fish-based foods. Takes medication for mild anxiety.',
                'personality' => 'Shy and gentle. Loves to be petted but needs time to warm up to new people. Prefers quiet environments.',
                'special_instructions' => 'Feed twice daily (morning & evening). Prefers elevated sleeping spots. Brush fur daily to prevent matting.',
            ],
            [
                'id' => 2,
                'name' => 'Milo',
                'breed' => 'British Shorthair',
                'age' => '3 years',
                'birth_date' => '2021-07-20',
                'gender' => 'Male',
                'weight' => '5.8 kg',
                'color' => 'Gray (Blue)',
                'photo' => 'https://images.unsplash.com/photo-1573865526739-10c1dd7e1d0f?w=400',
                'medical_notes' => 'All vaccinations up to date. Neutered. No known allergies or health issues.',
                'personality' => 'Playful and energetic. Loves interactive toys and chasing laser pointers. Very friendly with strangers.',
                'special_instructions' => 'Needs 30 minutes of playtime twice daily. Keep away from plants (likes to nibble). Dry food only.',
            ],
            [
                'id' => 3,
                'name' => 'Whiskers',
                'breed' => 'Maine Coon',
                'age' => '1 year',
                'birth_date' => '2023-05-10',
                'gender' => 'Male',
                'weight' => '6.2 kg',
                'color' => 'Brown Tabby',
                'photo' => 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?w=400',
                'medical_notes' => 'Recent vaccinations (Nov 2024). Scheduled for neutering next month.',
                'personality' => 'Curious and adventurous. Loves climbing and exploring high places. Very vocal and talkative.',
                'special_instructions' => 'Large appetite - feed 3 times daily. Provide tall cat tree. Enjoys water play.',
            ],
            
        ];
    }

    /**
     * Display listing of cats
     */
    public function index()
    {
        $cats = $this->getAllCats();
        return view('pages.dashboard_user.my-cats.index', compact('cats'));
    }

    /**
     * Show form for creating new cat
     */
    public function create()
    {
        return view('pages.dashboard_user.my-cats.form', [
            'cat' => null,
            'isEdit' => false
        ]);
    }

    /**
     * Store newly created cat
     */
    public function store(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'breed' => 'nullable|string|max:100',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female',
            'weight' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:100',
            'medical_notes' => 'nullable|string|max:1000',
            'personality' => 'nullable|string|max:500',
            'special_instructions' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Please enter your cat\'s name',
            'birth_date.required' => 'Please select birth date',
            'birth_date.before' => 'Birth date must be in the past',
            'gender.required' => 'Please select gender',
        ]);

        // In real implementation: save to database
        // For now, just redirect with success message

        return redirect()->route('my-cats.index')
            ->with('success', 'Cat added successfully!');
    }

    /**
     * Show form for editing cat
     */
    public function edit($id)
    {
        $cats = $this->getAllCats();
        $cat = collect($cats)->firstWhere('id', $id);

        if (!$cat) {
            return redirect()->route('my-cats.index')
                ->with('error', 'Cat not found');
        }

        return view('pages.dashboard_user.my-cats.form', [
            'cat' => $cat,
            'isEdit' => true
        ]);
    }

    /**
     * Update cat information
     */
    public function update(Request $request, $id)
    {
        // Validate
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'breed' => 'nullable|string|max:100',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female',
            'weight' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:100',
            'medical_notes' => 'nullable|string|max:1000',
            'personality' => 'nullable|string|max:500',
            'special_instructions' => 'nullable|string|max:500',
        ]);

        // In real implementation: update in database
        
        return redirect()->route('my-cats.index')
            ->with('success', 'Cat updated successfully!');
    }

    /**
     * Delete cat
     */
    public function destroy($id)
    {
        // In real implementation: delete from database
        
        return redirect()->route('my-cats.index')
            ->with('success', 'Cat removed successfully!');
    }

    /**
     * Show cat details (optional - for view modal/page)
     */
    public function show($id)
    {
        $cats = $this->getAllCats();
        $cat = collect($cats)->firstWhere('id', $id);

        if (!$cat) {
            return redirect()->route('my-cats.index')
                ->with('error', 'Cat not found');
        }

        return view('pages.dashboard_user.my-cats.show', compact('cat'));
    }
}