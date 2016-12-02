<?php

use Illuminate\Database\Seeder;
use Illuminate\database\Eloquent\Model;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $str = '';
        $n = random_int(40, 100);
        for($i=0; $i<$n; $i++)
        {
            $str .= str_random(random_int(2, 10)).' ';
        }

    	$team = random_int(1, 10);
        DB::table('news')->insert([
        	'title' => str_random(random_int(2, 10)).' '.str_random(random_int(2, 10)).' '.str_random(random_int(2, 10)).' !',
        	'user_id' => random_int(1, 3),
        	'content' => $str,
        	'team_id' => $team > 3 ? NULL : $team,
        	'validated' => 1,
        	]);
    }
}
