<?php
require_once "src/lib/Api.php";
require_once "/var/www/week_8/src/user/User.php";

class UsersApi extends Api {

    public $apiName = 'User';

    public function viewUser()
    {
        $user = new User();
        $user->getUser($_GET['email']);
        if($user->getId()){
            $password = $_GET['password'];
            if(password_verify($password, $user->getPassword()))
                return $this->response($user->getObj(), 200);
            else
                return $this->response("Incorrect password", 206);
        }
        else return $this->response("Data not found", 404);
    }

    public function createUser()
    {
        $data = array();
        $data['first_name'] = $_POST['first_name'];
        $data['last_name'] = $_POST['last_name'];
        $data['email'] = $_POST['email'];
        $data['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $user = new User();
        if($data=$user->addUser($data))
            if($data === "user exists")
                return $this->response(array('status'=>true, 'text'=>'user exists'), 200);
            else
                return $this->response(array('status'=>true, 'text'=>'Registration successful'), 200);
        else
            return $this->response("Data not found", 404);

    }

    public function updateUser()
    {
        // TODO: Implement updateUser() method.
    }

    public function deleteUser()
    {
        // TODO: Implement deleteUser() method.
    }
}
