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

		       	return $this->jsonResponse( 201, 'Nueva lista creada', $list);
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

		        return $this->jsonResponse( 201, 'Lista eliminada', ['title', $listTitle]);
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
        $auth = self::authenticate();
        if($auth == true)
        {
            if ( ! isset($_POST['id']) || ! isset($_POST['name']) ) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametros incorrectos',
                    'data' => null
                ));
                return $json;
            }
            $id = $_POST['id'];
            $updateList = Model_Lists::find($id);
            $title = $_POST['name'];
            if(!empty($updateList))
            {


                $decodedToken = self::decodeToken();
                if($decodedToken->id == $updateList->id_user)
                {
                    $updateList->title = $title;
                    $updateList->save();
                    $json = $this->response(array(
                    'code' => 200,
                    'message' => 'lista actualizada',
                    'data' => null
                    ));
                    return $json;
                }
                else
                {
                    $json = $this->response(array(
                        'code' => 401,
                        'message' => 'No estas autorizado a cambiar esa lista',
                        'data' => null
                    ));
                    return $json;
                }
            }
            else
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'lista no encontrada',
                    'data' => null
                ));
                return $json;
            }
        }
        else
        {
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuario no autenticado',
                    'data' => null
            ));
            return $json;
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
    public function post_add_song()
    {
        $auth = self::authenticate();
        if($auth == true)
        {
            try {
                if ( ! isset($_POST['id_song']) || ! isset($_POST['id_list'])) 
                {
                    $json = $this->response(array(
                        'code' => 400,
                        'message' => 'parametro incorrecto',
                        'data' => null
                    ));
                    return $json;
                }
                
                $input = $_POST;
                $id_song = $input['id_song'];
                $id_list = $input['id_list'];
                $decodedToken = self::decodeToken();

                $list = Model_Lists::find($id_list);
                if($list->id_user == $decodedToken->id)
                {
                    $list->song[] = Model_Songs::find($id_song);
                    $list->save();
                    $json = $this->response(array(
                        'code' => 200,
                        'message' => 'Cancion añadida',
                        'data' => null
                    ));
                    return $json;
                }
                
            } 
            catch (Exception $e) 
            {
                $json = $this->response(array(
                    'code' => 500,
                    'message' => 'error interno del servidor',
                    'data' => null
                ));
                return $json;
            }
        }
        
    }

}