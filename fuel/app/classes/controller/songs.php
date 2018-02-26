<?php 
class Controller_Songs extends Controller_Base
{
	public function post_create()
    {

    	$input = $_POST;
    	try
    	{
    		$auth = self::authenticate();

        	if ($auth == true) 
        	{
        		if (empty($input)) 
	            {
	            	return $this->jsonResponse( 400, 'El array de parametros no puede estar vacío', []);
	            }

	            $checkDuplicatedParams = $this->checkDuplicatedParams($input);

	            if (!$checkDuplicatedParams) 
	            {
	            	return $this->jsonResponse( 400, 'No puede haber parametros duplicados', []);
	            }

	            $validInput = $this->validateRequiredParams($input, ['title' => '', 'artist' => '', 'url' => '']);

	    		if (!$validInput)  
		        {
		            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
		        }

		        $title = $input['title'];
                $artist = $input['artist'];
                $url = $input['url'];

                $decodedToken = self::decodeToken();
                $adminRoleId = $this->getAdminRoleId();
		   		
		        if ($decodedToken->id_role != $adminRoleId)
		        {
		        	return $this->jsonResponse( 419, 'No puedes cear canciones', []);
		        }

                $songUrl = Model_Songs::find('all', 
                                			['where' => ['url' => $url]]);
                if (!empty($songUrl)) {
	                return $this->jsonResponse( 419, 'url ya en uso',[]);
	            }

	            $song = new Model_Songs();
	            $song->title = $title;
	            $song->artist = $artist;
	            $song->url = $url;
	            $song->reproduced = 0;
	            $song->liked = 0;
	            $song->save();

		       	return $this->jsonResponse( 201, 'Nueva canción creada',['canción' => $song]);
        	}
        	else
        	{
        		return $this->jsonResponse( 401, 'No ha podido ser autenticado', []);
        	}

    	}
    	catch (Exception $e) 
        {
        	return $this->jsonResponse( 500, 'Error interno del servidor', []);
        }
        
    }
    public function get_songs()
    {   
        $input = $_GET;
    	try
    	{
    		$auth = self::authenticate();

        	if ($auth == true) 
        	{
        		
            	$songs = Model_Songs::find('all');


            	if (empty($songs))
            	{
            		return $this->jsonResponse( 419, 'No hay canciones que mostrar', []);
            	}

            	return $this->jsonResponse( 200, 'Canciones en la app', ['songs' => Arr::reindex($songs)]);
		    }
        	else
        	{
        		return $this->jsonResponse( 401, 'No ha podido ser autenticado', []);
        	}

    	}
    	catch (Exception $e) 
        {
        	return $this->jsonResponse( 500, 'Error interno del servidor', []);
        } 
        
    }

    public function get_song()
    {   
        $input = $_GET;
    	try
    	{
    		$auth = self::authenticate();

        	if ($auth == true) 
        	{
        		if (empty($input)) 
	            {
	            	return $this->jsonResponse( 400, 'El array de parametros no puede estar vacío', []);
	            }

	            $checkDuplicatedParams = $this->checkDuplicatedParams($input);

	            if (!$checkDuplicatedParams) 
	            {
	            	return $this->jsonResponse( 400, 'No puede haber parametros duplicados', []);
	            }

	            $validInput = $this->validateRequiredParams($input, ['id' => '']);

	    		if (!$validInput)  
		        {
		            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
		        }
		        $decodedToken = self::decodeToken();
		        $userList = Model_Lists::find('first', ['where' => 
		    											['id_user' => $decodedToken->id,
		    											 'title' => 'watched']]);

		        $id = $input['id'];
            	$song = Model_Songs::find($id);

                if (empty($song))
                {
                    return $this->jsonResponse( 419, 'No hay canción que mostrar', []);
                }
                
            	$userList->song[] = $song;
            	$userList->save();


            	

				$song->reproduced = $song->reproduced + 1;
				$song->save();

            	return $this->jsonResponse( 200, 'Canción para escuchar', ['cancion' => $song]);
		    }
        	else
        	{
        		return $this->jsonResponse( 401, 'No ha podido ser autenticado', []);
        	}

    	}
    	catch (Exception $e) 
        {
        	return $this->jsonResponse( 500, 'Error interno del servidor', []);
        } 
        
    }

