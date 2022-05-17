<?php

namespace Fuel\Migrations;

class Project_Create_menus
{
	public function up()
	{
		\DBUtil::create_table('project_menus', array(
			'id'          		=> array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name'        		=> array('constraint' => 255, 'type' => 'varchar'),
			'summary' 	  		=> array('type' 	  => 'text'),
			'order_id' 	 		=> array('constraint' => 11, 'type' => 'int', 'null' => true),
			'status' 	  		=> array('constraint' => '"draft","published"', 'type' => 'enum'),
			'permission'  		=> array('constraint' => '"public","private"', 'type' => 'enum'),
			'featured' 	  		=> array('constraint' => '"no","yes"', 'type' => 'enum'),
			'edit' 				=> array('constraint' => 1, 'type' => 'tinyint'),
			'created_at'  		=> array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at'  		=> array('constraint' => 11, 'type' => 'int', 'null' => true),
		), array('id'));

	}

	public function down()
	{
		\DBUtil::drop_table('project_menus');
	}
}