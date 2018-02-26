<?php
namespace Fuel\Migrations;

class Users_songs
{
		
    function up()
    {	
    	try
    	{
	        \DBUtil::create_table(
	    		'users_songs',
	    		array(
	    		    'id_user' => array('constraint' => 11, 'type' => 'int', 'null' => false),
	    		    'id_song' => array('constraint' => 11, 'type' => 'int', 'null' => false),
	    		),
	    		array('id_user', 'id_song'), false, 'InnoDB', 'utf8_general_ci',
	    		array(
                    array(
                        'constraint' => 'foreingKeyUsers_songsToUsers',
                        'key' => 'id_user',
                        'reference' => array(
                            'table' => 'users',
                            'column' => 'id',
                        ),
                        'on_update' => 'RESTRICT',
                        'on_delete' => 'RESTRICT'
                    ),
                    array(
                        'constraint' => 'foreingKeyUsers_songsToSongs',
                        'key' => 'id_song',
                        'reference' => array(
                            'table' => 'songs',
                            'column' => 'id',
                        ),
                        'on_update' => 'RESTRICT',
                        'on_delete' => 'RESTRICT'
                    ),
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
       \DBUtil::drop_table('users_songs');
    }

}