<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Department;
use App\User;
use App\Team;


class TestData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Department::create([
            'name' => 'Département Informatique',
            'short_name' => 'DI'
            ]);

        User::create([
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'password'  => bcrypt('azeaze'),
            'level' => Config::get('levels.team_manager'),
            'email' => 'jean@dupont',
            'department_id' => 2,
            'school_year' => 3,
            'validated' => 1,
            ]);

        Team::create([
            'name' => 'Team Test',
            'article' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ',
            'validated' => 1,
            'user_id' => 2,
            ]); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
