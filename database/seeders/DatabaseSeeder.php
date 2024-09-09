<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RoleSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(TimeZoneSeeder::class);
        // $this->call(CitySeeder::class);
        // $this->call(TownshipSeeder::class);
        // $this->call(UserSeeder::class);
        $this->call(HomePageEnSeeder::class);
        $this->call(HomePageMmSeeder::class);
        $this->call(AboutPageEnSeeder::class);
        $this->call(AboutPageMmSeeder::class);
        $this->call(ServicePageEnSeedeer::class);
        $this->call(ServicePageMmSeedeer::class);
        $this->call(ProfilePageEnSeedeer::class);
        $this->call(ProfilePageMmSeedeer::class);
        $this->call(ContactPageEnSeeder::class);
        $this->call(ContactPageMmSeeder::class);
        $this->call(RegionalSeeder::class);


    }
}
