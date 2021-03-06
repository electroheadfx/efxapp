<?php

namespace User;

class Model_User extends \Orm\Model {

    protected static $_table_name = 'users';

    protected static $_properties = array(
        'id',
        'username' => array(
            'label' => 'Username',
            'null' => false,
            'validation' => array('required', 'min_length' => array(3)),
        ),
        'password' => array(
            'label' => 'Password',
            'form' => array('type' => 'password'),
            'validation'  => array('required', 'min_length' => array(8), 'match_field' => array('confirm')),
            'null' => false,
        ),
        'group_id' => array(
            'label' => 'auth_model_user.group',
            'default' => 0,
            'null' => false,
            'form' => array('type' => 'select'),
            'validation' => array('required', 'is_numeric')
        ),
        'email' => array(
            'label' => 'auth_model_user.email',
            'default' => 0,
            'null' => false,
            'validation' => array('required', 'valid_email')
        ),
        'last_login' => array(
            'form' => array('type' => false),
        ),
        'previous_login' => array(
            'form' => array('type' => false),
        ),
        'login_hash' => array(
            'form' => array('type' => false),
        ),
        'user_id' => array(
            'form' => array('type' => false),
        ),
        'created_at' => array(
            'form' => array('type' => false),
            'default' => 0,
            'null' => false,
        ),
        'updated_at' => array(
            'form' => array('type' => false),
            'default' => 0,
            'null' => false,
        ),
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
    
    // EAV container for user metadata
    protected static $_eav = array(
        'metadata' => array(
            'attribute' => 'key',
            'value' => 'value',
        ),
    );

    
    /**
     * User HasMany Posts
     * @var array
     */
    protected static $_has_many = array(
        'posts' => array(
            'key_from' => 'id',
            'model_to' => 'Blog\Model_Post',
            'key_to' => 'user_id',
            'cascade_save' => false,
            'cascade_delete' => true,  // We delete all posts from the user deleted
        ),
        'metadata' => array(
            'model_to' => 'User\Model_Metadata',
            'key_from' => 'id',
            'key_to'   => 'parent_id',
            'cascade_delete' => true,
        )
    );

}