<?php
/**
 * 自定义的公共函数
 * @author   sam.shan  <sam.shan@ruis-ims.cn>
 * @time     2017年09月14日10:14:51
 * @todo    当使用第三方函数库的时候,请务必将第三方函数库至于不同的命名空间下
 *
 */

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


/**
 * print_r的调试输出,不停止继续执行
 * @return void
 * @author sam.shan <sam.shan@ruis-ims.cn>
 */
function p()
{
    $arr = func_get_args();
    foreach ($arr as $_arr) {
        echo "<pre>";
        print_r($_arr);
        echo "</pre>";
    }
}


/**
 * print_r的调试输出,停止程序继续执行
 * @return void
 * @author sam.shan <sam.shan@ruis-ims.cn>
 */
function pd()
{
    $arr = func_get_args();
    foreach ($arr as $_arr) {
        echo "<pre>";
        print_r($_arr);
        echo "</pre>";
    }
    die(1);
}


/**
 * var_dump的调试输出,不停止程序继续执行
 * @return void
 * @author sam.shan <sam.shan@ruis-ims.cn>
 */
function d()
{
    $arr = func_get_args();
    foreach ($arr as $_arr) {
        echo "<pre>";
        var_dump($_arr);
        echo "</pre>";
    }
}


/**
 * 常量输出调试函数  返回所有常量的关联数组，键是常量名，值是常量值
 * @param string $key 指明要获取具体的常量组
 * @return  void
 * @author  sam.shan <sam.shan@ruis-ims.cn>
 *
 */
function pc($key = NULL)
{
    $const = get_defined_constants(true);
    if ($key && isset($const[$key])) $const = $const[$key];
    echo '<pre>';
    print_r($const);
    echo '</pre>';
}


/**
 * 封装PHP内核抛出异常的全局函数
 * @param $message  string   异常消息内容
 * @param $code     string   异常代码
 * @throws Exception
 * @author        sam.shan  <sam.shan@ruis-ims.cn>
 */
function TE($message, $code = 0)
{
    throw new \Exception($message, $code);
}

/**
 * 封装抛出API异常的全局函数
 * 注意,则方法故意将底层参数颠倒
 * @param $code     int      异常代码,通过该代码可以找到对应的message
 * @param $field  string     异常的参数名称,可以不传递
 * @throws \App\Exceptions\ApiException
 * @author        sam.shan  <sam.shan@ruis-ims.cn>
 */

function TEA($code, $field = '')
{
    throw new \App\Exceptions\ApiException($field, $code);
}


/**
 * 自定义异常传入自己想返回的动态信息
 * @param string $message
 * @throws \App\Exceptions\ApiParamException
 */
function TEPA($message = '')
{
    throw new \App\Exceptions\ApiParamException($message);
}


/**
 * @param int $code
 * @param string $field
 * @param string|null $value
 * @return array
 * @author  sam.shan  <sam.shan@ruis-ims.cn>
 * update by xin.min 20180416:
 * update content: add parameter $value=null; if $value!=null  return $response['value']=$value;
 */
function get_api_response($code, $field = '', $value = null)
{
    //初始化返回值
    $response = ['code' => $code];
    //添加field值
    if (!empty($field)) $response['field'] = $field;
    $response['message'] = $field;
    return $response;
}


/**
 * 参数异常返回方法
 * @param string $message
 * @return array
 */
function get_api_exception_response($message = '')
{
    $response = [];
    $response['code'] = 0;
    $response['message'] = !empty($message) ? $message : "未知异常";
    return $response;
}

/**
 * 是get_api_response的特殊封装,仅仅针对成功的返回
 * @param $results
 * @param $paging
 * @return array
 * $author sam.shan   <sam.shan@ruis-ims.cn>
 */
function get_success_api_response($results = [], $paging = NULL)
{
    $response = ['code' => '200', 'message' => 'OK', 'results' => $results];
    if ($paging) $response['paging'] = $paging;
    return $response;

}


/**
 * 兼容中文的截取字符方法
 * @param $text    string  待截取的字符本身,比如某个事物的描述信息
 * @param $length  int    截取的长度
 * @return string
 * @author   sam.shan   <sam.shan@ruis-ims.cn>
 */
