<?php

namespace App\Helper;


use App\Exceptions\ApiException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Util
{
    /**
     * 时间格式转化为YYYY-mm-dd HH:ii:ss的格式
     * @param unknown $value
     * @return string|unknown
     */
    public static function formatDatetime($value)
    {
        if (empty($value) || $value == '0000-00-00 00:00:00') {
            return '';
        }

        //如果参数是纯数字
        if (!preg_match('/[^0-9]/', $value)) {
            $value = date('Y-m-d H:i:s', $value);
            if (empty($value)) {
                return '';
            }
        }

        return $value;
    }

    /**
     * @param array $header
     * [
     *  "name" => "姓名",
     *  "age" => "年龄",
     * ]
     * @param array $data
     * [
     *  [
     *     "name" => "张三",
     *     "age" => 18,
     *  ],
     *  [
     *     "name" => "李四",
     *     "age" => 19,
     *  ],
     * ]
     * @param string $name
     */
    public static function export($header, $data = [], $name = '报表', $callback = null, $echo = false)
    {
        //输出内容
        $content = [];

        //输出头
        if (!$echo) {
            $content[] = implode(',', array_values($header));
        }

        if (empty($data)) {
            return;
        }

        //输出内容
        foreach ($data as $r) {
            if (is_callable($callback)) {
                $r = call_user_func($callback, $r);
            }

            $row = [];
            foreach ($header as $key => $value) {
                if (isset($r[$key])) {
                    $word  = str_replace(',', '，', $r[$key]);
                    $row[] = $word;
                } else {
                    $row[] = '';
                }
            }
            $content[] = implode(',', $row);
        }
        $content = iconv('utf-8', 'gbk//TRANSLIT', implode("\n", $content));

        if (!$echo) {
            header('Content-Type:text/csv', true);
            header('Content-Disposition:attachment;filename=' . $name . '.csv', true);
            header('Cache-Control:must-revalidate,post-check=0,pre-check=0', true);
            header('Expires:0', true);
            header('Pragma:public', true);
        }
        echo $content;
    }

    /**
     * 获取微妙
     * @return int
     */
    public static function getMillisecond()
    {
        list($s1, $s2) = explode(' ', microtime());
        return (int)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }


    /**
     * 覆盖数租的key,别名代替
     *
     * @param $list
     * @param $options array eg:['id' => 'value', 'name' => 'label']
     * @return mixed
     */
    public static function coverArrKeys($list, $options)
    {
        if (!is_array($list) || !is_array($options) || !$list || !$options) {
            return $list;
        }
        foreach ($list as $k => $val) {
            if (is_array($val)) {
                $list[$k] = self::coverArrKeys($val, $options);
            } else {
                if (isset($options[$k])) {
                    unset($list[$k]);
                    $list[$options[$k]] = $val;
                }
            }
        }
        return $list;
    }

    /**
     * 移除数组中值为空的 key
     *
     *
     * @param $list
     * @param $options
     * @return array
     */
    public static function removeArrEmptyKeys($list, $options)
    {
        if (!is_array($list) || !is_array($options) || !$list || !$options) {
            return $list;
        }
        foreach ($list as $k => $val) {
            if (empty($val) && $val !== 0 && in_array($k, $options)) {
                unset($list[$k]);
            }
            if (is_array($val) && $val) {
                $list[$k] = self::removeArrEmptyKeys($val, $options);
            }
        }
        return $list;
    }


    /**用户密码加密
     *
     *
     * @param $pwd
     * @return bool|string
     */
    public static function userPwdEncode($pwd)
    {
        $r = password_hash($pwd, PASSWORD_DEFAULT);
        if (strlen(strval($r)) < 10) {
            throw new ApiException('密码生成失败');
        }
        return $r;
    }

    /**
     * 密码验证
     *
     * @param $string
     * @param $pwd
     * @return bool
     */
    public static function userPwdVerify($string, $pwd)
    {
        return password_verify($string, $pwd);
    }

    /**客户端传递密码时候 先来个加密
     *
     * @param $pwd
     * @return string
     */
    public static function clientEncodePwd($pwd)
    {
        return md5($pwd);
    }

    /**
     * @param $value
     * @return string|string[]|null
     */
    public static function formatMobile($value)
    {
        return preg_replace("/(\d{3})\d{4}(.*)/", "$1****$2", $value);
    }

    public static function formatIdcard($value)
    {
        return preg_replace("/(\d{10})\d{4}(.*)/", "$1****$2", $value);
    }

    public static function formatBankcard($value)
    {
        return preg_replace("/(.*)\d{4}/", "$1****", $value);
    }

    public static function formatVin($value)
    {
        return preg_replace("/(\w{5})\w{4}(.*)/", "$1****$2", $value);
    }

    /**
     * 检测手机号
     * @param string $mobile
     * @return bool
     */
    public static function checkMobile($mobile = '')
    {
        if (preg_match("/^1\d{10}$/", $mobile)) {
            return true;
        }

        return false;
    }

    /**
     * 随机数生成
     * @param int $length
     * @return int
     */
    public static function generateCode($length = 6)
    {
        $min = pow(10, ($length - 1));
        $max = pow(10, $length) - 1;

        return rand($min, $max);
    }

    /**
     * 生成APP别名
     * @param $mobile
     * @param string $app
     * @return string
     */
    public static function appPushAlias($mobile, $app = 'ycs')
    {
        $env   = config('app.env');
        $alias = $app . '_' . $env . '_' . $mobile;
        return $alias;
    }


}
