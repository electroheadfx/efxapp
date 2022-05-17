<?php

namespace Fuel\Migrations;

class Create_images
{
	public function up()
	{
		\DBUtil::create_table('images', array(
			'id' 			=> array('constraint' 	=> 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'post_id' 		=> array('constraint' => 11, 'type' => 'int'),
			'title' 		=> array('constraint' => 255, 'type' => 'varchar'),
			'name' 			=> array('constraint' => 255, 'type' => 'varchar'),
			'path' 			=> array('constraint' => 255, 'type' => 'varchar'),
			'type' 			=> array('constraint' => 3, 'type' => 'varchar'),
			'created_at' 	=> array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' 	=> array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('images');
	}
}