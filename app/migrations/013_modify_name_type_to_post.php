<?php

namespace Fuel\Migrations;

class Modify_name_type_to_post
{
	public function up()
	{
		\DBUtil::modify_fields('posts', array(
		    'name' => array('type' => 'text'),
		));

	}

	public function down()
	{
		\DBUtil::modify_fields('posts', array(
		    'name' => array('type' => 'varchar'),
		));
	}
}