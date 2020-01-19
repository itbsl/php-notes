<?php

/**
 * 身份证号验证类
 * Class IdentityCard
 */
class IdentityCard
{
    /**
     * 校验身份证号是否合法
     * @param string $num 待校验的身份证号
     * @return bool
     */
    public static function isValid($num)
    {
        //老身份证长度15位，新身份证长度18位
        $length = strlen($num);
        if ($length == 15) { //如果是15位身份证

            //15位身份证没有字母
            if (!is_numeric($num)) {
                return false;
            }
            // 省市县（6位）
            $areaNum = substr($num, 0, 6);
            // 出生年月（6位）
            $dateNum = substr($num, 6, 6);

        } else if ($length == 18) { //如果是18位身份证

            //基本格式校验
            if (!preg_match('/^\d{17}[0-9xX]$/', $num)) {
                return false;
            }
            // 省市县（6位）
            $areaNum = substr($num, 0, 6);
            // 出生年月日（8位）
            $dateNum = substr($num, 6, 8);

        } else { //假身份证
            return false;
        }

        //验证地区
        if (!self::isAreaCodeValid($areaNum)) {
            return false;
        }

        //验证日期
        if (!self::isDateValid($dateNum)) {
            return false;
        }

        //验证最后一位
        if (!self::isVerifyCodeValid($num)) {
            return false;
        }

        return true;
    }

    /**
     * 省市自治区校验
     * @param string $area 省、直辖市代码
     * @return bool
     */
    private static function isAreaCodeValid($area) {
        $provinceCode = substr($area, 0, 2);

        // 根据GB/T2260—999，省市代码11到65
        if (11 <= $provinceCode && $provinceCode <= 65) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 验证出生日期合法性
     * @param string $date 日期
     * @return bool
     */
    private static function isDateValid($date) {
        if (strlen($date) == 6) { //15位身份证号没有年份，这里拼上年份
            $date = '19'.$date;
        }
        $year  = intval(substr($date, 0, 4));
        $month = intval(substr($date, 4, 2));
        $day   = intval(substr($date, 6, 2));

        //日期基本格式校验
        if (!checkdate($month, $day, $year)) {
            return false;
        }

        //日期格式正确，但是逻辑存在问题(如:年份大于当前年)
        $currYear = date('Y');
        if ($year > $currYear) {
            return false;
        }
        return true;
    }

    /**
     * 验证18位身份证最后一位
     * @param string $num 待校验的身份证号
     * @return bool
     */
    private static function isVerifyCodeValid($num)
    {
        if (strlen($num) == 18) {
            $factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
            $tokens = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];

            $checkSum = 0;
            for ($i = 0; $i < 17; $i++) {
                $checkSum += intval($num{$i}) * $factor[$i];
            }

            $mod   = $checkSum % 11;
            $token = $tokens[$mod];

            $lastChar = strtoupper($num{17});

            if ($lastChar != $token) {
                return false;
            }
        }
        return true;
    }

    /**
     * 根据身份证号获取性别
     * @param string $idCard 身份证号
     * @return string|null
     */
    public static function getSex($idCard)
    {
        if (empty($idCard)|| !self::isValid($idCard)) {
            return null;
        }
        $cardLength = strlen($idCard);
        if ($cardLength == 18) {
            $sexInt = intval(substr($idCard, 16, 1));
        } else {
            $sexInt = intval(substr($idCard, 14, 1));
        }

        return $sexInt % 2 === 0 ? '女' : '男';
    }

    /**
     * 根据身份证号获取出生日期
     * @param string $idCard 身份证号
     * @return string|null
     */
    public static function getBirthday($idCard)
    {
        if (empty($idCard) || !self::isValid($idCard)) {
            return null;
        }
        $cardLength = strlen($idCard);
        if ($cardLength == 18) {
            $year = substr($idCard, 6, 4);
            $month = substr($idCard, 10, 2);
            $day = substr($idCard, 12, 2);
        } else {
            $year = '19' . substr($idCard, 6, 2);
            $month = substr($idCard, 8, 2);
            $day = substr($idCard, 10, 2);
        }

        return $year . '-' . $month . '-' . $day;
    }

    /**
     * 根据身份证号获取年龄
     * @param string $idCard
     * @return float|int|null
     */
    public static function getAge($idCard)
    {
        //获取出生日期
        if (!($dateTime = self::getBirthday($idCard))) {
            return null;
        }

        $birthTimeStamp = strtotime($dateTime);  //出生日期时间戳
        $nowTimeStamp   = time();  //当前日期时间戳
        $diff = floor((($nowTimeStamp - $birthTimeStamp) / 86400) / 365);
        return strtotime($dateTime . '+' . $diff . 'years') > $nowTimeStamp ? $diff + 1 : $diff;
    }
}

$card = '411521199605175317';
var_dump(IdentityCard::isValid($card));