<?php

namespace fat\crypt;

use \Exception;

/**
 * Crypt class
 *
 *
 */
class Crypt
{
    public $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * 对密文进行解密
     * @param string $aesCipher 需要解密的密文
     * @param string $aesIV 解密的初始向量
     * @return array 解密得到的明文
     */
    public function decrypt($aesCipher, $aesIV)
    {
        try {

            $decrypted = openssl_decrypt($aesCipher, 'aes-128-cbc', $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $aesIV);
            $decrypted = rtrim($decrypted);

        } catch (Exception $e) {
            return [WxErrorCode::$IllegalBuffer, null];
        }

        try {
            //去除补位字符
            $pkc_encoder = new Pkcs7Encoder;
            $result = $pkc_encoder->decode($decrypted);

        } catch (Exception $e) {
            return [WxErrorCode::$IllegalBuffer, null];
        }
        return array(0, $result);
    }
}