function subtext($text, $length)
{
    if (mb_strlen($text, 'utf8') > $length)
        return mb_substr($text, 0, $length, 'utf8') . '...';
    else
        return $text;
}


/**
 * 判断某个字符串是否是json格式
 * @param $string
 * @return bool
 * @author  sam.shan   <sam.shan@ruis-ims.cn>
 */
function is_json($string)
{
    try {
        json_decode($string);
    } catch (\Exception $e) {
        return false;
    }
    return true;
}


/**
 * 去除左右空格符号
 * @param $input
 * @return void
 * @author  sam.shan  <sam.shan@ruis-ims.cn>
 */
function trim_strings(&$input)
{
    foreach ($input as $key => &$value) {
        $value = is_string($value) ? trim($value) : $value;
    }
}


/**
 * 将NULL转成空字符
 * @param $input
 * @return void
 * @author  sam.shan  <sam.shan@ruis-ims.cn>
 */
function null2strings(&$input)
{
    foreach ($input as $key => &$value) {
        $value = is_null($value) ? '' : $value;
    }
}


/**
 * 求一维数组的差集以及交集
 * @param array $input_ids 如 [11,12,13,29]
 * @param array $db_ids 如 [11,12,13]
 * @return array
 * @author  sam.shan <sam.shan@ruis-ims.cn>
 */
function get_array_diff_intersect($input_ids, $db_ids)
{
    $add_set = array_diff($input_ids, $db_ids);
    $del_set = array_diff($db_ids, $input_ids);
    $common_set = array_intersect($db_ids, $input_ids);
    return ['add_set' => $add_set, 'del_set' => $del_set, 'common_set' => $common_set];
}


/**
 * 处理祖宗树,返回数组
 * @param string $forefathers 来源于数据库的forefathers字段值
 * @return array
 * @author sam.shan
 */
function filter_forefathers($forefathers)
{
    return array_values(array_filter(explode(',', $forefathers)));
}


/**
 * 产生分布式uuid,我们将-拼接符号去掉就返回32位了,否则返回36位字符
 * @return string
 * @author sam.shan <sam.shan@ruis-ims.cn>
 *
 */
function create_uuid()
{
    $char_id = strtoupper(md5(uniqid(mt_rand(), true)));//3D2056F9538E219E7D83C733BF6FBFEC
    //$hyphen = chr(45);// 这里的值就是 -    chr() 函数从指定的 ASCII 值返回字符。ASCII 值可被指定为十进制值、八进制值或十六进制值。八进制值被定义为带前置 0，而十六进制值被定义为带前置 0x。
    $uuid = substr($char_id, 6, 2)
        . substr($char_id, 4, 2)
        . substr($char_id, 2, 2)
        . substr($char_id, 0, 2)
        //.$hyphen
        . substr($char_id, 10, 2)
        . substr($char_id, 8, 2)
        //.$hyphen
        . substr($char_id, 14, 2)
        . substr($char_id, 12, 2)
        //.$hyphen
        . substr($char_id, 16, 4)
        //.$hyphen
        . substr($char_id, 20, 12);//F956203D-8E53-9E21-7D83-C733BF6FBFEC
    return $uuid;
}


/**
 * 产生随机码
 * @param bool $length
 * @return string
 * @author  sam.shan <sam.shan@ruis-ims.cn>
 */
function make_random_code($length = false)
{

    $length = $length ? $length : 8;
    //注意激活码中不能有很特殊的符号，比如#yYFMAUJ  这个激活码我们用get解析的时候就获取不了，因为#的语言，锚点啊,或者发送的时候激活码做加密处理就好了
    $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = substr(str_shuffle($str), 0, $length);
    return $code;
}

/**
 * 标准对象转换成数组(不支持复杂的对象以及层级深的对象)
 * @param $obj
 * @author  sam.shan  <sam.shan@ruis-ims.cn>
 */
function obj2array($obj)
{
    if (empty($obj)) return [];
    return json_decode(json_encode($obj), true);
}


/**
 * number_format的别名函数
 *
 * @param int|string $number
 *          要格式化的数字
 * @param int $decimals
 *          规定多少个小数
 * @param string $decimalpoint
 *          规定用作小数点的字符串
 * @param string $separator
 *          规定用作千位分隔符的字符串
 * @return string $return
 *         格式化后的数字
 * @author liming
 */
