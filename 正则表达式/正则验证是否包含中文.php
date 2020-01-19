<?php

/**
 * 是否包含中文
 * @param string $str
 * @return bool
 */
function isChineseIncluded($str)
{
    //中文字符的表示范围[\x{4e00}-\x{9fa5}],模式修正符还要加上小写的u,表示用utf-8编码解析
    $pattern = '/[\x{4e00}-\x{9fa5}]/u';
    if (preg_match($pattern, $str)) {
        return true;
    } else {
        return false;
    }
}

var_dump(isChineseIncluded("中国"));
