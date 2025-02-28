<?php
namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken {
    public static function CreateToken($userEmail, $userID, $userRole):string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss'=>'larvel-token',
            'iat'=>time(),
            'exp'=>time()+60*60*24,
            'userEmail'=>$userEmail,
            'userID'=>$userID,
            'userRole'=>$userRole
        ];
        return JWT::encode($payload, $key, 'HS256');
    }
    public static function CreateTokenForPassword($userEmail):string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss'=>'larvel-token',
            'iat'=>time(),
            'exp'=>time()+36*20,
            'userEmail'=>$userEmail,
            'userID'=>'0'
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function VerifyToken($token):string|object
    {
        try {
            if($token==null){
                return 'unauthorized';
            }
            else{
                $key =env('JWT_KEY');
                $decode=JWT::decode($token,new Key($key,'HS256'));
                return $decode;
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }
}