function nf($number = 0, $decimals = 2, $decimalpoint = '.', $separator = '')
{
    return number_format($number, $decimals, $decimalpoint, $separator);
}


/**
 * 去掉小数点后面的0和.
 * @param $number
 * @param int|string $number
 *          要格式化的数字
 * @author liming
 * @return string
 */
function rnf($number, $decimals = 4)
{
    return rtrim(rtrim(nf($number, $decimals), '0'), '.');
}


/**
 * 求两个日期之间相差的天数
 * @param int $day1
 * @param int $day2
 * @return int
 */
function diff_between_twodays($day1, $day2)
{
    if ($day1 < $day2) {
        $tmp = $day2;
        $day2 = $day1;
        $day1 = $tmp;
    }
    return ($day1 - $day2) / 86400;
}


// /**
//  * session公共方法
//  * @param null $key
//  * @param null $default
//  * @return \Laravel\Lumen\Application|mixed
//  * @author  sam.shan  <sam.shan@ruis-ims.cn>
//  */
// function session($key = null, $default = null)
// {
//     $session = app('session');

//     if (is_null($key)) {
//         return $session;
//     }
//     if (is_array($key)) {
//         return $session->put($key);
//     }

//     return $session->get($key, $default);
// }


/**
 * 这里是对明文密码进行加盐md5
 * @param  string $clear_text_password 明文密码
 * @return string                     加密后的密码
 */
function encrypted_password($clear_text_password, $salt = '')
{
    return md5($clear_text_password . $salt);
}


/**
 * 打招呼
 * @return string
 * @author sam.shan <sam.shan@ruis-ims.cn>
 */
function say_hello()
{
    $h = date('H', time());
    if ($h < 6) {
        return '凌晨好';
    } else if ($h < 9) {
        return '早上好';
    } else if ($h < 12) {
        return '上午好';
    } else if ($h < 14) {
        return '中午好';
    } else if ($h < 17) {
        return '下午好';
    } else if ($h < 19) {
        return '傍晚好';
    } else if ($h < 22) {
        return '晚上好';
    } else {
        return '夜里好';
    }

}


/**
 * 判断是否是postman
 * @return bool
 * @author sam.shan <sam.shan@ruis-ims.cn>
 */
function is_postman()
{
    return !empty($_SERVER['HTTP_POSTMAN_TOKEN']) ? TRUE : FALSE;
}

/**
 * 返回数组中对应值的id
 * @param $data
 * @param $value
 * @return int
 */
function get_id($data, $value)
{
    $id = 0;
    foreach ($data as $row) {
        if ($row['name'] == $value) {
            $id = $row['id'];
        }
    }
    return $id;
}


/**检测是否是邮箱
 * @param $email
 * @return bool
 * @TODO  使用php内置的方法也可以  filter_var
 * @author  sam.shan   <sam.shan@ruis-ims.cn>
 *
 */
function check_email_regular($email)
{
    if (!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $email)) return false;
    return true;
}


/**
 * 检测是否是中文名称
 * @param $cn_name
 * @return bool
 * @author  sam.shan  <sam.shan@ruis-ims.cn>
 */
function check_cn_name_regular($cn_name)
{
    if (!preg_match('/^[\x{4e00}-\x{9fa5}]{2,5}$/u', $cn_name)) return false;
    return true;
}


/**
 * 检测是否是手机号
 * @param $mobile
 * @return bool
 * @author  sam.shan  <sam.shan@ruis-ims.cn>
 *
 */
function check_mobile_regular($mobile)
{
    if (!preg_match('/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/', $mobile)) return false;
    return true;
}


/**
 * 检测管理员密码格式是否正确
 * @param $password
 * @param $pattern
 * @return bool
 * @author  sam
 */
function check_admin_password_regular($password, $pattern = NULL)
{
    if (empty($pattern)) $pattern = '/^.{6,18}$/';
    if (!preg_match($pattern, $password)) return false;
    return true;
}


function xmlToArray($xml)
{
    //禁止引用外部xml实体
//    libxml_disable_entity_loader(true);
    $xmlObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    $val = json_decode(json_encode($xmlObj), true);
    return $val;
}


