<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Tenant;
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
        User::create([
            'name'     => 'System Administrator',
            'email'    => 'admin@avms.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Guards
        $guards = [
            ['name' => 'James Kariuki',  'email' => 'guard1@avms.com'],
            ['name' => 'Peter Odhiambo', 'email' => 'guard2@avms.com'],
        ];
        foreach ($guards as $g) {
            User::create([
                'name'     => $g['name'],
                'email'    => $g['email'],
                'password' => Hash::make('password'),
                'role'     => 'guard',
            ]);
        }

        // Apartments
        $blocks  = ['A', 'B', 'C'];
        $floors  = [1, 2, 3, 4];
        $apartments = [];
        $aptNum = 101;
        foreach ($blocks as $block) {
            foreach ($floors as $floor) {
                for ($u = 1; $u <= 3; $u++) {
                    $apartments[] = Apartment::create([
                        'apartment_number' => $block . $aptNum,
                        'block_name'       => 'Block ' . $block,
                        'floor_number'     => $floor,
                        'status'           => 'vacant',
                    ]);
                    $aptNum++;
                }
            }
        }

        // Tenant users + tenant records
        $tenantData = [
            ['name' => 'Alice Wanjiku',  'email' => 'alice@avms.com',  'phone' => '0712345678', 'national_id' => 'KE001', 'gender' => 'female'],
            ['name' => 'Bob Mutua',       'email' => 'bob@avms.com',    'phone' => '0723456789', 'national_id' => 'KE002', 'gender' => 'male'],
            ['name' => 'Clara Njeri',     'email' => 'clara@avms.com',  'phone' => '0734567890', 'national_id' => 'KE003', 'gender' => 'female'],
            ['name' => 'David Otieno',    'email' => 'david@avms.com',  'phone' => '0745678901', 'national_id' => 'KE004', 'gender' => 'male'],
            ['name' => 'Eve Achieng',     'email' => 'eve@avms.com',    'phone' => '0756789012', 'national_id' => 'KE005', 'gender' => 'female'],
        ];

        $tenants = [];
        foreach ($tenantData as $i => $td) {
            $user = User::create([
                'name'     => $td['name'],
                'email'    => $td['email'],
                'password' => Hash::make('password'),
                'role'     => 'tenant',
            ]);
            $apt = $apartments[$i];
            $apt->update(['status' => 'occupied']);
            $tenants[] = Tenant::create([
                'user_id'      => $user->id,
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
            $visitors[] = Visitor::create($vd);
        }

        // Visits
        $purposes = ['Family visit', 'Delivery', 'Business meeting', 'Maintenance', 'Social visit'];
        foreach ($visitors as $i => $visitor) {
            $tenant = $tenants[$i % count($tenants)];
            // Completed past visit
            Visit::create([
                'visitor_id'         => $visitor->id,
                'tenant_id'          => $tenant->id,
                'purpose'            => $purposes[$i % count($purposes)],
                'check_in_time'      => now()->subDays(rand(1, 14))->setHour(rand(8, 16)),
                'check_out_time'     => now()->subDays(rand(0, 1))->setHour(rand(17, 20)),
                'status'             => 'completed',
                'approved_by_tenant' => true,
            ]);
        }

        // One active visit
        Visit::create([
            'visitor_id'         => $visitors[0]->id,
            'tenant_id'          => $tenants[0]->id,
            'purpose'            => 'Delivery package',
            'check_in_time'      => now()->subHours(1),
            'status'             => 'active',
            'approved_by_tenant' => true,
        ]);
    }
}
