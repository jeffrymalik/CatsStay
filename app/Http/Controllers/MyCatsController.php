<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MyCatsController extends Controller
{
    public function index()
    {
        $cats = Cat::where('user_id', Auth::id())
                   ->where('is_active', true)
                   ->orderBy('created_at', 'desc')
                   ->get();
        
        return view('pages.dashboard_user.my-cats.index', compact('cats'));
    }

    public function create()
    {
        return view('pages.dashboard_user.my-cats.form', [
            'cat' => null,
            'isEdit' => false
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'breed' => 'nullable|string|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'weight' => 'nullable|numeric|min:0|max:50',
            'color' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'medical_notes' => 'nullable|string|max:1000',
            'personality_traits' => 'nullable|string|max:500',
            'care_instructions' => 'nullable|string|max:500',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('cats', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['is_active'] = true;

        Cat::create($validated);

        return redirect()->route('my-cats.index')
            ->with('success', 'Cat added successfully!');
    }

    public function edit($id)
    {
        $cat = Cat::where('user_id', Auth::id())->findOrFail($id);

        return view('pages.dashboard_user.my-cats.form', [
            'cat' => $cat,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, $id)
    {
        $cat = Cat::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'breed' => 'nullable|string|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'weight' => 'nullable|numeric|min:0|max:50',
            'color' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'medical_notes' => 'nullable|string|max:1000',
            'personality_traits' => 'nullable|string|max:500',
            'care_instructions' => 'nullable|string|max:500',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($cat->photo) {
                Storage::disk('public')->delete($cat->photo);
            }
            $validated['photo'] = $request->file('photo')->store('cats', 'public');
        }

        $cat->update($validated);

        return redirect()->route('my-cats.index')
            ->with('success', 'Cat updated successfully!');
    }

    public function destroy($id)
    {
        $cat = Cat::where('user_id', Auth::id())->findOrFail($id);
        
        // Soft delete
        $cat->delete();

        return redirect()->route('my-cats.index')
            ->with('success', 'Cat removed successfully!');
    }

    public function show($id)
    {
        $cat = Cat::where('user_id', Auth::id())->findOrFail($id);

        return view('pages.dashboard_user.my-cats.show', compact('cat'));
    }
}