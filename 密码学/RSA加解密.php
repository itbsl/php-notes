<?php

class RSA
{
    /**
     * 公钥加密
     * @param string $plaintext 明文
     * @param string $publicKey 公钥
     * @return string
     */
    public static function publicKeyEncrypt(string $plaintext, string $publicKey)
    {
        $pub_key = openssl_pkey_get_public($publicKey);
        openssl_public_encrypt($plaintext, $ciphertext, $pub_key);
        $ciphertext = base64_encode($ciphertext);

        return $ciphertext;
    }

    /**
     * 私钥解密
     * @param string $ciphertext 密文
     * @param string $privateKey 私钥
     * @return mixed
     */
    public static function privateKeyDecrypt(string $ciphertext, string $privateKey)
    {
        //将空格(' ')替换成加号(+)为了防止通过url传递时自动将base64_encode后的字符串里的加号转成了空格
        $ciphertext = str_replace(' ', '+', $ciphertext);
        $pri_key = openssl_pkey_get_private($privateKey);
        openssl_private_decrypt(base64_decode($ciphertext), $plaintext, $pri_key);

        return $plaintext;
    }

    /**
     * 私钥加密
     * @param string $plaintext 明文
     * @param string $privateKey 私钥
     * @return string
     */
    public static function privateKeyEncrypt(string $plaintext, string $privateKey)
    {
        $pri_key = openssl_pkey_get_private($privateKey);
        openssl_private_encrypt($plaintext, $ciphertext, $pri_key);
        $ciphertext = base64_encode($ciphertext);

        return $ciphertext;
    }

    /**
     * 公钥解密
     * @param string $ciphertext 密文
     * @param string $publicKey 公钥
     * @return mixed
     */
    public static function publicKeyDecrypt(string $ciphertext, string $publicKey)
    {
        //将空格(' ')替换成加号(+)为了防止通过url传递时自动将base64_encode后的字符串里的加号转成了空格
        $ciphertext = str_replace(' ', '+', $ciphertext);
        $pub_key = openssl_pkey_get_public($publicKey);
        openssl_public_decrypt(base64_decode($ciphertext), $plaintext, $pub_key);

        return $plaintext;
    }

}

$privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
-----END RSA PRIVATE KEY-----
EOD;

$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
ehde/zUxo6UvS7UrBQIDAQAB
-----END PUBLIC KEY-----
EOD;

//公钥加密私钥解密
$plaintext = 'name=itbsl&age=25';
$ciphertext = RSA::publicKeyEncrypt($plaintext, $publicKey);
$plaintext = RSA::privateKeyDecrypt($ciphertext, $privateKey);

//私钥加密公钥解密
$plaintext = 'name=kevin&age=26';
$ciphertext = RSA::privateKeyEncrypt($plaintext, $privateKey);
$plaintext =  RSA::publicKeyDecrypt($ciphertext, $publicKey);
echo $plaintext;
