<?php
/**
 * Created by YcModelMaker
 * Date: 2019-04-30 11:04:30
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/***propertyStart***/
/**
 * Class Region
 *
 * @package App\Models
 * @property int id 自增主键
 * @property string name 区域名称
 * @property string code 区域编码
 * @property string parent_code 城市编码
 * @property int level 城市等级：1省份，2城市，3区
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region query()
 * @mixin \Eloquent
 * @property int $id 自增主键
 * @property string $name 区域名称
 * @property string $code 区域编码
 * @property string $parent_code 城市编码
 * @property int $level 城市等级：1省份，2城市，3区
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereParentCode($value)
 */
 /***propertyEnd***/

class Region extends Model
{
    protected $table = 'region';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
