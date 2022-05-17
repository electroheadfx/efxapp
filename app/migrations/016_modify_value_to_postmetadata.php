<?php

namespace Fuel\Migrations;

class Modify_value_to_postmetadata
{
	public function up()
	{
		\DBUtil::modify_fields('posts_metadata', array(
		    'value' => array('type' => 'text'),
		));

	}

	public function down()
	{
		\DBUtil::modify_fields('posts_metadata', array(
		    'value' => array('constraint' => 255, 'type' => 'varchar'),
		));
	}
}