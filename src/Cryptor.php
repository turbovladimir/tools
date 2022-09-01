<?php
namespace Tools;

class Cryptor
{
    const CIPHER_METHOD = 'aes-128-ctr';

    private $salt;

    public function __construct(?string $salt = null) 
    {
        $this->salt = $salt;
    }
    
    public function encrypt(string $string, ?string $salt = null) : string {
        $encIv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::CIPHER_METHOD));
        $salt = $salt ?? $this->salt;
        
        if (!$salt) {
            throw new \RuntimeException('Cannot fetch salt...Operation fail!');
        }
        
        return openssl_encrypt($string, self::CIPHER_METHOD, $salt, 0, $encIv). "::" . bin2hex($encIv);
    }
    
    public function decrypt(string $string, ?string $salt = null) : string {
        if (!strpos($string, '::')) {
            throw new \InvalidArgumentException('Are you sure what this row was encrypt early?');
        }

        $salt = $salt ?? $this->salt;

        if (!$salt) {
            throw new \RuntimeException('Cannot fetch salt...Operation fail!');
        }

        list($cryptedToken, $encIv) = explode("::",$string);

        return openssl_decrypt($cryptedToken, self::CIPHER_METHOD, $salt, 0, hex2bin($encIv));
    }

}
