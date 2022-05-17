<?php

namespace Media;

class Model_Cv extends \Orm\Model {

    protected static $_table_name = 'media_cv';

    protected static $_properties = array(
        'id',
        'name' => array(
            'label' => 'model.post.name',
            'null' => false,
            'validation' => array('required', 'min_length' => array(3)),
        ),
        'summary' => array(
            'label' => 'model.post.summary',
            'null' => false,
            'form' => array('type' => 'textarea'),
        ),
        'order_id' => array(
            'form' => array('type' => false),
            'default' => NULL,
            'null' => false,
            // 'validation' => array('is_numeric'),
        ),
        'user_id' => array(
            'label' => 'model.post.user_id',
            'form' => array('type' => 'select'),
            'null' => false,
            'validation' => array('is_numeric'),
        ),
        'status'   => array(
            'data_type'     => 'enum',
            'label'         => 'model.post.status',
            'form'          => array('type' => 'select', 'options' => array('draft'=>'model.post.attribute.status.draft','published'=>'model.post.attribute.status.published')),
            'validation'    => array('required'),
            'default'       => 'draft',
        ),
        'permission'   => array(
            'data_type'     => 'enum',
            'label'         => 'model.post.permission',
            'form'          => array('type' => 'select', 'options' => array('public'=>'model.post.attribute.permission.public','private'=>'model.post.attribute.permission.private')),
            'validation'    => array('required'),
            'default'       => 'public',
        ),
        'featured'   => array(
            'data_type'     => 'enum',
            'label'         => 'model.post.featured',
            'form'          => array('type' => 'select', 'options' => array('no'=>'model.post.attribute.featured.no','yes'=>'model.post.attribute.featured.yes')),
            'validation'    => array('required'),
            'default'       => 'no',
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
        'edit' => array(
            'label' => 'model.post.edit',
            'form' => array('type' => false),
            'null' => false,
        ),
        'column' => array(
            'label' => 'model.column.label',
            'form' => array('type' => 'select'),
            'validation' => array('required'),
        ),
    );

    protected static $_conditions = array(
        'order_by' => array('created_at' => 'desc'),
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
    
    
    /**
     * Post BelongsTo Category
     * Post BelongsTo User
     * 
     * @var array
     */
    protected static $_belongs_to = array(
        'users' => array(
            'key_from' => 'user_id',
            'model_to' => 'User\Model_User',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
    );
    

    public static function set_form_fields($form, $instance = null) {

        // Call parent for create the fieldset and set default value
        parent::set_form_fields($form, $instance);

        // Set authors
        foreach(\User\Model_User::find('all') as $user)
            $form->field('user_id')->set_options($user->id, $user->username);

        // get column data
        $ops = array();
        foreach (\Config::get('app-thumb.column') as $key => $value) {
            $ops[$key] = __('model.column.'.$value);
        }
        $form->field('column')->set_options($ops);

    }

}


