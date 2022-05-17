<?php


class Model_Postmeta extends \Orm\Model {

	protected static $_table_name = 'posts_metadata';

	protected static $_properties = array(
		'id',
		'post_id',
		'key',
		'value',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);

    protected static $_belongs_to = array(
        'patient' => array(
            'key_from' => 'post_id',
            'model_to' => 'Model_Post',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );


}
