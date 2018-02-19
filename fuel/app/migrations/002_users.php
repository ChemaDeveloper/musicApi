<?php
namespace Fuel\Migrations;

class Users
{
		
    function up()
    {	
    	try
    	{
	        \DBUtil::create_table(
	    		'users',
	    		array(
	    		    'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
	    		    'name' => array('constraint' => 11, 'type' => 'varchar', 'null' => false),
                    'pass' => array('constraint' => 300, 'type' => 'varchar', 'null' => false),
                    'email' => array('constraint' => 40, 'type' => 'varchar', 'null' => false),
                    'id_device' => array('constraint' => 24, 'type' => 'varchar', 'null' => false),
                    'profile_pic' => array('constraint' => 300, 'type' => 'varchar', 'null' => false),
                    'description' => array('constraint' => 11, 'type' => 'varchar', 'null' => true),
                    'birthdate' => array('constraint' => 11, 'type' => 'varchar', 'null' => true),
                    'x' => array('constraint' => 11, 'type' => 'varchar', 'null' => true),
                    'y' => array('constraint' => 11, 'type' => 'varchar', 'null' => true),
                    'city' => array('constraint' => 11, 'type' => 'varchar', 'null' => true),
                    'id_role' => array('constraint' => 11, 'type' => 'int', 'null' => false),
	    		),
	    		array('id'), false, 'InnoDB', 'utf8_general_ci',
	    		array(
                    array(
                        'constraint' => 'foreingKeyUsersToRoles',
                        'key' => 'id_role',
                        'reference' => array(
                            'table' => 'roles',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
                        'on_delete' => 'RESTRICT'
                    )
                )
			);
            \DB::query("ALTER TABLE `users` ADD UNIQUE (`name`)")->execute();
            \DB::query("ALTER TABLE `users` ADD UNIQUE (`email`)")->execute();


    	}
    	catch(\Database_Exception $e)
		{
		   echo $e; 
		}
    }

    function down()
    {
       \DBUtil::drop_table('users');
    }

}