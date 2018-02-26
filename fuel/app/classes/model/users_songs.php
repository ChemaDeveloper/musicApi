<?php
class Model_Users_songs extends Orm\Model
{
    protected static $_table_name = 'users_songs';
    protected static $_primary_key = array('id_user', 'id_song');
    protected static $_properties = array(
        'id_user' => array(
            'data_type' => 'int'   
        ),
        'id_song' => array(
            'data_type' => 'int'   
        )
    );
    
}