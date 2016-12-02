<?php

use Illuminate\Database\Seeder;

class ContentsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$banner_content = DB::table('contents')->where('name','banner_content')->get();
		if(empty($banner_content))
		{
			DB::table('contents')->insert([
				'name' => 'banner_content',
				'user_id' => 1,
				'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
				'title' => 'Bienvenue sur le site du BDA de Polytech Tours !'
					]);
		}

		$home_content = DB::table('contents')->where('name','home_content')->get();
		if(empty($home_content))
		{
			DB::table('contents')->insert([
				'name' => 'home_content',
				'user_id' => 1,
				'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<h2>Lorem Ipsum :</h2><ul> <li>dolor sit amet</li> <li>consectetur adipisicing elit</li> <li>exercitation ullamco</li> <li>in voluptate velit esse</li></ul><h1>Titre h1</h1> <h2>Titre h2</h2> <h3>Titre h3</h3> <h4>Titre h4</h4> <h5>Titre h5</h5> <h6>Titre h6</h6><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.  </p>',
				'title' => 'Titre de la page !',
					]);
		}

		$teams_index_content = DB::table('contents')->where('name','teams_index_content')->get();
		if(empty($teams_index_content))
		{
			DB::table('contents')->insert([
				'name' => 'teams_index_content',
				'user_id' => 1,
				'content' => '<p>TEAMS INDEX CONTENT</p>',
				'title' => 'TITRE TEAMS INDEX CONTENT',
					]);
		}

		$staff_content = DB::table('contents')->where('name','staff_content')->get();
		if(empty($staff_content))
		{
			DB::table('contents')->insert([
				'name' => 'staff_content',
				'user_id' => 1,
				'content' => '<p>STAFF SECTION CONTENT</p>',
				'title' => 'STAFF SECTION TITLE',
					]);
		}
	}
}
