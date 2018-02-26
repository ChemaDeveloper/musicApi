<?php 

class Model_Users extends Orm\Model
{
    protected static $_table_name = 'users';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
	    'name' => array(
	    	'data_type' => 'varchar'
	    ),
        'pass' => array(
        	'data_type' => 'varchar'
        ),
        'email' => array(
        	'data_type' => 'varchar',
        ),
        'id_device' => array(
        	'data_type' => 'varchar'
        ),
        'profile_pic' => array(
        	'data_type' => 'varchar'
        ),
        'description' => array(
        	'data_type' => 'varchar'
        ),
        'birthdate' => array(
        	'data_type' => 'varchar'
        ),
        'x' => array(
        	'data_type' => 'varchar'
        ),
        'y' => array(
        	'data_type' => 'varchar'
        ),
        'city' => array(
        	'data_type' => 'varchar'
        ),
        'id_role' => array(
        	'data_type' => 'int'
        ),
    );

    protected static $_belongs_to = array(
        'role' => array(
            'key_from' => 'id_role',
            'model_to' => 'Model_Roles',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );
    protected static $_has_many = array(
        'list' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Lists',
            'key_to' => 'id_user',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );
    protected static $_many_many = array(
        'song' => array(
            'key_from' => 'id',
            'key_through_from' => 'id_user', // column 1 from the table in between,
            'table_through' => 'users_songs', // both models plural without prefix in alphabetical order
            'key_through_to' => 'id_song', // column 2 from the table in between,
            'model_to' => 'Model_Songs',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );
}