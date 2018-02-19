<?php
namespace Fuel\Migrations;

class Users_users
{	
    function up()
    {	
    	try
    	{
	        \DBUtil::create_table(
	    		'users_users',
	    		array(
	    		    'id_follower' => array('constraint' => 11, 'type' => 'int'),
	    		    'id_followed' => array('constraint' => 11, 'type' => 'int'),
	    		),
	    		array('id_follower', 'id_followed'), false, 'InnoDB', 'utf8_general_ci',
	    		array(
                    array(
                        'constraint' => 'foreingKeyUsers_usersToFollower',
                        'key' => 'id_follower',
                        'reference' => array(
                            'table' => 'users',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
                        'on_delete' => 'RESTRICT'
                    ),
                    array(
                        'constraint' => 'foreingKeyUsers_usersToFollowed',
                        'key' => 'id_followed',
                        'reference' => array(
                            'table' => 'users',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
                        'on_delete' => 'RESTRICT'
                    )));
    	}
    	catch(\Database_Exception $e)
		{
		   echo $e; 
		}
    }

    function down()
    {
       \DBUtil::drop_table('users_users');
    }

}