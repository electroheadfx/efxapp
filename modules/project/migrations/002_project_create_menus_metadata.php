<?php

namespace Fuel\Migrations;

class Project_Create_menus_metadata
{
	public function up()
	{
		\DBUtil::create_table('project_menus_metadata', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'menu_id' => array('constraint' => 11, 'type' => 'int'),
			'key' => array('constraint' => 255, 'type' => 'varchar'),
			'value' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('project_menus_metadata');
	}
}