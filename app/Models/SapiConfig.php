<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SapiConfig extends Model
{

    protected $table = 'sapi_config';

    //将数据库中的config_value字段 json自动转换为数组
    public function getConfigValueAttribute($value)
    {
        return is_null(json_decode($value)) ? $value : json_decode($value, 1);
    }

    /**
     * @param $sapi_app_id
     * @param $config_key
     * @param string $version
     * @return string
     * User: lifei
     * Date: 2018-11-27 15:43
     */
    public static function getConfigValue($config_key)
    {
        $config = self::where(['config_key' => $config_key])
            ->first();
        if (!empty($config)) {
            return $config->config_value;
        }
        return '';
    }

    public static function setConfigValue($config_key, $config_value = '')
    {
        if (!$config_key) {
            return false;
        }
        $config = self::where(['config_key' => $config_key])
            ->first();

        if (!empty($config)) {
            $config->config_value = $config_value;
            return $config->save();
        } else {
            //暂时没有自动插入
            //            $config = new SapiConfig;
            //            $config->config_key = $config_key;
            //            $config->config_value = $config_value;
            //            $config->config_des = '';
            //            $config->save();
        }

    }

}
