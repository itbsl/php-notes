<?php

class AES
{
    /**
     * @var string 秘钥(16字节)
     */
    private $key = '';

    /**
     * @var string 初始化向量(16字节)
     */
    private $iv  = '';

    /**
     * AES constructor.
     * @param $key string 秘钥
     * @param $iv string 初始化向量
     */
    public function __construct($key, $iv)
    {
        $this->key = $key;
        $this->iv  = $iv;
    }

    /**
     * 加密(AES-128-CBC)
     * @param string $plaintext
     * @return false|string
     */
    public function encrypt($plaintext = '')
    {
        $data = openssl_encrypt($plaintext, 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);
        $data = base64_encode($data);

        return $data;
    }

    /**
     * 解密(AES-128-CBC)
     * @param string $ciphertext
     * @return false|string
     */
    public function decrypt($ciphertext = '')
    {
        //将空格(' ')替换成加号(+)为了防止通过url传递时自动将base64_encode后的字符串里的加号转成了空格
        $ciphertext = str_replace(' ', '+', $ciphertext);
        $plaintext  = openssl_decrypt(base64_decode($ciphertext), 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);
        return $plaintext;
    }
}


$key = '1234567890123456'; //16位秘钥
$iv  = 'qwertyuiopasdfgh';//16位初始化向量
$plaintext = 'name=itbsl&age=25';
$aesObj = new AES($key, $iv);
$ciphertext = $aesObj->encrypt($plaintext);
$plaintext  = $aesObj->decrypt($ciphertext);
echo $plaintext;
