<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i=0; $i < 10; $i++) { 
            $this->call('EventsTableSeeder');
            $this->call('NewsTableSeeder');
        }
        $this->call('ContentsTableSeeder');

        Model::reguard();
    }
}
