<?php

namespace Fuel\Migrations;

class Modify_exposition_constraint_to_category
{
	public function up()
	{
		\DBUtil::modify_fields('categories', array(
		    'exposition' => array('constraint' => '"all","video","gallery","blog","sketchfab"', 'type' => 'enum'),
		));

	}

	public function down()
	{
		\DBUtil::modify_fields('categories', array(
		    'exposition' => array('constraint' => '"all","video","gallery","blog"', 'type' => 'enum'),
		));
	}
}