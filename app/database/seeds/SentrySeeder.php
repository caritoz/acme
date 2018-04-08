<?php

use App\Models\User;

class SentrySeeder extends Seeder {

	public function run()
	{
		DB::table('users')->truncate(); // Using truncate function so all info will be cleared when re-seeding.
		DB::table('groups')->truncate();
		DB::table('users_groups')->truncate();

        Sentry::createGroup(array(
            'name'        => 'Administrator',
            'permissions' => array(
                "user.create" => 1,
                "user.delete" => 1,
                "user.view"   => 1,
                "user.update" => 1
            )
        ));

        Sentry::createGroup(array(
            'name'        => 'Moderator',
            'permissions' => array(
                "user.create" => 0,
                "user.delete" => 0,
                "user.view"   => 1,
                "user.update" => 1
            ),
        ));

        // Create the user
        $user = Sentry::createUser(array(
            'email'     => 'Batman',
            'password'  => '',
            'activated' => true,
        ));

        // Find the group using the group id
        $adminGroup = Sentry::findGroupById(1);

        // Assign the group to the user
        $user->addGroup($adminGroup);
	}

}