    public function post_update()
    {

		$input = $_POST;
    	try
    	{
    		$auth = self::authenticate();

        	if ($auth == true) 
        	{
        		if (empty($input)) 
	            {
	            	return $this->jsonResponse( 400, 'El array de parametros no puede estar vacío', []);
	            }

	            $checkDuplicatedParams = $this->checkDuplicatedParams($input);

	            if (!$checkDuplicatedParams) 
	            {
	            	return $this->jsonResponse( 400, 'No puede haber parametros duplicados', []);
	            }

	            $validInput = $this->validateNotRequiredParams($input, ['id' => '', 
	            														'title' => '', 
	            														'artist' => '',
	            														'url' => '']);

	    		if (!$validInput)  
		        {
		            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
		        }

		        

		        $decodedToken = self::decodeToken();
                $adminRoleId = $this->getAdminRoleId();
		   		
		        if ($decodedToken->id_role != $adminRoleId)
		        {
		        	return $this->jsonResponse( 419, 'No puedes eliminar canciones', []);
		        }
		        
		        $id = $input['id'];
            	$song = Model_Songs::find($id);

		        if(empty($song))
		        {
		        	return $this->jsonResponse( 419, 'La canción no existe', []);
		        }

		        if (isset($input['title']) && $input['title'] != "")
            	{
	                $song->title = $input['title'];    
	            }
				if (isset($input['artist']) && $input['artist'] != "")
            	{
	                $song->artist = $input['artist'];    
	            }
	            if (isset($input['url']) && $input['url'] != "")
            	{
            		$songUrl = Model_Songs::find('all', 
	                                 			['where' => 
	                                 			['url' => $input['url']]]);
			            if (!empty($songUrl)) 
			            {
			                return $this->jsonResponse( 419, 'Url ya en uso', []);
			            }
	                $song->url = $input['url'];    
	            }
	            $song->save();



		        return $this->jsonResponse( 201, 'Canción actualizada', ['cancion' => $song]);
			}
        	else
        	{
        		return $this->jsonResponse( 401, 'No ha podido ser autenticado', []);
        	}
        }
    	catch (Exception $e) 
        {
        	return $this->jsonResponse( 500, 'Error interno del servidor', []);
        } 
    }
    public function post_delete()
    {   

    	$input = $_POST;
    	try
    	{
    		$auth = self::authenticate();

        	if ($auth == true) 
        	{
        		if (empty($input)) 
	            {
	            	return $this->jsonResponse( 400, 'El array de parametros no puede estar vacío', []);
	            }

	            $checkDuplicatedParams = $this->checkDuplicatedParams($input);

	            if (!$checkDuplicatedParams) 
	            {
	            	return $this->jsonResponse( 400, 'No puede haber parametros duplicados', []);
	            }

	            $validInput = $this->validateRequiredParams($input, ['id' => '']);

	    		if (!$validInput)  
		        {
		            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
		        }

		        $id = $input['id'];

		        $decodedToken = self::decodeToken();
                $adminRoleId = $this->getAdminRoleId();
		   		
		        if ($decodedToken->id_role != $adminRoleId)
		        {
		        	return $this->jsonResponse( 419, 'No puedes eliminar canciones', []);
		        }

		        $song = Model_Songs::find($id);

		        if(empty($song))
		        {
		        	return $this->jsonResponse( 419, 'La canción no existe', []);
		        }

		        $songDeleted = $song;
		        $song->delete();

		        return $this->jsonResponse( 201, 'Canción eliminada', ['cancion' => $songDeleted]);
			}
        	else
        	{
        		return $this->jsonResponse( 401, 'No ha podido ser autenticado', []);
        	}

    	}
    	catch (Exception $e) 
        {
        	return $this->jsonResponse( 500, 'Error interno del servidor', []);
        }      
        
    }

