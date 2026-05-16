<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Resident;
use App\Models\User;
use App\Models\Visit;
use App\Models\Visitor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate([
            'email' => 'admin@avms.com',
        ], [
            'name'     => 'System Administrator',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Guards
        $guards = [
            ['name' => 'James Kariuki',  'email' => 'guard1@avms.com'],
            ['name' => 'Peter Odhiambo', 'email' => 'guard2@avms.com'],
        ];
        foreach ($guards as $g) {
            User::updateOrCreate([
                'email' => $g['email'],
            ], [
                'name'     => $g['name'],
                'password' => Hash::make('password'),
                'role'     => 'guard',
            ]);
        }

        // Apartment rooms
        $blocks  = ['A', 'B', 'C'];
        $floors  = [1, 2, 3, 4];
        $apartments = [];
        $aptNum = 101;
        foreach ($blocks as $block) {
            foreach ($floors as $floor) {
                for ($u = 1; $u <= 3; $u++) {
                    $apartments[] = Apartment::updateOrCreate([
                        'apartment_number' => $block . $aptNum,
                    ], [
                        'block_name'       => 'Block ' . $block,
                        'floor_number'     => $floor,
                        'status'           => 'vacant',
                    ]);
                    $aptNum++;
                }
            }
        }

        // Resident users + resident records
        $tenantData = [
            ['name' => 'Alice Wanjiku',  'email' => 'alice@avms.com',  'phone' => '0712345678', 'national_id' => 'KE001', 'gender' => 'female'],
            ['name' => 'Bob Mutua',       'email' => 'bob@avms.com',    'phone' => '0723456789', 'national_id' => 'KE002', 'gender' => 'male'],
            ['name' => 'Clara Njeri',     'email' => 'clara@avms.com',  'phone' => '0734567890', 'national_id' => 'KE003', 'gender' => 'female'],
            ['name' => 'David Otieno',    'email' => 'david@avms.com',  'phone' => '0745678901', 'national_id' => 'KE004', 'gender' => 'male'],
            ['name' => 'Eve Achieng',     'email' => 'eve@avms.com',    'phone' => '0756789012', 'national_id' => 'KE005', 'gender' => 'female'],
        ];

        $tenants = [];
        foreach ($tenantData as $i => $td) {
            $user = User::updateOrCreate([
                'email' => $td['email'],
            ], [
                'name'     => $td['name'],
                'password' => Hash::make('password'),
                'role'     => 'resident',
            ]);
            $apt = $apartments[$i];
            $apt->update(['status' => 'occupied']);
                $tenants[] = Resident::updateOrCreate([
                'user_id' => $user->id,
            ], [
                    'apartment_id' => $apt->id,
                'phone'        => $td['phone'],
                'national_id'  => $td['national_id'],
                'gender'       => $td['gender'],
            ]);
        }

        // Visitors
        $visitorData = [
            ['full_name' => 'John Kamau',    'phone_number' => '0700111222', 'national_id' => 'VIS001'],
            ['full_name' => 'Mary Wambui',   'phone_number' => '0700222333', 'national_id' => 'VIS002'],
            ['full_name' => 'Samuel Oduya',  'phone_number' => '0700333444', 'national_id' => 'VIS003'],
            ['full_name' => 'Grace Adhiambo','phone_number' => '0700444555', 'national_id' => 'VIS004'],
            ['full_name' => 'Paul Njoroge',  'phone_number' => '0700555666', 'national_id' => 'VIS005'],
            ['full_name' => 'Lucy Muthoni',  'phone_number' => '0700666777', 'national_id' => 'VIS006'],
        ];

        $visitors = [];
        foreach ($visitorData as $vd) {
            $visitors[] = Visitor::updateOrCreate([
                'national_id' => $vd['national_id'],
            ], $vd);
        }

        // Visits
        $purposes = ['Family visit', 'Delivery', 'Business meeting', 'Maintenance', 'Social visit'];
        foreach ($visitors as $i => $visitor) {
            $tenant = $tenants[$i % count($tenants)];
            // Completed past visit
            Visit::updateOrCreate([
                'visitor_id' => $visitor->id,
                'resident_id'  => $tenant->id,
                'purpose'    => $purposes[$i % count($purposes)],
                'status'     => 'completed',
            ], [
                'check_in_time'      => now()->subDays($i + 2)->setHour(10),
                'check_out_time'     => now()->subDays($i + 2)->setHour(12),
                'approved_by_resident' => true,
            ]);
        }

        // One active visit
        Visit::updateOrCreate([
            'visitor_id' => $visitors[0]->id,
            'resident_id'  => $tenants[0]->id,
            'purpose'    => 'Delivery package',
            'status'     => 'active',
        ], [
            'check_in_time'      => now()->subHour(),
            'check_out_time'     => null,
            'approved_by_resident' => true,
        ]);
    }
}
