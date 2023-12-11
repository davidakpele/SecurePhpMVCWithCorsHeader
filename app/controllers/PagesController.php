<?php

use session\auth\session;

final class PagesController extends Controller {

    private $_fetching_sql_model_data;

    public function __construct() {
       @$this->_fetching_sql_model_data = @$this->loadModel('User');
    }

    public function index(){
        $authClass= new session();
        $authenticateUser = $authClass->auth_check();
        if (!$authenticateUser) {
            redirect('auth/login');
        }else{
            //get 'user subscription id'
            $id= $_SESSION['UserId'];
            $_get_avaliable_subject= $this->_fetching_sql_model_data->get_user($id);
            $_get_all = $this->_fetching_sql_model_data->get_all();
            $data =
            [
                'fetch_data'=>((!empty($_get_all)) ? $_get_all : ''),
                'auth'=>($authenticateUser ?? ''),
                'data'=> $_get_avaliable_subject,
            ];
            $this->view("index", $data); 
        }       
    }
    
    // render login page
    public function login(){
        $authClass= new session();
        $authenticateUser = $authClass->auth_check();
        if (!$authenticateUser) {
           $data = 
            [
                'page_title'=>'Login User'
            ];
            $this->view("auth/login", $data); 
        }else{
            redirect('Default');
        }
    }

    //render edit page

    public function edit(){
        $authClass= new session();
        $authenticateUser = $authClass->auth_check();
        if (!$authenticateUser) {
            redirect('Default');
        }else{
            $url=implode('',$_REQUEST);
            $urlParts = explode('/', $url);
            if (!isset($urlParts[2]) || empty($urlParts[2])){
                // if the url param is empty, example:" https://localhost/kyc/el/edit/"  NO id include then throw error message
                echo "<script>
                        alert('Invalid URL Request.!');
                        window.location.replace('". ROOT ."');
                    </script>";
            }else if(is_numeric($urlParts[2])==false){
                // if the url param is NOT empty but Then id is string instead of Integer, example:" https://localhost/kyc/el/edit/book" INSTEAD OF "https://localhost/kyc/el/edit/1" then throw error message
                echo "<script>
                    alert('Invalid ID Sent..!');
                    window.location.replace('". ROOT ."');
                </script>";
            }else{
                // Set Controller ? 
                $controller = (((!empty($urlParts[2])) ? $urlParts[2] : ROOT));
                $controllerName = $controller;
                $id=  strip_tags(trim((filter_var($controllerName, FILTER_SANITIZE_NUMBER_INT))));
                $get_user = $this->_fetching_sql_model_data->get_user($id);
                $data = 
                [
                    'id'=>$id,
                    'user'=>(!empty($get_user) ? $get_user : ''),
                    'page_title'=>'Edit'
                ];
                $this->view("el/edit", $data); 
            }
        }
    }
    // render registration page
    public function register(){
        $authClass= new session();
        $authenticateUser = $authClass->auth_check();
        if (!$authenticateUser) {
           
            $data = 
            [
                'page_title'=>'Register New User Account'
            ];
            $this->view("auth/register", $data); 
        }else{
            redirect('Default');
        }
    }
}