/**
 * 如果$input 不存在或为null，则返回默认值
 *
 * @param array|object $input
 * @param string $index
 * @param string $defaultValue
 * @return string
 */
function get_value_or_default($input, $index, $defaultValue = '')
{
    if (is_array($input) && isset($input[$index])) {
        return $input[$index];
    }

    if (is_object($input) && isset($input->{$index})) {
        return $input->{$index};
    }

    return $defaultValue;
}

/**
 * 统计数组中 某个值出现的次数
 *
 * @param array $arr
 * @param string $value
 * @return int
 */
function array_count_one_value($arr, $value)
{
    $tempArr = array_count_values($arr);
    if (empty($tempArr[$value])) {
        return 0;
    }
    return $tempArr[$value];
}

/**
 * 向上取 n 位小数
 *
 * @example ceil_dot(3.141,2) = 3.15
 * @param float $value
 * @param int $n
 * @return float
 */
function ceil_dot($value, $n = 2)
{
    return ceil($value * pow(10, $n)) / (pow(10, $n));
}

/**
 * xml 特殊字符转义
 *
 * @param $tag
 * @return mixed
 */
function xml_special_character_encode($tag)
{
    $tag = str_replace("&", "&amp;", $tag);
    $tag = str_replace("<", "&lt;", $tag);
    $tag = str_replace(">", "&gt;", $tag);
    $tag = str_replace("'", "&apos;", $tag);
    $tag = str_replace("\"", '&quot;', $tag);
    return $tag;
}

/**
 * 根据code 获取自定义的错误信息
 *
 * @param string $code
 * @return string
 */
function get_error_info_by_code($code)
{
    if (empty($code) || $code < 0 || !is_numeric($code)) {
        return '';
    }

    $odd = $code % 100;
    $interval = $code - $odd;
    $file_name = $interval . '_' . ($interval + 99) . '.php';
    $error_config_path = dirname(__FILE__) . '/../../config/codes/' . $file_name;
    //先判断文件是否存在
    if (!is_file($error_config_path)) {
        return '';
    } else {
        global ${'error_config' . $file_name};
        empty(${'error_config' . $file_name}) && ${'error_config' . $file_name} = include_once($error_config_path);
        return isset(${'error_config' . $file_name}[$code]) ? ${'error_config' . $file_name}[$code] : '';
    }
}

/**
 * 判断当前的运行环境是否是cli模式
 *
 * @return bool
 */
function is_cli()
{
    return preg_match("/cli/i", php_sapi_name()) ? true : false;
}

/**
 * 根据不同环境，获取HTTP_HOST
 *
 * @return mixed|string
 */
function get_host()
{
    if (is_cli()) {
        return config('app.cli_http_host');
    }
    return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
}

/**
 * 进行日志记录，用于debug程序运行
 * 日志路径：/storage/logs/trace/
 * @author  kevin
 */
function trace($data)
{
    $logfile_base_path = __DIR__ . '/../../storage/logs/trace/';
    if(!is_dir($logfile_base_path)){
        mkdir($logfile_base_path,0777, true);
        chmod($logfile_base_path,0777);
    }
    isset($_SERVER['REQUEST_URI']) ? $REQUEST_URI = $_SERVER['REQUEST_URI'] : $REQUEST_URI = '';
    $data =  "\n[" . date('Y-m-d H:i:s') . '] ' .'INTERFACE: '. $REQUEST_URI . '; INFO: ' . var_export($data,true);
    env('APP_DEBUG') && file_put_contents($logfile_base_path.date('Y-m-d').'_trace.log', $data, FILE_APPEND);

}

/**
 * 新封装日志方法（通用）
 * 日志路径：传参filename,默认/default_log
 * @author  hao.li
 */
 function new_log($data,$filename='default_log')
 {
     $logfile_base_path = __DIR__ . '/../../storage/logs/'.$filename.'/';
     if(!is_dir($logfile_base_path)){
         mkdir($logfile_base_path,0777, true);
         chmod($logfile_base_path,0777);
     }
     isset($_SERVER['REQUEST_URI']) ? $REQUEST_URI = $_SERVER['REQUEST_URI'] : $REQUEST_URI = '';
     $data =  "\n[" . date('Y-m-d H:i:s') . '] ' .'INTERFACE: '. $REQUEST_URI . '; INFO: ' . var_export($data,true);
     env('APP_DEBUG') && file_put_contents($logfile_base_path.date('Y-m-d').'_'.$filename.'.log', $data, FILE_APPEND);

 }


