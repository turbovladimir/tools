<?php
namespace Tools;

class Cryptor
{
    const CIPHER_METHOD = 'aes-128-ctr';

    /**
     * @param string $string
     * @param string $salt
     * @return string
     */
    public function encrypt(string $string, string $salt) : string {
        $encIv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::CIPHER_METHOD));

        return openssl_encrypt($string, self::CIPHER_METHOD, $salt, 0, $encIv). "::" . bin2hex($encIv);
    }

    /**
     * @param string $string
     * @param $salt
     * @return string
     */
    public function decrypt(string $string, $salt) : string {
        if (!strpos($string, '::')) {
            throw new \InvalidArgumentException('Are you sure what this row was encrypt early?');
        }

        list($cryptedToken, $encIv) = explode("::",$string);

        return openssl_decrypt($cryptedToken, self::CIPHER_METHOD, $salt, 0, hex2bin($encIv));
    }

}