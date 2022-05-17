<?php


class Model_Categorymeta extends \Orm\Model {

	protected static $_table_name = 'categories_metadata';

	protected static $_properties = array(
		'id',
		'category_id',
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
        'cat' => array(
            'key_from' => 'category_id',
            'model_to' => 'Model_Category',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );


}
