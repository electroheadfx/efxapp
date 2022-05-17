<?php

namespace User;

class Model_Metadata extends \Orm\Model {
	
	protected static $_table_name = 'users_metadata';

	protected static $_properties = array(
		'id',
		'parent_id',
		'key',
		'value',
		'user_id',
		'created_at',
		'updated_at',
	);

	/**
	 * @var array	belongs_to relationships
	 */
	protected static $_belongs_to = array(
		'user' => array(
			'model_to' => 'User\Model_User',
			'key_from' => 'parent_id',
			'key_to'   => 'id',
		),
	);

	/**
	 * @var array	defined observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'property' => 'created_at',
			'mysql_timestamp' => false,
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'property' => 'updated_at',
			'mysql_timestamp' => false,
		),
		'Orm\\Observer_Typing' => array(
			'events' => array('after_load', 'before_save', 'after_save'),
		),
		'Orm\\Observer_Self' => array(
			'events' => array('before_insert', 'before_update'),
			'property' => 'user_id',
		),
	);

}
