<?php 

class Model_Songs extends Orm\Model
{
    protected static $_table_name = 'songs';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
        'title' => array(
            'data_type' => 'text'   
        ),
        'artist' => array(
            'data_type' => 'text'   
        ),
        'url' => array(
            'data_type' => 'text'   
        ),
        'reproduced' => array(
            'data_type' => 'int'   
        ),
        'liked' => array(
            'data_type' => 'int'   
        ),
    );
    protected static $_many_many = array(
        'list' => array(
            'key_from' => 'id',
            'key_through_from' => 'id_list', // column 1 from the table in between,
            'table_through' => 'lists_songs', // both models plural without prefix in alphabetical order
            'key_through_to' => 'id_song', // column 2 from the table in between,
            'model_to' => 'Model_Lists',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'user' => array(
            'key_from' => 'id',
            'key_through_from' => 'id_user', // column 1 from the table in between,
            'table_through' => 'users_songs', // both models plural without prefix in alphabetical order
            'key_through_to' => 'id_song', // column 2 from the table in between,
            'model_to' => 'Model_Users',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );
}