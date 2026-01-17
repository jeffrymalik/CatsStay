<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PetSitterProfile;
use App\Models\Address;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ===================================
        // 1. ADMIN USER
        // ===================================
        User::create([
            'name' => 'Admin CatsStay',
            'email' => 'admin@catsstay.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'admin',
            'bio' => 'Administrator platform Cats Stay',
            'date_of_birth' => '1998-01-01',
            'gender' => 'male',
            'photo' => null,
            'is_verified' => true,
            'status' => 'active',
            'last_login_at' => now(),
            'email_verified_at' => now(),
        ]);

        // ===================================
        // 2. SITTER DEMO (Verified, All Services)
        // ===================================
        $sitter1 = User::create([
            'name' => 'Sitter Demo',
            'email' => 'sitter@catsstay.com',
            'password' => Hash::make('password'),
            'phone' => '082233445566',
            'role' => 'sitter',
            'bio' => 'Cat sitter berpengalaman dengan lebih dari 5 tahun pengalaman merawat kucing. Saya menyediakan lingkungan yang aman dan nyaman untuk kucing kesayangan Anda.',
            'date_of_birth' => '2000-05-10',
            'gender' => 'female',
            'photo' => null,
            'is_verified' => true,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        PetSitterProfile::create([
            'user_id' => $sitter1->id,
            'years_of_experience' => 5,
            'is_verified' => true,
            'verified_at' => now(),
            
            // Services - ALL ENABLED
            'offers_cat_sitting' => true,
            'offers_grooming' => true,
            'offers_home_visit' => true,
            
            // Pricing
            'cat_sitting_price' => 200000,
            'grooming_price' => 300000,
            'home_visit_price' => 150000,
            
            // Descriptions
            'cat_sitting_description' => 'Penitipan kucing di rumah saya dengan perawatan 24/7, update harian via foto/video, dan banyak kasih sayang.',
            'grooming_description' => 'Paket grooming lengkap meliputi mandi, sisir bulu, potong kuku, dan pembersihan telinga.',
            'home_visit_description' => 'Kunjungan harian ke rumah Anda untuk memberi makan, bermain, dan merawat kucing di lingkungan familiar mereka.',
            
            // Additional info
            'max_cats_accepted' => 3,
            'home_description' => 'Apartemen 2 kamar dengan ruang khusus untuk kucing. Dilengkapi cat tree, window perch, dan mainan kucing.',
            'home_photos' => null,
            
            // Availability
            'is_available' => true,
            'response_time' => '< 1 hour',
            
            // Stats
            'rating_average' => 4.85,
            'total_bookings' => 50,
            'completed_bookings' => 48,
            'total_reviews' => 35,
        ]);

        Address::create([
            'user_id' => $sitter1->id,
            'label' => 'Home',
            'full_address' => 'Jl. Kemang Raya No. 45, RT.5/RW.3',
            'city' => 'Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'postal_code' => '12730',
            'is_primary' => true,
        ]);

        // ===================================
        // 3. SITTER 2 (Verified, Cat Sitting Only)
        // ===================================
        $sitter2 = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@catsstay.com',
            'password' => Hash::make('password'),
            'phone' => '081345678901',
            'role' => 'sitter',
            'bio' => 'Passionate cat lover specializing in cat sitting services. Your cats will receive personalized care and attention in a safe, loving home environment.',
            'date_of_birth' => '1995-03-15',
            'gender' => 'female',
            'photo' => null,
            'is_verified' => true,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        PetSitterProfile::create([
            'user_id' => $sitter2->id,
            'years_of_experience' => 4,
            'is_verified' => true,
            'verified_at' => now(),
            
            // Services - CAT SITTING ONLY
            'offers_cat_sitting' => true,
            'offers_grooming' => false,
            'offers_home_visit' => false,
            
            // Pricing
            'cat_sitting_price' => 175000,
            'grooming_price' => null,
            'home_visit_price' => null,
            
            // Descriptions
            'cat_sitting_description' => 'Full-time cat sitting with daily photo updates, playtime sessions, and special attention to dietary needs.',
            'grooming_description' => null,
            'home_visit_description' => null,
            
            // Additional info
            'max_cats_accepted' => 2,
            'home_description' => 'Quiet apartment perfect for cats who need calm environment. Multiple cozy spots and climbing areas.',
            'home_photos' => null,
            
            // Availability
            'is_available' => true,
            'response_time' => '< 2 hours',
            
            // Stats
            'rating_average' => 4.90,
            'total_bookings' => 30,
            'completed_bookings' => 29,
            'total_reviews' => 20,
        ]);

        Address::create([
            'user_id' => $sitter2->id,
            'label' => 'Home',
            'full_address' => 'Jl. Wijaya I No. 23, Kebayoran Baru',
            'city' => 'Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'postal_code' => '12170',
            'is_primary' => true,
        ]);

        // ===================================
        // 4. SITTER 3 (Verified, Grooming Specialist)
        // ===================================
        $sitter3 = User::create([
            'name' => 'Michael Chen',
            'email' => 'michael@catsstay.com',
            'password' => Hash::make('password'),
            'phone' => '081456789012',
            'role' => 'sitter',
            'bio' => 'Professional cat groomer with certification. Specializing in Persian and long-hair breeds. Gentle handling for anxious cats.',
            'date_of_birth' => '1992-07-20',
            'gender' => 'male',
            'photo' => null,
            'is_verified' => true,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        PetSitterProfile::create([
            'user_id' => $sitter3->id,
            'years_of_experience' => 7,
            'is_verified' => true,
            'verified_at' => now(),
            
            // Services - GROOMING + CAT SITTING
            'offers_cat_sitting' => true,
            'offers_grooming' => true,
            'offers_home_visit' => false,
            
            // Pricing
            'cat_sitting_price' => 225000,
            'grooming_price' => 350000,
            'home_visit_price' => null,
            
            // Descriptions
            'cat_sitting_description' => 'Professional cat care with medical monitoring. Experienced with senior cats and special needs.',
            'grooming_description' => 'Premium grooming service including bath, de-shedding treatment, nail trim, ear cleaning, and styling for show cats.',
            'home_visit_description' => null,
            
            // Additional info
            'max_cats_accepted' => 4,
            'home_description' => 'Large house with professional grooming station. Climate-controlled environment. Separate areas for multiple cats.',
            'home_photos' => null,
            
            // Availability
            'is_available' => true,
            'response_time' => '< 1 hour',
            
            // Stats
            'rating_average' => 4.95,
            'total_bookings' => 75,
            'completed_bookings' => 73,
            'total_reviews' => 48,
        ]);

        Address::create([
            'user_id' => $sitter3->id,
            'label' => 'Home',
            'full_address' => 'Jl. Pulo Mas Raya No. 78, Kayu Putih',
            'city' => 'Jakarta Timur',
            'province' => 'DKI Jakarta',
            'postal_code' => '13210',
            'is_primary' => true,
        ]);

        // ===================================
        // 5. SITTER 4 (Verified, Home Visit Only)
        // ===================================
        $sitter4 = User::create([
            'name' => 'Amanda Putri',
            'email' => 'amanda@catsstay.com',
            'password' => Hash::make('password'),
            'phone' => '081567890123',
            'role' => 'sitter',
            'bio' => 'Mobile cat sitter providing in-home care services. Perfect for cats who prefer their own environment. Flexible scheduling available.',
            'date_of_birth' => '1997-11-08',
            'gender' => 'female',
            'photo' => null,
            'is_verified' => true,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        PetSitterProfile::create([
            'user_id' => $sitter4->id,
            'years_of_experience' => 3,
            'is_verified' => true,
            'verified_at' => now(),
            
            // Services - HOME VISIT ONLY
            'offers_cat_sitting' => false,
            'offers_grooming' => false,
            'offers_home_visit' => true,
            
            // Pricing
            'cat_sitting_price' => null,
            'grooming_price' => null,
            'home_visit_price' => 125000,
            
            // Descriptions
            'cat_sitting_description' => null,
            'grooming_description' => null,
            'home_visit_description' => 'Daily home visits including feeding, litter box cleaning, playtime, and sending photo updates. Perfect for cats who are stressed by new environments.',
            
            // Additional info
            'max_cats_accepted' => 3,
            'home_description' => null,
            'home_photos' => null,
            
            // Availability
            'is_available' => true,
            'response_time' => '< 6 hours',
            
            // Stats
            'rating_average' => 4.75,
            'total_bookings' => 40,
            'completed_bookings' => 38,
            'total_reviews' => 25,
        ]);

        Address::create([
            'user_id' => $sitter4->id,
            'label' => 'Home',
            'full_address' => 'Jl. Fatmawati Raya No. 56, Cipete Selatan',
            'city' => 'Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'postal_code' => '12410',
            'is_primary' => true,
        ]);

        // ===================================
        // 6. SITTER 5 (Verified, Not Available - for testing)
        // ===================================
        $sitter5 = User::create([
            'name' => 'David Santoso',
            'email' => 'david@catsstay.com',
            'password' => Hash::make('password'),
            'phone' => '081678901234',
            'role' => 'sitter',
            'bio' => 'Veterinary assistant turned cat sitter. Expert in handling cats with medical conditions and special needs.',
            'date_of_birth' => '1994-02-14',
            'gender' => 'male',
            'photo' => null,
            'is_verified' => true,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        PetSitterProfile::create([
            'user_id' => $sitter5->id,
            'years_of_experience' => 6,
            'is_verified' => true,
            'verified_at' => now(),
            
            // Services - ALL ENABLED
            'offers_cat_sitting' => true,
            'offers_grooming' => true,
            'offers_home_visit' => true,
            
            // Pricing
            'cat_sitting_price' => 250000,
            'grooming_price' => 300000,
            'home_visit_price' => 175000,
            
            // Descriptions
            'cat_sitting_description' => 'Medical care available for cats with chronic conditions. Medication administration and health monitoring included.',
            'grooming_description' => 'Gentle grooming for cats with skin sensitivities. Hypoallergenic products available.',
            'home_visit_description' => 'Professional home visits with medical monitoring and detailed health reports.',
            
            // Additional info
            'max_cats_accepted' => 2,
            'home_description' => 'Modern apartment with medical supplies and monitoring equipment. Perfect for cats requiring special care.',
            'home_photos' => null,
            
            // Availability - NOT AVAILABLE
            'is_available' => false,
            'response_time' => '< 1 hour',
            
            // Stats
            'rating_average' => 5.00,
            'total_bookings' => 60,
            'completed_bookings' => 60,
            'total_reviews' => 42,
        ]);

        Address::create([
            'user_id' => $sitter5->id,
            'label' => 'Home',
            'full_address' => 'Jl. Tebet Barat Dalam No. 12A',
            'city' => 'Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'postal_code' => '12810',
            'is_primary' => true,
        ]);

        // ===================================
        // 7. NORMAL USER
        // ===================================
        User::create([
            'name' => 'User Normal',
            'email' => 'user@catsstay.com',
            'password' => Hash::make('password'),
            'phone' => null,
            'role' => 'normal',
            'bio' => null,
            'date_of_birth' => null,
            'gender' => null,
            'photo' => null,
            'is_verified' => true,
            'status' => 'active',
            'email_verified_at' => null,
        ]);

        $this->command->info('✅ All users seeded successfully!');
        $this->command->info('');
        $this->command->info('📧 Login Credentials:');
        $this->command->info('   Admin: admin@catsstay.com / password');
        $this->command->info('   Sitter Demo (All Services): sitter@catsstay.com / password');
        $this->command->info('   Sitter 2 (Cat Sitting): sarah@catsstay.com / password');
        $this->command->info('   Sitter 3 (Grooming): michael@catsstay.com / password');
        $this->command->info('   Sitter 4 (Home Visit): amanda@catsstay.com / password');
        $this->command->info('   Sitter 5 (Unavailable): david@catsstay.com / password');
        $this->command->info('   Normal User: user@catsstay.com / password');
    }
}