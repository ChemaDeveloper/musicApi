<?php 

class Model_Lists extends Orm\Model
{
    protected static $_table_name = 'lists';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
        'title' => array(
            'data_type' => 'varchar'   
        ),
        'editable' => array(
        	'data_type' => 'int'
        ),
        'id_user' => array(
            'data_type' => 'int'   
        )
    );
    protected static $_belongs_to = array(
	    'user' => array(
	        'key_from' => 'id_user',
	        'model_to' => 'Model_Users',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	    )
	);
    protected static $_many_many = array(
        'song' => array(
            'key_from' => 'id',
            'key_through_from' => 'id_list', // column 1 from the table in between,
            'table_through' => 'lists_songs', // both models plural without prefix in alphabetical order
            'key_through_to' => 'id_song', // column 2 from the table in between,
            'model_to' => 'Model_Songs',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );
}