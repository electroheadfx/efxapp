<?php

namespace Project;


class Model_Menumeta extends \Orm\Model {

    protected static $_table_name = 'project_menus_metadata';

    protected static $_properties = array(
        'id',
        'menu_id',
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
        'menu' => array(
            'key_from' => 'menu_id',
            'model_to' => '\\Project\\Model_Menu',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );


}
