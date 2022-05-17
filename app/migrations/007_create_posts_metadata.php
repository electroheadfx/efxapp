<?php

namespace Fuel\Migrations;

class Create_posts_metadata
{
	public function up()
	{
		\DBUtil::create_table('posts_metadata', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'post_id' => array('constraint' => 11, 'type' => 'int'),
			'key' => array('constraint' => 255, 'type' => 'varchar'),
			'value' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('posts_metadata');
	}
}