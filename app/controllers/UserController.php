<?php

use helpers\auth\errorhandlers\errorHandler;
use session\auth\session;

final class UserController extends Controller
{
    private $_sql_model_data;

    public function __construct() {
       @$this->_sql_model_data = @$this->loadModel('User');
    }

    public function updateUser() {
        // Process edit form submission and update user record
        $response = [];
        $initial_errorhanler_class= new errorHandler();
        if(!$initial_errorhanler_class->validata_api_request_header()){
            $response['message'] = $initial_errorhanler_class->error_log_auth();
        }else{
            $authClass= new session();
            $authenticateUser = $authClass->auth_check();
            if (!$authenticateUser) {
                $response['message'] = $initial_errorhanler_class->error_log_auth();
            }else{
                ob_start();
                $jsonString = file_get_contents("php://input");
                $response = array();
                $PostObject = json_decode($jsonString);
                $id=strip_tags(trim(filter_var($PostObject->{'id'}, FILTER_SANITIZE_STRING)));
                $name=strip_tags(trim(filter_var($PostObject->{'name'}, FILTER_SANITIZE_STRING)));
                $email=strip_tags(trim(filter_var($PostObject->{'email'}, FILTER_VALIDATE_EMAIL)));
                $mobile=strip_tags(trim(filter_var($PostObject->{'mobile'}, FILTER_SANITIZE_STRING)));
                $dob=strip_tags(trim(filter_var($PostObject->{'dob'}, FILTER_SANITIZE_STRING)));
                $ads=strip_tags(trim(filter_var($PostObject->{'address'}, FILTER_SANITIZE_STRING)));
                $newjson = json_encode($PostObject);
                if(empty($id) || empty($name) || empty($email) || empty($mobile) || empty($dob) || empty($ads)){
                    $response['message'] ='Please fill all field.!';
                    $response['status'] = 412;
                    http_response_code(412);
                }else {
                    if($this->_sql_model_data->updateuserdetailsmodel($id, $name, $email, $mobile, $dob, $ads)){
                        http_response_code(200);
                        $response['status'] = 200;
                        $response['message']= 'Successfully Updated.';
                    }
                }
                
            ob_end_clean();
            }
        }
        echo json_encode($response);
    }

    public function deleteUser() {
        // Delete user record based on $userId
        $response = [];
        $initial_errorhanler_class= new errorHandler();
        if(!$initial_errorhanler_class->validata_api_request_header()){
            $response['message'] = $initial_errorhanler_class->error_log_auth();
        }else{
            $authClass= new session();
            $authenticateUser = $authClass->auth_check();
            if (!$authenticateUser) {
                $response['message'] = $initial_errorhanler_class->error_log_auth();
            }else{
                ob_start();
                $jsonString = file_get_contents("php://input");
                $response = array();
                $phpObject = json_decode($jsonString);
                $getData=$phpObject->{'DataId'};
                $newJsonString = json_encode($phpObject);
                $id = $getData;
                //Return json message to the GUI
                if($this->_sql_model_data->deleteUser($id)){
                    $response['status'] = 200;
                    $response['message']= 'Successfully deleted.';
                }else{
                    http_response_code(203);
                    $response['message']="ID does not match any user in our database..";
                }
                ob_end_clean();
            }
        }
        echo json_encode($response);
    }

    public function changepass(){
        $response = [];
        $initial_errorhanler_class= new errorHandler();
        if(!$initial_errorhanler_class->validata_api_request_header()){
            $response['message'] = $initial_errorhanler_class->error_log_auth();
        }else{
            $authClass= new session();
            $authenticateUser = $authClass->auth_check();
            if (!$authenticateUser) {
                $response['message'] = $initial_errorhanler_class->error_log_auth();
            }else{
                 ob_start();
                $jsonString = file_get_contents("php://input");
                $response = array();
                $phpObject = json_decode($jsonString);
                
                $id =  $phpObject->{'id'};
                $old =  $phpObject->{'old'}; 
                $new =  $phpObject->{'new'}; 
                $confirmpassword =  $phpObject->{'confirmpassword'}; 
                if ($id == "") {
                $response['message']="The  field is required.";
                $response['status1'] = false;
                }
                if ($old == "") {
                $response['message']="The  field is required.";
                $response['status2'] = false;
                }
                if ($new == "") {
                $response['message']="The  field is required.";
                $response['status3'] = false;
                }
                if ($confirmpassword == "") {
                $response['message']="The  field is required.";
                $response['status4'] = false;
                }elseif (!empty($id) && !empty($old) && !empty($new) && !empty($confirmpassword)) {
                    if ($new !== $confirmpassword){
                        $response['message']="New Password does not match with Comfirm Password..! Please Check";
                        $response['status4'] = false;
                    }else {
                        // Hash the new password
                        $new = password_hash($new, PASSWORD_ARGON2ID);
                        // now check if old password match 
                        $data = [
                            'id'=>$id,
                            'old'=>$old,
                            'new'=>$new
                        ];
                        if ($this->_sql_model_data->changepasswordmodel($data)) {
                            $response['message']= "Password Successfully Changed..!";
                            $response['status'] = true;
                        }else {
                        $response['message']="Sorry.. Old password Does not match our Data.";
                            $response['status2'] = false;
                        }
                    }
                }
                ob_end_clean();
                echo json_encode($response);
            }
        }
    }
}
