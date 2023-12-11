<?php

namespace session\auth;

use \SecurityFilterChainBlock\UrlFilterChain;
 
class session{
    public static function auth_check():bool{
        if (isset($_SESSION['username']) && isset($_SESSION['UserId']) && isset($_SESSION['UserEmail'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function close_session():bool{
        unset($_SESSION['UserEmail']);
        unset($_SESSION['UserId']);
        unset($_SESSION['username']);
        unset($_SESSION['UserJwtAuth']);
        if (isset($_SESSION['UserId']) && isset($_SESSION['username']) && isset($_SESSION['UserEmail'])) {
            return false;
        }else{
            return true;
        }
    }

    public function refreshToken(){
        $protected_url_verification = new UrlFilterChain();
        $check_authorization_access = $protected_url_verification->protectedChainblock();
        if ($check_authorization_access['data']['status'] == 202 || $check_authorization_access['data']['status'] == 205) {
            http_response_code(200);
            header('HTTP/1.1 200 OK');
            $response['responses']=
            [
                'status'=> 200,
                'token'=>$check_authorization_access['data']['token']
            ];
            return($response);
        }else {
            header('HTTP/1.1 401 Unauthorized');
            http_response_code(401);
        }
    }

}