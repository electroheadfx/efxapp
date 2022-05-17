<?php

namespace Fuel\Migrations;

class Create_Category
{
	public function up()
	{
		\DBUtil::create_table('categories', array(
			'id'         => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'status' 	 => array('constraint' => '"draft","published"', 'type' => 'enum'),
			'name'       => array('constraint' => 255, 'type' => 'varchar'),
			'slug'       => array('constraint' => 255, 'type' => 'varchar'),
			'exposition' => array('constraint' => '"all","video","gallery","blog"', 'type' => 'enum'),
			'post_count' => array('constraint' => 11, 'type' => 'int'),
			'order_id' 	 => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'permission' => array('constraint' => '"public","private"', 'type' => 'enum'),
			'status' 	 => array('constraint' => '"draft","published"', 'type' => 'enum'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
		), array('id'));

	}

	public function down()
	{
		\DBUtil::drop_table('categories');
	}
}