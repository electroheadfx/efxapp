<?php

namespace Fuel\Migrations;

class Project_Modify_menus_metadata
{
	public function up()
	{
		\DBUtil::modify_fields('project_menus_metadata', array(
		    'value' => array('type' => 'text'),
		));

	}

	public function down()
	{
		\DBUtil::modify_fields('project_menus_metadata', array(
		    'value' => array('constraint' => 255, 'type' => 'varchar'),
		));
	}
}