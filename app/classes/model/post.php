<?php

class Model_Post extends \Orm\Model {

    protected static $_table_name = 'posts';

    protected static $_properties = array(
        'id',
        'module' => array(
            'label' => 'model.post.module',
            'null' => false,
            'validation' => array('required', 'min_length' => array(3)),
        ),
        'name' => array(
            'label' => 'model.post.name',
            'null' => false,
            'form' => array('type' => 'textarea'),
            // 'validation' => array('required', 'min_length' => array(3)),
        ),
        'slug' => array(
            'label' => 'model.post.slug',
            'null' => false,
        ),
        'summary' => array(
            'label' => 'model.post.summary',
            'null' => false,
            'form' => array('type' => 'textarea'),
        ),
        'content' => array(
            'label' => 'model.post.content',
            'null' => false,
            'form' => array('type' => 'textarea'),
        ),
        'category_id' => array(
            'label' => 'model.post.category_id',
            'form' => array('type' => 'select', 'default' => 0),
            'null' => false,
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
        'locked'   => array(
            'data_type'     => 'enum',
            'label'         => 'model.post.locked',
            'form'          => array('type' => 'select', 'options' => array('no'=>'model.post.attribute.locked.no','yes'=>'model.post.attribute.locked.yes')),
            'validation'    => array('required'),
            'default'       => 'no',
        ),
        'allow_comments'   => array(
            'data_type'     => 'enum',
            'label'         => 'model.post.allow_comments',
            'form'          => array('type' => 'select', 'options' => array('no'=>'model.post.attribute.allow_comments.no','yes'=>'model.post.attribute.allow_comments.yes')),
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
            'model_to'  => 'Model_Postmeta',
            'attribute' => 'key',
            'value'     => 'value',
        )
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

    protected static $_many_many = array(
        'categories' => array(
            'key_from'          => 'id',
            'key_through_from'  => 'post_id',         
            'table_through'     => 'categories_posts',
            'key_through_to'    => 'category_id',
            'model_to'          => 'Model_Category',
            'key_to'            => 'id',
            'cascade_save'      => false,
            'cascade_delete'    => false,
        ),
        'posts' => array(
            'key_from'          => 'id',
            'key_through_from'  => 'post_id',
            'table_through'     => 'categories_posts',
            'key_through_to'    => 'category_id',
            'model_to'          => 'Model_Category',
            'key_to'            => 'id',
            'cascade_save'      => false,
            'cascade_delete'    => false,
        )
    );
    
    /**
     * Post HasMany Comments
     * @var array
     */
    protected static $_has_many = array(
        'comments' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Comment',
            'key_to' => 'post_id',
            'cascade_save' => false,
            'cascade_delete' => true,  // We delete all comments from the post deleted
        ),

        'statistics' => array(
            'key_from'       => 'id',           
            'model_to'       => 'Model_Postmeta',
            'key_to'         => 'post_id',
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
                $content = 'content_'.$lang;
                $short = 'short_'.$lang;

                if (isset($this->$name))
                    !empty($this->$name) and $this->name = $this->$name;
                
                if (isset($this->$summary))
                    !empty($this->$summary) and $this->summary = $this->$summary;
                
                if (isset($this->$content))
                    !empty($this->$content) and $this->content = $this->$content;

                if (isset($this->$short))
                    !empty($this->$short) and $this->short = $this->$short;
            }
        }
    }

    public static function set_form_fields($form, $instance = null) {

        // Call parent for create the fieldset and set default value
        parent::set_form_fields($form, $instance);

        // Set authors
        foreach(\User\Model_User::find('all') as $user)
            $form->field('user_id')->set_options($user->id, $user->username);

    }    


}


