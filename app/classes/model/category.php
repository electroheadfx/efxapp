<?php

class Model_Category extends \Orm\Model {

    protected static $_table_name = 'categories';
    
    protected static $_properties = array(
        'id',
        'name' => array(
            'label' => 'model.category.name',
            'null' => false,
            // 'validation' => array('required', 'min_length' => array(3)),
        ),
        'slug' => array(
            'label'     => 'model.category.slug',
            'default'   => '',
            'null'      => false,
        ),
        'post_count' => array(
            'form' => array('type' => false),
            'default' => 0,
            'null' => false,
            // 'validation' => array('is_numeric'),
        ),
        'order_id' => array(
            'form' => array('type' => false),
            'default' => NULL,
            'null' => false,
            // 'validation' => array('is_numeric'),
        ),
        'status'   => array(
            'data_type'     => 'enum',
            'label'         => 'model.category.status',
            'form'          => array('type' => 'select', 'options' => array('draft'=>'model.category.attribute.status.draft','published'=>'model.category.attribute.status.published')),
            'validation'    => array('required'),
            'default'       => 'published',
        ),
        'visibility'   => array(
            'data_type'     => 'enum',
            'label'         => 'model.category.visibility',
            'form'          => array('type' => 'select', 'options' => array('visible'=>'model.category.attribute.visibility.visible','hidden'=>'model.category.attribute.visibility.hidden')),
            // 'validation'    => array('required'),
            'default'       => 'visible',
        ),
        'permission'   => array(
            'data_type'     => 'enum',
            'label'         => 'model.category.permission',
            'form'          => array('type' => 'select', 'options' => array('public'=>'model.category.attribute.permission.public','private'=>'model.category.attribute.permission.private')),
            'validation'    => array('required'),
            'default'       => 'public',
        ),
        'exposition'   => array(
            'label'         => 'model.category.exposition',
            // 'form'          => array('type' => 'select', 'options' => array('all'=>'model.category.attribute.exposition.all','video'=>'model.category.attribute.exposition.video','gallery'=>'model.category.attribute.exposition.gallery','blog'=>'model.category.attribute.exposition.blog')),
            'form'          => array('type' => 'select', 'options' => array()),
            'validation'    => array('required'),
            'default'       => null,
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

    protected static $_conditions = array(
        'order_by' => array('name' => 'asc'),
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
        'Orm\\Observer_Self',
    );

    
    /**
     * Category HasMany Posts
     * 
     * @var array
     */
    protected static $_has_many = array(
        'post' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Post',
            'key_to' => 'category_id',
            'cascade_save' => false,
            'cascade_delete' => false,  // We delete all post from the category deleted
        ),

        'statistics' => array(
            'key_from'       => 'id',           
            'model_to'       => 'Model_Categorymeta',
            'key_to'         => 'category_id',
            'cascade_save'   => true,
            'cascade_delete' => true,
        ),
    );

    protected static $_many_many = array(
        'categories' => array(
            'key_from'          => 'id',
            'key_through_from'  => 'category_id',
            'table_through'     => 'categories_posts',
            'key_through_to'    => 'post_id',
            'model_to'          => 'Model_Post',
            'key_to'            => 'id',
            'cascade_save'      => false,
            'cascade_delete'    => false,
        ),
        'posts' => array(
            'key_from'          => 'id',
            'key_through_from'  => 'category_id',
            'table_through'     => 'categories_posts',
            'key_through_to'    => 'post_id',
            'model_to'          => 'Model_Post',
            'key_to'            => 'id',
            'cascade_save'      => false,
            'cascade_delete'    => false,
        )
    );

    protected static $_eav = array(
        'statistics' => array(
            'model_to'  => 'Model_Categorymeta',
            'attribute' => 'key',
            'value'     => 'value',
        )
    );

    public function _event_after_load() {

        if ( \Cookie::get('lang') ) {
            $local = \Config::get('server.application.language');
            $lang = \Cookie::get('lang');
            if ( $lang !== $local ) {
                $name = 'name_'.$lang;
                if (isset($this->$name))
                    !empty($this->$name) and $this->name = $this->$name;
            }
        }
    }

    public static function set_form_fields($form, $instance = null) {

        // Call parent for create the fieldset and set default value
        parent::set_form_fields($form, $instance);
       
        $exposition[''] = '---- Choisir le module ----';
        foreach( \Config::get('server.modules') as $key => $mod) {
            if ($key != 'cv') {
                $exposition[$key] = __('model.post.attribute.exposition.'.$key);
            }
        }

        $form->field('exposition')->set_options($exposition);

    } 

    
}