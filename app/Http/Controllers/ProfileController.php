<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Review;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display My Profile section
     */
    public function index()
    {
        $user = Auth::user();

        return view('pages.profile.index', compact('user'));
    }

    /**
     * Display Address section
     */
    public function address()
    {
        $user = Auth::user();
        $addresses = Address::where('user_id', $user->id)->get();

        return view('pages.profile.address', compact('user', 'addresses'));
    }

    /**
     * Display My Reviews section
     */
    public function reviews()
    {
        $user = Auth::user();
        
        $reviews = Review::where('user_id', $user->id)
                        ->with(['sitter', 'booking.service'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('pages.profile.reviews', compact('user', 'reviews'));
    }

    /**
     * Display Notifications section
     */
    public function notifications()
    {
        $user = Auth::user();
        
        $notifications = Notification::where('user_id', $user->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        $unreadCount = $notifications->where('is_read', false)->count();

        return view('pages.profile.notifications', compact('user', 'notifications', 'unreadCount'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Store new address
     */
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'full_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);

        $validated['user_id'] = Auth::id();
        
        // If set_primary is checked or this is the first address
        if ($request->has('set_primary') || Address::where('user_id', Auth::id())->count() === 0) {
            // Unset all other primary addresses
            Address::where('user_id', Auth::id())->update(['is_primary' => false]);
            $validated['is_primary'] = true;
        } else {
            $validated['is_primary'] = false;
        }

        Address::create($validated);

        return redirect()->route('profile.address')
            ->with('success', 'Address added successfully!');
    }

    /**
     * Update existing address
     */
    public function updateAddress(Request $request, $id)
    {
        $address = Address::where('id', $id)
                         ->where('user_id', Auth::id())
                         ->firstOrFail();

        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'full_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);

        // Handle primary flag
        if ($request->has('set_primary')) {
            Address::where('user_id', Auth::id())->update(['is_primary' => false]);
            $validated['is_primary'] = true;
        }

        $address->update($validated);

        return redirect()->route('profile.address')
            ->with('success', 'Address updated successfully!');
    }

    /**
     * Set address as primary
     */
    public function setPrimaryAddress($id)
    {
        $address = Address::where('id', $id)
                         ->where('user_id', Auth::id())
                         ->firstOrFail();

        // Unset all primary
        Address::where('user_id', Auth::id())->update(['is_primary' => false]);
        
        // Set this as primary
        $address->update(['is_primary' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Primary address updated successfully!'
        ]);
    }

    /**
     * Delete address
     */
    public function destroyAddress($id)
    {
        $address = Address::where('id', $id)
                         ->where('user_id', Auth::id())
                         ->firstOrFail();

        // Prevent deleting primary address
        if ($address->is_primary) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete primary address. Please set another address as primary first.'
            ], 400);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully!'
        ]);
    }

    /**
     * Get address data for editing
     */
    public function getAddress($id)
    {
        $address = Address::where('id', $id)
                         ->where('user_id', Auth::id())
                         ->firstOrFail();

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'new_password_confirmation' => 'required',
        ], [
            'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
            'new_password.min' => 'Password must be at least 8 characters.',
            'new_password.confirmed' => 'Password confirmation does not match.',
        ]);

        $user = Auth::user();
        
        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile.index')
                ->with('error', 'Current password is incorrect!');
        }
        
        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password changed successfully!');
    }

    // ========================================
    // SITTER PROFILE METHODS
    // ========================================

    /**
     * Display profile setup page (for sitters)
     */
   /**
 * Display profile setup page (for sitters)
 */
    public function profile()
    {
        $user = Auth::user();
        
        if (!$user->isSitter()) {
            return redirect()->route('user.dashboard');
        }

        $profile = $user->sitterProfile;
        $addresses = Address::where('user_id', $user->id)->get();

        return view('pages.dashboard_sitter.profile', compact('user', 'profile', 'addresses'));
    }

    /**
     * Update sitter profile
     */
    /**
 * Update sitter profile
 */
    public function updateSitterProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user->isSitter()) {
            return redirect()->route('user.dashboard');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'bio' => 'required|string|max:1000',
            
            // Sitter profile
            'years_of_experience' => 'required|integer|min:0',
            'home_description' => 'nullable|string|max:1000',
            'response_time' => 'required|string',
            'max_cats_accepted' => 'required|integer|min:1',
            
            // Availability
            'is_available' => 'required|boolean',
        ]);

        // Update user basic info
        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'bio' => $validated['bio'],
        ]);

        // Update sitter profile
        $user->sitterProfile->update([
            'years_of_experience' => $validated['years_of_experience'],
            'home_description' => $validated['home_description'] ?? null,
            'response_time' => $validated['response_time'],
            'max_cats_accepted' => $validated['max_cats_accepted'],
            'is_available' => $validated['is_available'],
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Upload avatar for sitter
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        // Upload new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        
        $user->update(['photo' => $path]);

        return back()->with('success', 'Avatar updated successfully!');
    }

    /**
     * Upload gallery photos for sitter
     */
    public function uploadGallery(Request $request)
    {
        $request->validate([
            'photos' => 'required|array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        
        if (!$user->isSitter()) {
            return back()->with('error', 'Unauthorized access');
        }
        
        $profile = $user->sitterProfile;

        $photos = $profile->home_photos ?? [];

        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('gallery', 'public');
            $photos[] = $path;
        }

        $profile->update(['home_photos' => $photos]);

        return back()->with('success', 'Photos uploaded successfully!');
    }

    /**
     * Delete gallery photo for sitter
     */
    public function deleteGallery($index)
    {
        $user = Auth::user();
        
        if (!$user->isSitter()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $profile = $user->sitterProfile;
        $photos = $profile->home_photos ?? [];

        if (isset($photos[$index])) {
            // Delete file from storage
            Storage::disk('public')->delete($photos[$index]);
            
            // Remove from array and re-index
            unset($photos[$index]);
            $photos = array_values($photos);
            
            // Update database
            $profile->update(['home_photos' => $photos]);
            
            return response()->json([
                'success' => true,
                'message' => 'Photo deleted successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Photo not found'
        ], 404);
    }
}