    public function post_like()
    {
    	$input = $_POST;
    	try
    	{
    		$auth = self::authenticate();

        	if ($auth == true) 
        	{
        		if (empty($input)) 
	            {
	            	return $this->jsonResponse( 400, 'El array de parametros no puede estar vacío', []);
	            }

	            $checkDuplicatedParams = $this->checkDuplicatedParams($input);

	            if (!$checkDuplicatedParams) 
	            {
	            	return $this->jsonResponse( 400, 'No puede haber parametros duplicados', []);
	            }

	            $validInput = $this->validateRequiredParams($input, ['id' => '']);

	    		if (!$validInput)  
		        {
		            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
		        }

		        $id = $input['id'];

		        $song = Model_Songs::find($id);

                if (empty($song))
            	{
            		return $this->jsonResponse( 419, 'No existe la cancion', []);
            	}
            	$decodedToken = self::decodeToken();

            	$user = Model_Users::find($decodedToken->id);
            	try
            	{
            		$user->song[$id];
            	}
            	catch (Exception $e)
            	{
            		$song->liked = $song->liked + 1;
            		$song->save();
            		$user->song[] = $song;
            		$user->save();

            		return $this->jsonResponse( 201, 'like', ['liked' => $user, 'song' => $song]);
            	}
            	
            	return $this->jsonResponse( 419, 'Ya te gusta esa canción', []);	
 		    }
        	else
        	{
        		return $this->jsonResponse( 401, 'No ha podido ser autenticado', []);
        	}

    	}
    	catch (Exception $e) 
        {
        	return $this->jsonResponse( 500, 'Error interno del servidor', []);
        } 

    }

    public function post_unlike()
    {
    	$input = $_POST;
    	try
    	{
    		$auth = self::authenticate();

        	if ($auth == true) 
        	{
        		if (empty($input)) 
	            {
	            	return $this->jsonResponse( 400, 'El array de parametros no puede estar vacío', []);
	            }

	            $checkDuplicatedParams = $this->checkDuplicatedParams($input);

	            if (!$checkDuplicatedParams) 
	            {
	            	return $this->jsonResponse( 400, 'No puede haber parametros duplicados', []);
	            }

	            $validInput = $this->validateRequiredParams($input, ['id' => '']);

	    		if (!$validInput)  
		        {
		            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
		        }

		        $id = $input['id'];

		        $song = Model_Songs::find($id);

                if (empty($song))
            	{
            		return $this->jsonResponse( 419, 'No existe la cancion', []);
            	}

            	$decodedToken = self::decodeToken();

            	$user = Model_Users::find($decodedToken->id);

            	try
                {
                	$user->song[$song->id];
                }
		    	catch (Exception $e) 
		        {
		        	return $this->jsonResponse( 419, 'La canción no se encuentra en esta lista', []);
		        }  
		        $song->liked = $song->liked - 1;
            	$song->save();
            	unset($user->song[$song->id]);
            	$user->save();

            	return $this->jsonResponse( 201, 'unlike', ['liked' => $user, 'song' => $song]);
 		    }
        	else
        	{
        		return $this->jsonResponse( 401, 'No ha podido ser autenticado', []);
        	}

    	}
    	catch (Exception $e) 
        {
        	return $this->jsonResponse( 500, 'Error interno del servidor', []);
        } 

    }

    public function get_likedSongs()
    {
    	$input = $_GET;
    	try
    	{
    		$auth = self::authenticate();

        	if ($auth == true) 
        	{
        		$decodedToken = self::decodeToken();
        		$likedSongs = Model_Users::query()->related('song')
            								->where('id', $decodedToken->id)
            								->get();
            	if (empty($likedSongs))
            	{
            		return $this->jsonResponse( 419, 'No hay canciones que mostrar', []);
            	}
            	return $this->jsonResponse( 200, 'Canciones que te gustan', ['songs' => Arr::reindex($likedSongs)]);
        	}
        	else
        	{
        		return $this->jsonResponse( 401, 'No ha podido ser autenticado', []);
        	}

    	}
    	catch (Exception $e) 
        {
        	return $this->jsonResponse( 500, 'Error interno del servidor', []);
        }
    }
}