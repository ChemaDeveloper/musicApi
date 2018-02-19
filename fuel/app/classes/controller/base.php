<?php 
use \Firebase\JWT\JWT;

class Controller_Base extends Controller_Rest
{
	private $key = "-----BEGIN PGP PUBLIC KEY BLOCK-----

					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
					=RN4Z
					-----END PGP PUBLIC KEY BLOCK-----
					";

	protected function buildToken($name, $pass, $email, $id_role, $id){
		$token = ["name" => $name,
				  "pass" => $pass,
				  "email" => $email,
				  "id_role" => $id_role,
				  "id" => $id];
		return $this->encode($token);
	}
    protected function encode($data){
    	return JWT::encode($data, $this->key);
    }
    protected function decode($data){
    	return JWT::decode($data, $this->key, array('HS256'));
    }
    protected function decodeToken(){
        $header = apache_request_headers();
        $token = $header['Authorization'];
        if(!empty($token))
        {
            return JWT::decode($token, $this->key, array('HS256'));
        }     
    }
    protected function authenticate(){
        try {
               
            $header = apache_request_headers();
            $token = $header['Authorization'];
            if(!empty($token))
            {
                $decodedToken = JWT::decode($token, $this->key, array('HS256'));

                $query = Model_Users::find('all', 
                    ['where' => ['name' => $decodedToken->name, 
                                 'pass' => $decodedToken->pass, 
                                 'id_role' => $decodedToken->id_role,
                                 'email' => $decodedToken->email,
                                 'id' => $decodedToken->id]]);
                if($query != null)
                {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        } 
        catch (Exception $UnexpectedValueException)
        {

            return false;
        }
    }
    public function post_config(){
        $admin = Model_Users::find('all',
                                    ['where' => ['name' => 'admin']]);
        if(empty($admin))
        {
            $adminRole = new Model_Roles();
            $adminRole->name = "admin";
            $adminRole->save();
            
            $userRole = new Model_Roles();
            $userRole->name = "user";
            $userRole->save();

            $admin = new Model_Users();
            $admin->name = "admin";
            $admin->pass = self::encode('1234');
            $admin->email = "admin@admin.es";
            $admin->id_device = "0000000001";
            $admin->profile_pic = 'http://' . $_SERVER['SERVER_NAME'] . '/musicApi/public/assets/img/default_image.png';
            $admin->role = Model_Roles::find($adminRole->id);
            $admin->save();

            return self::jsonResponse( 201, 'Configuración terminada correctamente', $admin);
        }
        else
        {
            return self::jsonResponse( 401, 'Configuración ya implementada anteriormente', []);
        }
    }

    public function get_default_auth()
    {  
        $auth = self::authenticate();
        if($auth == true)
        {
            return self::jsonResponse( 200, 'Usuario autenticado', []);
        }else{
            return self::jsonResponse( 401, 'Usuario no autenticado', []);
        }
        
    }

    protected function validateNotRequiredParams($inputData, $validateData)
    {
        $cont = 0;
        foreach ($inputData as $keyInputData => $valueInputData) 
        {
            foreach ($validateData as $keyValidateData => $valueValidateData) 
            {
                if ($keyInputData == $keyValidateData) 
                {
                    $cont = $cont + 1;
                }
            }
        }

        if ($cont == count($inputData)) 
        {
             return true;
        }
        else
        {
            return false;
        }
        
    }

    protected function validateRequiredParams($inputData, $validateData)
    {
        $cont = 0;
        foreach ($validateData as $keyValidateData => $valueValidateData) 
        {
            foreach ($inputData as $keyInputData => $valueInputData) 
            {
                if ($keyInputData == $keyValidateData) 
                {
                    $cont = $cont + 1;
                }
            }
        }

        if ($cont == count($validateData)) 
        {
             return true;
        }
        else
        {
            return false;
        }
        
    }

    protected function addFilesToInput($files, $input)
    {
        if (!empty($files)) 
        {
            foreach ($files as $key => $file) 
            {
                $input[$key] = $file['name'];
            }
        }

        return $input;
    }

    protected function checkDuplicatedParams($inputData){
        $result = array_unique($inputData);
        if (count($inputData) == count($result)) {
            return true;
        }
        else{
            return false;
        }        
    }

    protected function jsonResponse($code, $message, $data){
        $json = $this->response(array(
                       'code' => $code,
                       'message' => $message,
                       'data' => $data,
            ));
        return $json;
    }

    protected function getUserRoleId()
    {
        $userRole = Model_Roles::find('all', 
                                           ['where' => 
                                           ['name' => 'user']]);
        foreach ($userRole as $keyUserRole => $valueRole) {
            $idRole = $valueRole->id;
        }
        return $idRole;
    }

    protected function getAdminRoleId()
    {
        $adminRole = Model_Roles::find('all', 
                                           ['where' => 
                                           ['name' => 'admin']]);
        foreach ($adminRole as $keyAdminRole => $valueRole) {
            $idRole = $valueRole->id;
        }
        return $idRole;
    }

}