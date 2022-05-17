<?php

namespace Fuel\Migrations;

class Add_visibility_field_to_category
{
	public function up()
	{
		\DBUtil::add_fields('categories', array(
		    'visibility' => array('constraint' => '"visible","hidden"', 'type' => 'enum'),
		));

	}

	public function down()
	{
		\DBUtil::drop_fields('categories', 'visibility');
	}
}