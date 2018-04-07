<?php

class AlbumsTableSeeder extends \Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		\DB::table('albums')->truncate();

        $now = date('Y-m-d H:i:s');

        $albums = array(
            array('caption' => 'Slider', 'folder' => 'slider', 'created_at' => $now, 'updated_at' => $now),
            array('caption' => 'Works', 'folder' => 'works', 'created_at' => $now, 'updated_at' => $now),
            array('caption' => 'Clients', 'folder' => 'clients', 'created_at' => $now, 'updated_at' => $now)
		);

		// Uncomment the below to run the seeder
		\DB::table('albums')->insert($albums);
	}
}
