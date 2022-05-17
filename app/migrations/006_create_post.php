<?php

namespace Fuel\Migrations;

class Create_post
{
	public function up()
	{
		\DBUtil::create_table('posts', array(
			'id'          		=> array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'module'        	=> array('constraint' => 255, 'type' => 'varchar'),
			'name'        		=> array('constraint' => 255, 'type' => 'varchar'),
			'slug'        		=> array('constraint' => 255, 'type' => 'varchar'),
			'summary' 	  		=> array('type' 	  => 'text'),
			'content'     		=> array('type' 	  => 'text'),
			'category_id' 		=> array('constraint' => 11, 'type' => 'int'),
			'order_id' 	 		=> array('constraint' => 11, 'type' => 'int', 'null' => true),
			'user_id'     		=> array('constraint' => 11, 'type' => 'int'),
			'status' 	  		=> array('constraint' => '"draft","published"', 'type' => 'enum'),
			'permission'  		=> array('constraint' => '"public","private"', 'type' => 'enum'),
			'featured' 	  		=> array('constraint' => '"no","yes"', 'type' => 'enum'),
			'allow_comments' 	=> array('constraint' => '"no","yes"', 'type' => 'enum'),
			'edit' => array('constraint' => 1, 'type' => 'tinyint'),
			'created_at'  		=> array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at'  		=> array('constraint' => 11, 'type' => 'int', 'null' => true),
		), array('id'));

	}

	public function down()
	{
		\DBUtil::drop_table('posts');
	}
}