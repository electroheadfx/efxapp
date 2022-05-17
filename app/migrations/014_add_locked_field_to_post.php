<?php

namespace Fuel\Migrations;

class Add_locked_field_to_post
{
	public function up()
	{
		\DBUtil::add_fields('posts', array(
		    'locked' => array('constraint' => '"no","yes"', 'type' => 'enum'),
		));

	}

	public function down()
	{
		\DBUtil::drop_fields('posts', 'locked');
	}
}