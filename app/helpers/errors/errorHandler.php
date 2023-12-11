<?php

namespace helpers\auth\errorhandlers;

class errorHandler 
{
    public function validata_api_request_header(){
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: *");
        header("Content-Type: application/json");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        if ($_SERVER['REQUEST_METHOD']=='OPTIONS') {
            header('HTTP/1.1 401 Unauthorized');
            error_log_auth();
        }else{
            return true;
        }
    }


    public function error_log_auth(){
        header('HTTP/1.1 401 Unauthorized');
        $response=
        [ 
            "status"=> http_response_code(401),
            "title"=> "Authentication Error",
            "detail"=> "Something went wrong with authentication.",
            "code"=> "generic_authentication_error"
        ];
        echo json_encode($response);
    }
}

