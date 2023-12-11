<?php
namespace Http;
use Auth\{authentication};
use JwtHttp\{jwtUtil};

class sanctum
{
   
    public function collections(){
        $authClass= new jwtUtil;
        $initiate_new_authentication_token = new authentication();
        $getTokenRefresh = $initiate_new_authentication_token->refreshToken();
        return $getTokenRefresh;
    }
}
