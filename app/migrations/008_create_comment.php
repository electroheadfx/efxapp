<?php

namespace Fuel\Migrations;

class Create_comment
{
	public function up()
	{
		\DBUtil::create_table('comments', array(
			'id'         => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'username'   => array('constraint' => 255, 'type' => 'varchar'),
			'mail'       => array('constraint' => 255, 'type' => 'varchar'),
			'content'    => array('type' => 'text'),
			'post_id'    => array('constraint' => 11, 'type' => 'int'),
			'published'  => array('constraint' => '"off","on"', 'type' => 'enum'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('comments');
	}
}