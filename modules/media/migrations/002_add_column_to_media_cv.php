<?php

namespace Fuel\Migrations;

class Add_column_to_media_cv
{
	public function up()
	{
		\DBUtil::add_fields('media_cv', array(
			'column' => array('type' => 'text'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('media_cv', array(
			'column'

		));
	}
}