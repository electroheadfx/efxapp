<?php

class Model_Comment extends \Orm\Model {

    protected static $_table_name = 'comments';
    
    protected static $_properties = array(
        'id',
        'username' => array(
            'label' => 'model.comment.username',
            'null' => false,
            'validation' => array('required', 'min_length' => array(3)),
        ),
        'mail' => array(
            'label' => 'model.comment.mail',
            'null' => false,
            'validation' => array('required','valid_email'),
        ),
        'content' => array(
            'label' => 'model.comment.content',
            'null' => false,
            'form' => array('type' => 'textarea'),
            'validation' => array('required'),
        ),
        'published'   => array(
            'data_type'     => 'enum',
            'label'         => 'model.post.published',
            'form'          => array('type' => 'select', 'options' => array('off'=>'model.commnent.attribute.published.off','on'=>'model.commnent.attribute.published.on')),
            'default'       => 'off',
        ),
        'post_id' => array(
            'form' => array('type' => false),
            'null' => false,
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
     * Comment BelongsTo Post
     * @var array
     */
    protected static $_belongs_to = array(
        'post' => array(
            'key_from' => 'post_id',
            'model_to' => 'Model_Post',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
    );
    
}