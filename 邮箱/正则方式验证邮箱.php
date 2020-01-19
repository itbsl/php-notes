<?php

/**
 * 验证邮箱格式
 * @param string $email
 * @return bool
 */
function isEmailValid($email)
{
    $pattern = "/([\w\-]+\@[\w\-]+\.[\w\-]+)/";
    if (preg_match($pattern, $email)) {
        return true;
    } else {
        return false;
    }
}

//实例
$mail = '111111@gmail.com';
var_dump(isEmailValid($mail));