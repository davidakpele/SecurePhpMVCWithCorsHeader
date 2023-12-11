<?php
use helpers\auth\errorhandlers\errorHandler;
use session\auth\session;

class AuthController extends Controller
{
    private $_sql_model_data;

    public function __construct() {
       $this->_sql_model_data = $this->loadModel('User');
    }

    public function login(){
       // Process login form submission, validate credentials, and set user session
        $response = [];
        $initial_errorhanler_class= new errorHandler();
        if(!$initial_errorhanler_class->validata_api_request_header()){
            $response['message'] = $initial_errorhanler_class->error_log_auth();
        }else{
            $jsonString = file_get_contents("php://input");
            $response = array();
            $phpObject = json_decode($jsonString);

            $email = strip_tags(trim(filter_var($phpObject->{'email'}, FILTER_VALIDATE_EMAIL)));
            $password = strip_tags(trim(filter_var($phpObject->{'password'}, FILTER_SANITIZE_STRING)));
            $newJsonString = json_encode($phpObject);
            $getinfo = $this->_sql_model_data->LoginAuth($email, $password);
            if ($getinfo == false) {
                $response['message']='Invalid credentials provided..!';
                $response['status']= 203;
            }else{
                $authClass= new JwtHttp\jwtUtil;
               
                $_SESSION['UserId']=$getinfo->user_id;
                $_SESSION['UserEmail']=$getinfo->email;
                $_SESSION['username']=$getinfo->name;
                
                $id=$getinfo->user_id;
                $useremail =$getinfo->email;
                $getJwtToken = $authClass::createTokenByUserDetails($id, $useremail);
                $_SESSION['UserJwtAuth']= json_decode($getJwtToken)->token; 
                $response['status']= http_response_code(200);
            }
        }
        echo json_encode($response);
    }

    public function register(){
        $initial_errorhanler_class= new errorHandler();
        if(!$initial_errorhanler_class->validata_api_request_header()){
            $response['message'] = $initial_errorhanler_class->error_log_auth();
        }else{
            $response = [];
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if (isset($_FILES['file']['name']) != '' && isset($_POST['name'])  && !empty($_POST['name']) && isset($_POST['dbo']) && !empty($_POST['dbo']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['confirmpassword']) && !empty($_POST['confirmpassword']) && isset($_POST['address']) && !empty($_POST['address'])){
                // check if user email exist before
                $email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
                if ($email) {
                    $isFetchEmailexist = $this->_sql_model_data->CheckExistingUserEmail($email);
                    if ($isFetchEmailexist) {
                        $response['message']='Email Is Already Taken By Another User';
                        $response['status']= 405;
                    }else{
                        $psw = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
                        $cpsw = trim(filter_var($_POST['confirmpassword'], FILTER_SANITIZE_STRING));
                        if ($psw != $cpsw) {
                            $response['message']='Both password are not the same*';
                            $response['status']= 405;
                        }else{
                            if (is_uploaded_file($_FILES['file']['tmp_name'])){
                                if (isset($_FILES['file']['name']) != ''){
                                    $photo = $_FILES['file'];
                                    $name = $photo['name'];
                                    $nameArray = explode('.', $name);
                                    $fileName = $nameArray[0];
                                    $fileExt = $nameArray[1];
                                    $mime = explode('/', $photo['type']);
                                    $mimeType = $mime[0];
                                    $imgType = $photo['type'];
                                    $mimeExt = $mime[1];
                                    $tmpLoc = $photo['tmp_name'];   
                                    $fileSize = $photo['size']; 

                                    $uploadName = uniqid().'.'.$fileExt;
                                    $uploadPath = 'assets/images/cv/'.trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)).'/'.$uploadName; 
                                    $dbpath     = 'assets/images/cv/'.trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)).'/'.$uploadName;
                                    $folder     = 'assets/images/cv/'.trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
                                
                                    if ($fileSize > 90000000000000) {
                                        $response['status'] = 300;
                                        $response['errormsg'] = '<b>ERROR:</b> Your file was larger than 50kb in file size.';
                                    }elseif ($fileSize < 90000000000000 ) {
                                        if(!file_exists($folder)){
                                            mkdir($folder,077,true);
                                        }
                                        $data =
                                        [
                                            'cv'=>$uploadPath,
                                            'uname'=>trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)),
                                            'mobile'=> trim(filter_var($_POST['mobile'], FILTER_SANITIZE_STRING)), 
                                            'dob'=> trim(filter_var($_POST['dbo'], FILTER_SANITIZE_STRING)),
                                            'ads'=> trim(filter_var($_POST['address'], FILTER_SANITIZE_STRING)),
                                            'email'=> trim(filter_var($_POST['email'], FILTER_SANITIZE_STRING)),
                                            'password'=> password_hash($_POST['password'], PASSWORD_ARGON2ID),
                                        ];
                                        if($this->_sql_model_data->save($data)){
                                            // when data is successfully inserted then move the file into on local drive store
                                            move_uploaded_file($tmpLoc,$dbpath);
                                            $response['status'] = http_response_code(200);
                                            $response['message'] = 'Account Successfully Created..!';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                echo json_encode($response); 
            }
        }
    }


    public function logout(){
        // Logout functionality
        $authClass= new session();
        $authenticateUser = $authClass->auth_check();
        if (!$authenticateUser) {
            $data=['isInLoginMethod'=> true];
            $this->view("auth/Login", $data);
        }else{
            $responses = array();
            if ($authClass->close_session()) {
            $responses['message']='Logout successfully.!';
            $responses['status']= http_response_code(200);
            }else{
                $responses['message']='Something went wrong.!';
                $responses['status']= http_response_code(201);
            }
            echo json_encode(['data'=>$responses]);
        }
    }
}
