<?php

namespace Fuel\Migrations;

class Modify_exposition_constraint_to_category_cms
{
	public function up()
	{
		\DBUtil::modify_fields('categories', array(
		    'exposition' => array('constraint' => '"all","video","gallery","blog","sketchfab","cms"', 'type' => 'enum'),
		));

	}

	public function down()
	{
		\DBUtil::modify_fields('categories', array(
		    'exposition' => array('constraint' => '"all","video","gallery","blog"', 'type' => 'enum'),
		));
	}
}