<?php
    declare(strict_types=1);

    require_once APPPATH . '/libraries/php-jwt-master/src/autoload.php';

    use \Firebase\JWT\JWT;

    class Jwt_helper
    {

        public static function encode(array $payLoadArray): string
        {
            $payLoadString = JWT::encode($payLoadArray, JWT_KEY);

            return $payLoadString;
        }

        public static function encodeNewValue(string $key, $value, string $payLoadString): string
        {   
            $payLoadArray = $payLoadString ? self::decode($payLoadString) : [];
            $payLoadArray[$key] = $value;
            $payLoadString = JWT::encode($payLoadArray, JWT_KEY);

            return $payLoadString;
        }

        public static function decode(string $jwt): object
        {
            $decoded = JWT::decode($jwt, JWT_KEY, array('HS256'));
            if (empty($decoded)) return [];
            return $decoded;
        }

        public static function getStringFromArray(array $jwtArray): string
        {
            return JWT::encode($jwtArray, JWT_KEY);
        }
    }
