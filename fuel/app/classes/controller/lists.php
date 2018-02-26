<?php 
class Controller_Lists extends Controller_Base
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

	            $validInput = $this->validateRequiredParams($input, ['title' => '']);

	    		if (!$validInput)  
		        {
		            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
		        }

		        $title = $input['title'];
		        $decodedToken = self::decodeToken();
		        $list = new Model_Lists();
		        $list->title = $title;
		       	$list->editable = 1;
		       	$list->user = Model_Users::find($decodedToken->id);
		       	$list->save();

		       	return $this->jsonResponse( 201, 'Nueva lista creada',['list' => $list]);
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
		        $list = Model_Lists::find($id);

		        if(empty($list))
		        {
		        	return $this->jsonResponse( 400, 'La lista no existe', []);
		        }

		        if ($list->editable == 0)
		        {
		        	return $this->jsonResponse( 419, 'La lista no es editable', []);
		        }
		        $adminRoleId = $this->getAdminRoleId();
		   		
		        if ( $list->user->id != $decodedToken->id && $decodedToken->id_role != $adminRoleId)
		        {
		        	return $this->jsonResponse( 419, 'No puedes modificar esta lista', []);
		        }

		        $listTitle = $list->title;
		        $list->delete();

		        return $this->jsonResponse( 201, 'Lista eliminada', ['title' => $listTitle]);
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

	            $validInput = $this->validateRequiredParams($input, ['idList' => '', 'title' => '']);

	    		if (!$validInput)  
		        {
		            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
		        }

		        $id = $input['idList'];
		        $title = $input['title'];
		        $decodedToken = self::decodeToken();
            	$list = Model_Lists::find($id);

		        if(empty($list))
		        {
		        	return $this->jsonResponse( 400, 'La lista no existe', []);
		        }


		        if ($list->editable == 0)
		        {
		        	return $this->jsonResponse( 419, 'La lista no es editable', []);
		        }
		        $adminRoleId = $this->getAdminRoleId();
		   		
		        if ( $list->user->id != $decodedToken->id && $decodedToken->id_role != $adminRoleId)
		        {
		        	return $this->jsonResponse( 419, 'No puedes modificar esta lista', []);
		        }

		        $list->title = $title;
		        $list->save();

		        return $this->jsonResponse( 201, 'Lista actualizada', ['lista' => $list]);
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
    public function get_userLists()
    {   
    	$input = $_GET;
    	try
    	{
    		$auth = self::authenticate();

        	if ($auth == true) 
        	{
        		$decodedToken = self::decodeToken();
            	$lists = Model_Lists::find('all', 
                                		  ['where' => 
                                 		  ['id_user' => $decodedToken->id]]);


            	if (empty($lists))
            	{
            		return $this->jsonResponse( 400, 'No hay listas que mostrar', []);
            	}

            	return $this->jsonResponse( 200, 'listas del usuario', ['lists' => Arr::reindex($lists)]);
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
    public function get_userList()
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

		        $id = $input['id'];


        		$decodedToken = self::decodeToken();
            	$list = Model_Lists::query()->related('song')
            								->where('id_user', $decodedToken->id)
            								->where('id', $id)
            								->get();


            	if (empty($list))
            	{
            		return $this->jsonResponse( 419, 'No hay lista que mostrar', []);
            	}

            	return $this->jsonResponse( 200, 'lista del usuario', ['list' => Arr::reindex($list)]);
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

    public function get_watched()
    {   
        $input = $_GET;
        try
        {
            $auth = self::authenticate();

            if ($auth == true) 
            {

                $decodedToken = self::decodeToken();
                $list = Model_Lists::query()->related('song')
                                            ->where('id_user', $decodedToken->id)
                                            ->where('title', 'watched')
                                            ->get();


                if (empty($list))
                {
                    return $this->jsonResponse( 419, 'No hay lista que mostrar', []);
                }

                return $this->jsonResponse( 200, 'lista del usuario', ['list' => Arr::reindex($list)]);
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

    public function post_addSong()
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

	            $validInput = $this->validateRequiredParams($input, ['id_song' => '', 'id_list' => '']);

	    		if (!$validInput)  
		        {
		            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
		        }
		        $id_song = $input['id_song'];
                $id_list = $input['id_list'];

                $song = Model_Songs::find($id_song);

                if (empty($song))
            	{
            		return $this->jsonResponse( 419, 'No existe la cancion', []);
            	}

                $list = Model_Lists::find($id_list);

                if (empty($list))
            	{
            		return $this->jsonResponse( 419, 'No existe la lista', []);
            	}

            	$decodedToken = self::decodeToken();
            	if($list->id_user != $decodedToken->id && $list->editable == 0)
                {
                	return $this->jsonResponse( 419, 'No puedes añadir canciones a esa lista', []);
                }

            	$list->song[] = $song;
            	$list->save();

            	return $this->jsonResponse( 201, 'Cancion añadida', ['lista' => $list]);

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

    public function post_removeSong()
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

	            $validInput = $this->validateRequiredParams($input, ['id_song' => '', 'id_list' => '']);

	    		if (!$validInput)  
		        {
		            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
		        }
		        $id_song = $input['id_song'];
                $id_list = $input['id_list'];

                $song = Model_Songs::find($id_song);

                if (empty($song))
            	{
            		return $this->jsonResponse( 419, 'No existe la cancion', []);
            	}

                $list = Model_Lists::find($id_list);

                if (empty($list))
            	{
            		return $this->jsonResponse( 419, 'No existe la lista', []);
            	}
            	

            	$decodedToken = self::decodeToken();
            	if($list->id_user != $decodedToken->id && $list->editable == 0)
                {
                	return $this->jsonResponse( 419, 'No puedes eliminar canciones a esa lista', []);
                }

                try
                {
                	$list->song[$song->id];
                }
		    	catch (Exception $e) 
		        {
		        	return $this->jsonResponse( 419, 'La canción no se encuentra en esta lista', []);
		        }  

            	unset($list->song[$song->id]);
            	$list->save();

            	return $this->jsonResponse( 201, 'Cancion eliminada', ['lista' => $list]);

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