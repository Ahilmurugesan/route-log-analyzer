<?php

use Illuminate\Database\Seeder;

class RouteDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([RouteUsageTableSeeder::class]);
    }
}
