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
}