/**
 * 按二维数组某个字段进行分组
 * @description:根据数据
 * @param {dataArr:需要分组的数据；keyStr:分组依据}
 * @return:
 */
function dataGroup($dataArr,$keyStr)
{
    $newArr=[];
    foreach ($dataArr as $k => $val) {
        $newArr[$val[$keyStr]][] = $val;
    }
    return $newArr;
}

/**
 * 时间段重合判断
 * @param array $data 日期数组 需转时间戳
 * @param string $fieldStart 开始日期字段名
 * @param string $fieldEnd 结束日期字段名
 * @return bool true为重合，false为不重合
 */
function is_time_cross($data, $fieldStart = 'start_day', $fieldEnd = 'end_day')
{
    // 按开始日期排序
    array_multisort(
        array_column($data, $fieldStart),
        SORT_ASC,
        $data
    );

    // 冒泡判断是否满足时间段重合的条件
    $num = count($data);
    for ($i = 1; $i < $num; $i++) {
        $pre = $data[$i-1];
        $current = $data[$i];
        if ($pre[$fieldStart] <= $current[$fieldEnd] && $current[$fieldStart] <= $pre[$fieldEnd]) {
            return $pre;
        }
    }

    return false;
}

//获取小数位数
function getFloatLength($num) {
    $count = 0;

    $temp = explode ( '.', $num );

    if (sizeof ( $temp ) > 1) {
        $decimal = end ( $temp );
        $count = strlen ( $decimal );
    }

    return $count;
}

/**
 * 简单字段验证
 *
 * @param $input
 * @param array $field ['name','age'] 不传值验证所有字段，传值只验证当前传值的
 * @throws \App\Exceptions\ApiException
 */
function SPFV($input,$field=[])
{
    if(empty($field))
    {
        foreach ($input as $k=>$v)
        {
            if(!isset($v) || empty($v)) TEA('700',$k);
        }
    }
    else
    {
        foreach ($input as $k=>$v)
        {
            if(in_array($k,$field) && (!isset($v) || empty($v))) TEA('700',$k);
        }
    }
}

//返回当前的毫秒时间戳
function msecTime() {
    list($msec,$sec)=explode(' ', microtime());
    $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return $msectime;
}

/**
 * ascii码从小到大排序
 * @param array $params
 * @return bool|string
 */
function asc_sort($params = array())
{
    if (!empty($params)) {
        $p = ksort($params);
        if ($p) {
            $str = '';
            foreach ($params as $k => $val) {
                $str .= $k . '=' . $val . '&';
            }
            $strs = rtrim($str, '&');
            return $strs;
        }
    }
    return false;
}

/**
 * 简单加签
 *
 * @param $parameter
 * @return string
 */
function arithmetic($parameter)
{
    if(isset($parameter['signature']))
    {
        unset($parameter['signature']);
    }
    $timestamp = $parameter['timestamp'];
    $randstr = $parameter['randstr'];
    unset($parameter['timestamp']);
    unset($parameter['randstr']);

    //1.获取请求参数并统一转换为小写
    $parameter = array_keys(array_change_key_case($parameter,CASE_LOWER));
    //2.ascii码从小到大排序
    sort($parameter,SORT_STRING);
    //3.拼接原始加密数据
    $str = implode($parameter).'timestamp='.$timestamp.'randstr='.$randstr;
    //4.加密
    $signature = md5(sha1($str));
    //5.转换为大写
    $signature = strtoupper($signature);
    return $signature;
}



function getsize($size, $format = 'kb') {

    $p = 0;

    if ($format == 'kb') {

        $p = 1;

    } elseif ($format == 'mb') {

        $p = 2;

    } elseif ($format == 'gb') {

        $p = 3;

    }

    $size /= pow(1024, $p);

    return number_format($size, 3);

}

//生成唯一编码
function create_unique() {
    $data = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']
        .time() . rand();
    return sha1($data);
    //return md5(time().$data);
}

