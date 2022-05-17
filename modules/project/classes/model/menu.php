<?php

namespace Project;

class Model_Menu extends \Orm\Model {

    protected static $_table_name = 'project_menus';

    protected static $_properties = array(
        'id',
        'name' => array(
            'label' => 'module.menu.model.name',
            'null' => false,
            'validation' => array('required'),
        ),
        'summary' => array(
            'label' => 'module.menu.model.summary',
            'null' => false,
            'form' => array('type' => 'textarea'),
        ),
        'order_id' => array(
            'form' => array('type' => false),
            'default' => NULL,
            'null' => false,
            // 'validation' => array('is_numeric'),
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
        'Orm\\Observer_Self',
    );

    protected static $_eav = array(
            'statistics' => array(
                'model_to'  => 'Model_Menumeta',
                'attribute' => 'key',
                'value'     => 'value',
            )
        );
    /**
     * Post HasMany Comments
     * @var array
     */
    protected static $_has_many = array(
        'statistics' => array(
            'key_from'       => 'id',           
            'model_to'       => '\\Project\\Model_Menumeta',
            'key_to'         => 'menu_id',
            'cascade_save'   => true,
            'cascade_delete' => true,
        )
    );

    public function _event_after_load() {

        if ( \Cookie::get('lang') ) {
            $local = \Config::get('server.application.language');
            $lang = \Cookie::get('lang');
            if ( $lang !== $local ) {
                $name = 'name_'.$lang;
                $summary = 'summary_'.$lang;

                if (isset($this->$name))
                    !empty($this->$name) and $this->name = $this->$name;

                if (isset($this->$summary))
                    !empty($this->$summary) and $this->summary = $this->$summary;
            }
        }
    }
    

    public static function set_form_fields($form, $instance = null) {

        // Call parent for create the fieldset and set default value
        parent::set_form_fields($form, $instance);

    }    

}


