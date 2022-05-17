<?php

namespace Fuel\Migrations;

class Create_auth_group_permission {

	public function up() {

		$permission_group=\Model\Auth_Grouppermission::forge(array('group_id'=>6,'perms_id'=>1,'actions'=>array('view','add','edit','delete','modify')));
        $permission_group->save();
		
	}

	public function down() {

		\DBUtil::drop_table('users_group_permissions');

	}

}