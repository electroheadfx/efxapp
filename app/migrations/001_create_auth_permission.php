<?php

namespace Fuel\Migrations;

class Create_auth_permission {

	public function up() {

		$actions = array('view', 'add', 'edit', 'delete', 'modify');

		$permission=\Model\Auth_Permission::forge(
		    array(  'area' => 'backend',
		            'permission' => 'global',
		            'description' => 'backend-global-permission',
		            'actions' => $actions,
		    )
		);
		$permission->save();
		
	}

	public function down() {

		\DBUtil::drop_table('users_permissions');

	}

}