<?php
namespace Fuel\Migrations;

class Lists
{
		
    function up()
    {	
    	try
    	{
	        \DBUtil::create_table(
	    		'lists',
	    		array(
	    		    'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
	    		    'title' => array('constraint' => 40, 'type' => 'varchar', 'null' => false),
	    		    'editable' => array('constraint' => 1, 'type' => 'int', 'null' => false),
	    		    'id_user' => array('constraint' => 11, 'type' => 'int', 'null' => false),
	    		),
	    		array('id'), false, 'InnoDB', 'utf8_general_ci',
	    		array(
                    array(
                        'constraint' => 'foreingKeyListToUsers',
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
       \DBUtil::drop_table('lists');
    }

}