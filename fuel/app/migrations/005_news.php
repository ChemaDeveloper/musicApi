<?php
namespace Fuel\Migrations;

class News
{
		
    function up()
    {	
    	try
    	{
	        \DBUtil::create_table(
	    		'news',
	    		array(
	    		    'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
	    		    'title' => array('constraint' => 11, 'type' => 'varchar', 'null' => false),
                    'description' => array('constraint' => 11, 'type' => 'varchar', 'null' => false),
                    'id_user' => array('constraint' => 11, 'type' => 'int', 'null' => false),
	    		),
	    		array('id'), false, 'InnoDB', 'utf8_general_ci',
	    		array(
                    array(
                        'constraint' => 'foreingKeyNewsToUsers',
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
       \DBUtil::drop_table('news');
    }

}