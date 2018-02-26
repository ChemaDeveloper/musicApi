<?php 

class Controller_Users extends Controller_Base
{

	private function checkExistingUserName($name)
	{
    	$userName = Model_Users::find('all', 
                                 ['where' => 
                                 ['name' => $name]]);
            if (empty($userName)) {
                return false;
            }else{
            	return true;
            }
    }

    private function checkExistingEmail($email)
    {
    	$userEmail = Model_Users::find('all', 
                                 ['where' => 
                                 ['email' => $email]]);
            if (empty($userEmail)) {
                return false;
            }else{
            	return true;
            }
    }


	public function post_create()
    {
    	$input = $_POST;
    	try 
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
    		$validInput = $this->validateRequiredParams($input, ['name' => '',
    														    'pass' => '', 
    														    'email' => '', 
    														    'id_device' => '']);
    		if (!$validInput)  
	        {
	            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
	        }

	        $name = $input['name'];
	        $pass = $input['pass'];
	        $email = $input['email'];
	        $id_device = $input['id_device'];

	        $nameExist = $this->checkExistingUserName($name);
	        if ($nameExist)
	        {
	        	return $this->jsonResponse( 419, 'Nombre de usuario ya escogido', []);
	        }
	        $emailExist = $this->checkExistingEmail($email);
	        if ($emailExist)
	        {
	        	return $this->jsonResponse( 419, 'Email ya en uso', []);
	        }
	        if (strlen($name) < 3) 
	        {
	        	return $this->jsonResponse( 419, 'EL usuario debe tener al menos 3 caracteres', []);
	        }
	        if (strlen($pass) < 8) 
	        {
	        	return $this->jsonResponse( 419, 'La contraseña debe tener al menos 8 caracteres', []);
	        }
	        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
	        {
	        	return $this->jsonResponse( 419, 'El email debe tener un formato válido', []);
	        }

	        $user = new Model_Users();
            $user->name = $name;
            $user->pass = $this->encode($pass);
            $user->email = $email;
            $user->id_device = $id_device;
            $user->profile_pic = 'http://' . $_SERVER['SERVER_NAME'] . '/musicApi/public/assets/img/default_image.png';
            $idRole = $this->getUserRoleId();

            $user->role = Model_Roles::find($idRole);
            $user->save();

            $watchedList = new Model_Lists();
		    $watchedList->title = "watched";
		    $watchedList->editable = 0;
		    $watchedList->user = Model_Users::find($user->id);
		    $watchedList->save();

		    $lastWatchedList = new Model_Lists();
		    $lastWatchedList->title = "lastWatched";
		    $lastWatchedList->editable = 0;
		    $lastWatchedList->user = Model_Users::find($user->id);
		    $lastWatchedList->save();

            $token = $this->buildToken($name, $this->encode($pass), $email, $idRole, $user->id);

            return $this->jsonResponse( 201, 'Usuario creado', ['token' => $token, 
            													'name' => $name, 
            													'photo' => $user->profile_pic]);

    	} 
    	catch (Exception $e) 
        {
        	return $this->jsonResponse( 500, 'Error interno del servidor', []);
        }
    }

    public function get_login()
    {
    	$input = $_GET;
    	try 
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
    		$validInput = $this->validateRequiredParams($input, ['name' => '',
    														     'pass' => '']);
    		if (!$validInput)  
	        {
	            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
	        }

	        $name = $input['name'];
        	$pass = $this->encode($input['pass']);

        	$user = Model_Users::find('all', 
                                 ['where' => 
                                 ['name' => $name, 
                                  'pass' => $pass]]);
        	if (empty($user))
        	{
        		return $this->jsonResponse( 401, 'Usuario o contraseña incorrectos', []);
        	}

        	foreach ($user as $key => $value) {
                $id = $value->id;
                $id_role = $value->id_role;
                $email = $value->email;
                $photo = $value->profile_pic;
            }

        	$token = $this->buildToken($name, $pass, $email, $id_role, $id);

        	return $this->jsonResponse( 200, 'usuario logeado', ['token' => $token, 
        														 'name' => $name, 
        														 'photo' => $photo]);
    	} 
    	catch (Exception $e) 
        {
        	return $this->jsonResponse( 500, 'Error interno del servidor', []);
        }
    }
    public function get_recoverpassword()
    {
    	$input = $_GET;
    	try 
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
    		$validInput = $this->validateRequiredParams($input, ['name' => '',
    														     'email' => '']);
    		if (!$validInput)  
	        {
	            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
	        }

	        $name = $input['name'];
	        $email = $input['email'];

	        $user = Model_Users::find('all', 
                                 ['where' => 
                                 ['name' => $name, 
                                  'email' => $email]]);

	        if (empty($user))
        	{
        		return $this->jsonResponse( 401, 'Usuario o email incorrectos', []);
        	}

        	foreach ($user as $key => $value) {
                $id = $value->id;
                $id_role = $value->id_role;
                $pass = $value->pass;
                $photo = $value->profile_pic;
            }

        	$token = $this->buildToken($name, $pass, $email, $id_role, $id);

        	return $this->jsonResponse( 200, 'usuario logeado', ['token' => $token, 
        														 'name' => $name, 
        														 'photo' => $photo]);
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
    		$input = $this->addFilesToInput($_FILES, $_POST);
   
        
        	//Antes de hacer nada se autentica al usuario
        	$auth = self::authenticate();

        	if ($auth == true) 
        	{ 
	        	$userToken = [];


	    		if (empty($input)) 
	            {
	            	return $this->jsonResponse( 400, 'El array de parametros no puede estar vacío', []);
	            }
	            $checkDuplicatedParams = $this->checkDuplicatedParams($input);

	            if (!$checkDuplicatedParams) 
	            {
	            	return $this->jsonResponse( 400, 'No puede haber parametros duplicados', []);
	            }
	            $validInput = $this->validateNotRequiredParams($input, ['pass' => '',
	    														     	'email' => '',
																	 	'photo' => '',
																	 	'description' => '',
																	 	'birthdate' => '',
																	 	'x' => '',
																	 	'y' => '',
																	 	'city' => '']);
	            if (!$validInput)  
		        {
		            return $this->jsonResponse( 400, 'Los parametros de la llamada no son validos', []);
		        }

		        $decodedToken = self::decodeToken();
            	$updateUser = Model_Users::find($decodedToken->id);
            	$userToken = array("name" => $decodedToken->name, 
            					   "id" => $decodedToken->id, 
            					   "id_role" => $decodedToken->id_role);

				if (isset($input['pass']) && $input['pass'] != "")
            	{
	                if (strlen($input['pass']) < 8) 
	                {
	                    return $this->jsonResponse( 419, 'La contraseña debe de tener al menos 8 caracteres', []);
	                }
                
                    $updateUser->pass = self::encode($input['pass']);
                    $userToken["pass"] = self::encode($input['pass']);     
	            }    
	            else
	            {
	                $userToken["pass"] = $decodedToken->pass;
	            }
	            if (isset($input['email']) && $input['email'] != "") 
            	{
	                if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) 
	                {
	                    return $this->jsonResponse( 419, 'El formato de email introducido no es válido', []);
	                }

		            $userEmail = Model_Users::find('all', 
		                                          ['where' => ['email' => $input['email']]]);
		            if (!empty($userEmail)) 
		            {
		                return $this->jsonResponse( 419, 'Email ya en uso', []);
		            }
		                
		            $updateUser->email = $input['email'];
		            $userToken["email"] = $input['email'];                     
	            }
	            else
	            {
	                $userToken["email"] = $decodedToken->email;

	            }

	            if (isset($input['description']) && $input['description'] != "")
            	{
            		$updateUser->description = $input['description'];
            	}

            	if (isset($input['birthdate']) && $input['birthdate'] != ""){
            		$updateUser->birthdate = $input['birthdate'];
            	}

            	if (isset($input['x']) && isset($input['y']) && $input['x'] != "" && $input['y'] != ""){
            		$updateUser->x = $input['x'];
            		$updateUser->y = $input['y'];
            	}

            	if (isset($input['city']) && $input['city'] != ""){
            		$updateUser->city = $input['city'];
            	}

	            if (isset($_FILES['photo'])) 
            	{
	                // Custom configuration for this upload
	                $config = array(
	                    'path' => DOCROOT . 'assets/img',
	                    'randomize' => true,
	                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
	                );
	                // process the uploaded files in $_FILES
	                Upload::process($config);
	                // if there are any valid files
	                if (Upload::is_valid())
	                {
	                    // save them according to the config
	                    Upload::save();
	                    foreach(Upload::get_files() as $file)
	                    {
	                        $updateUser->profile_pic = 'http://' . $_SERVER['SERVER_NAME'] . '/musicApi/public/assets/img/'
	                         . $file['saved_as'];  
	                    }
	                }
	                // and process any errors
	                foreach (Upload::get_errors() as $file)
	                {
	                    return $this->response(array(
	                        'code' => 500,
	                    ));
	                }
           		}

           		$updateUser->save();

           		return $this->jsonResponse( 201, 'datos actualizados', ['token' => $this->encode($userToken), 
           															    'user' => $updateUser]);

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

    public function get_users(){
    	try
    	{
    		//Antes de hacer nada se autentica al usuario
        	$auth = self::authenticate();

        	if ($auth == true) 
        	{
        		$users = Model_Users::find('all');
        		if (empty($users)){
        			return $this->jsonResponse( 400, 'No hay usuarios que mostrar', []);
        		}

        		return $this->jsonResponse( 200, 'Usuarios en la app', ['users' => Arr::reindex($users)] );
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