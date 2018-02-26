<?php
namespace Fuel\Migrations;

class Songs
{
		
    function up()
    {	
    	try
    	{
	        \DBUtil::create_table(
	    		'songs',
	    		array(
	    		    'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
	    		    'title' => array('constraint' => 30, 'type' => 'varchar', 'null' => false),
	    		    'artist' => array('constraint' => 30, 'type' => 'varchar', 'null' => false),
	    		    'url' => array('constraint' => 200, 'type' => 'varchar', 'null' => false),
	    		    'reproduced' => array('constraint' => 11, 'type' => 'int', 'null' => false),
	    		    'liked' => array('constraint' => 11, 'type' => 'int', 'null' => false),
	    		),
	    		array('id'), false, 'InnoDB', 'utf8_general_ci'
			);
    	}
    	catch(\Database_Exception $e)
		{
		   echo $e; 
		}
    }

    function down()
    {
       \DBUtil::drop_table('songs');
    }

}