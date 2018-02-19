<?php
namespace Fuel\Migrations;

class Privacy
{
		
    function up()
    {	
    	try
    	{
	        \DBUtil::create_table(
	    		'privacy',
	    		array(
	    		    'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
	    		    'profile' => array('constraint' => 1, 'type' => 'int', 'null' => false),
                    'friends' => array('constraint' => 1, 'type' => 'int', 'null' => false),
                    'lists' => array('constraint' => 1, 'type' => 'int', 'null' => false),
                    'notifications' => array('constraint' => 1, 'type' => 'int', 'null' => false),
                    'id_user' => array('constraint' => 11, 'type' => 'int', 'null' => false),
	    		),
	    		array('id'), false, 'InnoDB', 'utf8_general_ci',
	    		array(
                    array(
                        'constraint' => 'foreingKeyPrivacyToUsers',
                        'key' => 'id_user',
                        'reference' => array(
                            'table' => 'users',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
                        'on_delete' => 'RESTRICT'
                    )
                )
			);
    	}
    	catch(\Database_Exception $e)
		{
		   echo $e; 
		}
    }

    function down()
    {
       \DBUtil::drop_table('privacy');
    }

}