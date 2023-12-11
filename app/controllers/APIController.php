<?php 

use helpers\auth\errorhandlers\errorHandler;
use JwtHttp\{jwtUtil};
use Ramsey\Uuid\Uuid;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;

final class APIController extends Controller
{
    private $_fetching_sql_model_data;
    private $jwtKey;

    public function __construct() {
       $this->_fetching_sql_model_data = $this->loadModel('User');
       $this->jwtKey = PRIVATE_KEY;
    }

    public function load_data(){
        if (CorsHeader()) {
            
        }
        
    }

    public function getAllUsers() {
        if ($this->isValidUserToken()) {
            // Check the HTTP method
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == 'GET') {
                // Return all user records as JSON
                $_get_all = $this->_fetching_sql_model_data->get_all();
                $data = ['data'=>$_get_all];
            }else{
                $data['message']='Method Not Allowed';
                http_response_code(405);
            }
            echo json_encode($data);
        }
        
    }

    public function getUser() {
        if ($this->isValidUserToken()) {
            // Check the HTTP method
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == 'GET') {
                $url=implode('',$_REQUEST);
                $urlParts = explode('/', $url);
                if (!isset($urlParts[2]) || empty($urlParts[2])){
                    $data['message']='Invalid Url Request';
                    http_response_code(500);
                }else if(is_numeric($urlParts[2])==false){
                    $data['message']='Invalid ID Sent.! ID must be Integer.';
                    http_response_code(400);
                }else{
                    // Set Controller ? 
                    $controller = (((!empty($urlParts[2])) ? $urlParts[2] : ROOT));
                    $controllerName = $controller;
                    $id=  strip_tags(trim((filter_var($controllerName, FILTER_SANITIZE_NUMBER_INT))));
                    $get_user = $this->_fetching_sql_model_data->get_user($id);
                    if (!empty($get_user)) {
                        $data=['data'=>$get_user];
                        http_response_code(200);
                    }else {
                        $data=['message'=>'No User Found.!'];
                        http_response_code(200);
                    }
                }
            }else{
                $data['message']='Method Not Allowed';
            }
            echo json_encode($data);
        }
        
    }

    public function createUser() {
        // Process API request to create a new user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the Content-Type header is set and is application/json
            $content_type = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
            if ($content_type === 'application/json') {
                // Read the raw POST data
                $json_data = file_get_contents("php://input");
                // Attempt to decode the JSON data
                $decoded_data = json_decode($json_data);

                if ($decoded_data !== null) {
                    // The request is in JSON format
                    $name =  $decoded_data->{'name'};
                    $mobile =  $decoded_data->{'mobile'}; 
                    $email =  $decoded_data->{'email'}; 
                    $dateofbirth =  $decoded_data->{'dateofbirth'}; 
                    $address =  $decoded_data->{'address'}; 
                    $password =  $decoded_data->{'password'}; 
                    $confirmpassword =  $decoded_data->{'confirmpassword'}; 

                    if ($name == "") {
                        $response['message']="The name field is required.";
                        http_response_code(400);
                    }
                    if ($mobile == "") {
                        $response['message']="The mobile field is required.";
                        http_response_code(400);
                    }
                    if ($email == "") {
                        $response['message']="The email field is required.";
                        http_response_code(400);
                    }
                    if ($dateofbirth == "") {
                        $response['message']="The date of birth field is required.";
                        http_response_code(400);
                    }
                    if ($address == "") {
                        $response['message']="The address field is required.";
                        http_response_code(400);
                    }
                    if ($password == "") {
                        $response['message']="The password field is required.";
                        http_response_code(400);
                    }
                    if ($confirmpassword == "") {
                        $response['message']="The confirmpassword field is required.";
                        http_response_code(400);
                    }
                    elseif (!empty($name) && !empty($email) && !empty($password) && !empty($address) && !empty($dateofbirth) && !empty($mobile)) {
                        $email = trim(filter_var($email, FILTER_VALIDATE_EMAIL));
                        if ($email) {
                            
                            $isFetchEmailexist = $this->_fetching_sql_model_data->CheckExistingUserEmail($email);
                            if ($isFetchEmailexist) {
                                $response['message']='Email Is Already Taken By Another User';
                                http_response_code(400);
                            }else{
                                if ($password !== $confirmpassword){
                                    $response['message']="Both password are not the same";
                                    http_response_code(400);
                                }else {
                                    if (isset($_FILES['file']['name']) != ''){
                                        if (is_uploaded_file($_FILES['file']['tmp_name'])){
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
                                                move_uploaded_file($tmpLoc,$dbpath);
                                            }
                                        }
                                    }
                                    // Hash the new password
                                    $hashpassword = password_hash($password, PASSWORD_ARGON2ID);
                                    $data =
                                    [
                                        'cv'=>(isset($uploadPath)? $uploadPath:''),
                                        'uname'=>trim(filter_var($name, FILTER_SANITIZE_STRING)),
                                        'mobile'=> trim(filter_var($mobile, FILTER_SANITIZE_STRING)), 
                                        'dob'=> trim(filter_var($dateofbirth, FILTER_SANITIZE_STRING)),
                                        'ads'=> trim(filter_var($address, FILTER_SANITIZE_STRING)),
                                        'email'=> trim(filter_var($email, FILTER_SANITIZE_STRING)),
                                        'password'=> password_hash($hashpassword, PASSWORD_ARGON2ID),
                                    ];
                                    if($this->_fetching_sql_model_data->save($data)){
                                        $response['status'] = http_response_code(200);
                                        $response['message'] = 'Account Successfully Created..!';
                                    }else {
                                        $response['status'] = http_response_code(400);
                                        $response['message'] = 'Sorry something went wong.!';
                                    }
                                }
                            }
                        }
                    }else{
                        http_response_code(400); // Bad Request
                        $response['message']= "Invalid email format.";
                    }
                }else {
                    // JSON decoding failed
                    http_response_code(400); // Bad Request
                    $response['message']= "Invalid JSON format.";
                }
            }else {
                // Content-Type is not application/json
                http_response_code(415); // Unsupported Media Type
                $response['message']= "Unsupported Media Type. Expected application/json.";
            }
        }else{
            http_response_code(405); 
            $response['message']= "This Method Is Not Allowed";
        }
        echo json_encode($response);
    }

    public function loginUser(){
        if (CorsHeader()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Check if the Content-Type header is set and is application/json
                $content_type = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
                if ($content_type === 'application/json') {
                    // Read the raw POST data
                    $json_data = file_get_contents("php://input");
                    // Attempt to decode the JSON data
                    $decoded_data = json_decode($json_data);

                    if ($decoded_data !== null) {
                        $email = strip_tags(trim(filter_var($decoded_data->{'email'}, FILTER_VALIDATE_EMAIL)));
                        $password = strip_tags(trim(filter_var($decoded_data->{'password'}, FILTER_SANITIZE_STRING)));
                        $getinfo = $this->_fetching_sql_model_data->LoginAuth($email, $password);
                        if ($getinfo == false) {
                            $response['message']='Invalid credentials provided..!';
                            http_response_code(400);
                        }else{
                            $id= $getinfo->user_id;
                            $useremail= $getinfo->email;
                            // if successfully login 
                            $authClass= new jwtUtil();
                            $getJwtToken = $authClass::createTokenByUserDetails($id, $useremail);
                            $secret_token= json_decode($getJwtToken)->token;
                            http_response_code(200);
                            $response['token'] = $secret_token;
                        }
                    }else {
                        // JSON decoding failed
                        http_response_code(400); // Bad Request
                        $response['message']= "Invalid JSON format.";
                    }
                }else {
                    // Content-Type is not application/json
                    http_response_code(415); // Unsupported Media Type
                    $response['message']= "Unsupported Media Type. Expected application/json.";
                }
            }else{
                http_response_code(405); 
                $response['message']= "This Method Is Not Allowed";
            }
            echo json_encode($response);
        }
    }

    public function updateUser() {
        // Process API request to update user record based on $userId
        if ($this->isValidUserToken()) {
        // Check if the request method is POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
                $url=implode('',$_REQUEST);
                $urlParts = explode('/', $url);
                if (!isset($urlParts[2]) || empty($urlParts[2])){
                    $response['responses']=
                    [
                        'error'=>"Invalid URL Request.! Expecting a user id as a parameter.",
                        'link_example'=> 'http://localhost/kyc/APIController/updateUser/102'
                    ];
                }else if(is_numeric($urlParts[2])==false){
                    $response['error']='Invalid ID Sent. Id must be integer.';
                }else{
                    // Set Controller ? 
                    $getid= (((!empty($urlParts[2])) ? $urlParts[2] : ''));
                    
                    $id=  strip_tags(trim((filter_var($getid, FILTER_SANITIZE_NUMBER_INT))));
                    // Check if the Content-Type header is set and is application/json
                    $content_type = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
                    if ($content_type === 'application/json') {
                        // Read the raw POST data
                        $json_data = file_get_contents("php://input");
                        // Attempt to decode the JSON data
                        $decoded_data = json_decode($json_data);

                        if ($decoded_data !== null) {
                            // The request is in JSON format
                            $name =  $decoded_data->{'name'};
                            $mobile =  $decoded_data->{'mobile'}; 
                            $email =  $decoded_data->{'email'}; 
                            $dob =  $decoded_data->{'dateofbirth'}; 
                            $ads =  $decoded_data->{'address'}; 
                        
                            if ($name == "") {
                                $response['message']="The name field is required.";
                                http_response_code(400);
                            }
                            if ($mobile == "") {
                                $response['message']="The mobile field is required.";
                                http_response_code(400);
                            }
                            if ($email == "") {
                                $response['message']="The email field is required.";
                                http_response_code(400);
                            }
                            if ($dob == "") {
                                $response['message']="The date of birth field is required.";
                                http_response_code(400);
                            }
                            if ($ads == "") {
                                $response['message']="The address field is required.";
                                http_response_code(400);
                            }
                            elseif (!empty($id) && !empty($name) && !empty($email) && !empty($ads) && !empty($dob) && !empty($mobile)) {
                                $email = trim(filter_var($email, FILTER_VALIDATE_EMAIL));
                                if ($email) {
                                    if($this->_fetching_sql_model_data->updateuserdetailsmodel($id, $name, $email, $mobile, $dob, $ads)){
                                        http_response_code(200);
                                        $response['message']= 'Successfully Updated.';
                                    }else {
                                        http_response_code(203);
                                        $response['message']="ID does not match any user in our database..";
                                    }
                                }else{
                                    http_response_code(400); // Bad Request
                                    $response['message']= "Invalid email format.";
                                }
                            }
                        }else {
                            // JSON decoding failed
                            http_response_code(400); // Bad Request
                            $response['message']= "Invalid JSON format.";
                        }
                    }else {
                        // Content-Type is not application/json
                        http_response_code(415); // Unsupported Media Type
                        $response['message']= "Unsupported Media Type. Expected application/json.";
                    }
                }
            }else{
                http_response_code(405); 
                $response['message']= "This Method Is Not Allowed";
            }
            echo json_encode($response);
        }
    }

    public function deleteUser() {
        if ($this->isValidUserToken()) {
            // Process API request to delete user record based on post id
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == 'DELETE') {
                // Check if the Content-Type header is set and is application/json
                $content_type = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
                if ($content_type === 'application/json') {
                    // Read the raw POST data
                    $json_data = file_get_contents("php://input");
                    // Attempt to decode the JSON data
                    $decoded_data = json_decode($json_data);

                    if ($decoded_data !== null) {
                        // The request is in JSON format
                        $_postid=$decoded_data->{'id'};
                        if(is_numeric($_postid)==false){
                            $data['message']='Invalid ID Sent.! ID must be Integer.';
                            http_response_code(400);
                        }
                        /**
                         * first condition : check the format in which user make delete request
                         * Example in json format {"id":"1,2,3,4,5"}
                         * 
                         * seond condition: checking if user id is array 
                         * Example of user id in array in json format {"id":["1","2","3"]} 
                         * 
                         * third condition: if user id is not both condition
                         * 
                         * {"id":"10"}  // if user id is not in array format OR not seperated with comma then this third condition match
                         * 
                         * NOTE: the reason we cast user id into array is because we can use this endpoint to perform multiple or single delete of users and same time just as long users id are in array
                         */
                        if (is_array($_postid)) {
                            $id = $_postid;
                        }elseif (str_replace(['[', ']'], '', $_postid)) {
                            $cleanedInput = str_replace(['[', ']'], '', $_postid);
                            $elements = explode(',', $cleanedInput);

                            $id = array_map(function($element) {
                                return $element;
                            }, $elements);
                        }else {
                            // if user id is not array format then push to array
                            $id[] = $_postid;
                        }
                        if($this->_fetching_sql_model_data->deleteUser($id)){
                            $response['status'] = 200;
                            $response['message']= 'Successfully deleted.';
                        }else{
                            http_response_code(203);
                            $response['message']="ID does not match any user in our database..";
                        }
                    } else {
                        // JSON decoding failed
                        http_response_code(400); // Bad Request
                        $response['message']= "Invalid JSON format.";
                    }

                } else {
                    // Content-Type is not application/json
                    http_response_code(415); // Unsupported Media Type
                    $response['message']= "Unsupported Media Type. Expected application/json.";
                }
                ob_end_clean();
            }else{
                http_response_code(405);
                $response['message']='Method Not Allowed, Only DELETE requests are allowed.';
            }
            echo json_encode($response);
        }
    }
    

    public function isValidUserToken(){
        $initial_errorhanler_class= new errorHandler();
        if(!$initial_errorhanler_class->validata_api_request_header()){
            $response['message'] = $initial_errorhanler_class->error_log_auth();
        }else{
            if (isset($_SERVER['HTTP_AUTHORIZATION']) || !empty($_SERVER['HTTP_AUTHORIZATION'])) {
               try {
                    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];

                    $jwt_post = str_replace('Bearer ', '', $authHeader);
                    
                    $decoded = JWT::decode($jwt_post, new Key($this->jwtKey, 'HS256'));
                    $email = $decoded->email;
                    $id = $decoded->id;
                    
                    if ($this->_fetching_sql_model_data->isVerifyUser($id, $email)) {
                        return true;
                    }else {
                        $response['message'] = $initial_errorhanler_class->error_log_auth();
                    }
                } catch (\Exception $e) {
                    // Handle token verification failure, e.g., unauthorized access
                    $response['message']=[
                        'error'=>'Unauthorized access',
                        'details'=>'Token has expired.'
                    ];
                    http_response_code(401);
                }
            }else {
                $response['message'] = $initial_errorhanler_class->error_log_auth();
            }
           echo json_encode($response);
        }
    }


}
