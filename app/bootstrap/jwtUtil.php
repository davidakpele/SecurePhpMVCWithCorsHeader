<?php

namespace JwtHttp;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;

final class jwtUtil  {
    
    private $jwtKey;
    private $isoArray;

    public function __construct() {
       @$this->isoArray = [];
    }
    public static function createTokenByUserDetails($id, $useremail):string{
        $key = PRIVATE_KEY;
        
        $payload = [
            'email' => $useremail,
            'id' => $id,
            'iat' => time(),            // Issued at: current time
            'exp' => time() + 60, 
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return json_encode(['token' => $jwt]);
    }

    public static function createRefreshTokenByUserDetails($id, $useremail):string{
        $key = PRIVATE_KEY;
        
        $payload = [
            'email' => $useremail,
            'id' => $id,
            'iat' => time(), // Issued at: current time
            'exp' => time() + 60,  //expire jwt token in 60 seconds
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return json_encode(['token' => $jwt]);
    }

    
    public static function isNotValidUserToken():string{
        return false;
    }

}
