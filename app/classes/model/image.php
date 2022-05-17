<?php

class Model_Image extends \Orm\Model {

	protected static $_table_name = 'images';

	protected static $_properties = array(
		'id',
		'post_id',
		'title',
		'name',
		'path',
		'type',
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

	protected static $_has_many = array(
	    'statistics' => array(
	        'key_from' 		 => 'id',			
	        'model_to' 		 => 'Model_Imagemeta',
	        'key_to' 		 => 'image_id',
	        'cascade_save' 	 => true,
	        'cascade_delete' => true,
	    )
	);

	protected static $_eav = array(
	    'statistics' => array(
	        'model_to' 	=> 'Model_Imagemeta',
	        'attribute' => 'key',
	        'value' 	=> 'value',
	    )
	);


}
