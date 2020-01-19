<?php

/**
 * 验证邮箱格式
 * @param string $email
 * @return bool
 */
function isEmailValid($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

//实例
$mail = '111111@gmail.com';
var_dump(isEmailValid($mail));