//加签
function create_token($parameter)
{
    $randstr = 'fasgfiujwalkj21yu23213';
    if(isset($parameter['_token']))
    {
        unset($parameter['_token']);
    }
    $token = '';
    if(!empty($parameter))
    {
        foreach ($parameter as $k=>$v)
        {
            $token .= $k.'='.$v.'&';
        }
        $token .= 'randstr='.$randstr;
    }

    //4.加密
    $signature = md5(sha1($token));
    //5.转换为大写
    $signature = strtoupper($signature);
    return $signature;
}

//验签名
function verification_token($parameter) {
    //1.获取token
    $_token = $parameter['_token'];

    $token2 = create_token($parameter);

    if($_token != $token2)
    {
        TEPA('验签失败！！！');
    }
}

function getIP()
{
    global $ip;
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;
}


/**
 * 判断二维数组中是否包含某个值 deep_in_array('a', [['a','b'],['c','d']]);
 * @param $value
 * @param $array
 * @return bool true-包含 false-不包含
 */
function deep_in_array($value, $array) {
    foreach($array as $item) {
        if(!is_array($item)) {
            if ($item == $value) {
                return true;
            } else {
                continue;
            }
        }
        if(in_array($value, $item)) {
            return true;
        } else if(deep_in_array($value, $item)) {
            return true;
        }
    }
    return false;
}

/**
 * 获取文件的访问地址
 * @param $url
 */
function getFullPath($url)
{
    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    if (!strstr($url, 'https://') && !strstr($url, 'http://')) {
        $after = $http_type . $_SERVER['HTTP_HOST'] . '/storage/' . $url;
    } else {
        $after = $url;
    }
    return $after;
}


/**
 * 获取全局唯一标识符
 * @param bool $trim
 * @return string
 */

function getGuidV4($trim = true)
{
    // Windows
    if (function_exists('com_create_guid') === true) {

        $charid = com_create_guid();

        return $trim == true ? trim($charid, '{}') : $charid;
    }
    // OSX/Linux

    if (function_exists('openssl_random_pseudo_bytes') === true) {

        $data = openssl_random_pseudo_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100

        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

    }

    // Fallback (PHP 4.2+)

    mt_srand((double)microtime() * 10000);

    $charid = strtolower(md5(uniqid(rand(), true)));

    $hyphen = chr(45);                  // "-"

    $lbrace = $trim ? "" : chr(123);    // "{"

    $rbrace = $trim ? "" : chr(125);    // "}"

    $guidv4 = $lbrace .

        substr($charid, 0, 8) . $hyphen .

        substr($charid, 8, 4) . $hyphen .

        substr($charid, 12, 4) . $hyphen .

        substr($charid, 16, 4) . $hyphen .

        substr($charid, 20, 12) .

        $rbrace;

    return $guidv4;

}

/**
 * 1.删除二维数组中相同项的数据，一般用于数据库查询结果中相同记录的去重操作
 * 2.重置一下二维数组的索引
 * @param array $_2d_array 二维数组，类似：
 *     $tmpArr = array(
 *         array('id' => 1, 'value' => '15046f5de5bb708e'),
 *         array('id' => 1, 'value' => '15046f5de5bb708e'),
 *     );
 * @param string $unique_key 表示上述数组的 "id" 键，或者 "value" 键
 * @return mixed
 */
function unique_2d_array_by_key($_2d_array, $unique_key)
{
    $tmp_key[] = array();
    foreach ($_2d_array as $key => &$item) {
        if (is_array($item) && isset($item[$unique_key])) {
            if (in_array($item[$unique_key], $tmp_key)) {
                unset($_2d_array[$key]);
            } else {
                $tmp_key[] = $item[$unique_key];
            }
        }
    }
    //重置一下二维数组的索引
    return array_slice($_2d_array, 0, count($_2d_array), false);
}


function get_base64img_info($base64img,$type){
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64img, $result)){

        if ($type=='type'){

            $img_result = $result[2];

        }elseif ($type=='size'){

            $base_img = str_replace($result[1], '', $base64img);
            $base_img = str_replace('=','',$base_img);
            $img_len = strlen($base_img);
            $file_size = intval($img_len - ($img_len/8)*2);
            $img_result = number_format(($file_size/1024),2);//KB

        }

        return $img_result;
    }
}