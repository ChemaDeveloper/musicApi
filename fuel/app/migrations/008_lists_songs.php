<?php
namespace Fuel\Migrations;

class Lists_songs
{
		
    function up()
    {	
    	try
    	{
	        \DBUtil::create_table(
	    		'lists_songs',
	    		array(
	    		    'id_list' => array('constraint' => 11, 'type' => 'int', 'null' => false),
	    		    'id_song' => array('constraint' => 11, 'type' => 'int', 'null' => false),
	    		),
	    		array('id_list', 'id_song'), false, 'InnoDB', 'utf8_general_ci',
	    		array(
                    array(
                        'constraint' => 'foreingKeyLists_songsToList',
                        'key' => 'id_list',
                        'reference' => array(
                            'table' => 'lists',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
                        'on_delete' => 'RESTRICT'
                    ),
                    array(
                        'constraint' => 'foreingKeyLists_songsToSong',
                        'key' => 'id_song',
                        'reference' => array(
                            'table' => 'songs',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
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
       \DBUtil::drop_table('lists_songs');
    }

}