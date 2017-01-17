<?php
namespace Base\Tool;
/**
 * Created by 路漫漫.
 * Link: ahmerry@qq.com
 * Date: 2016/12/12 14:32
 * 过滤非法字段，非法请求
 */

class MFWAF{
    private $url_arr = [
        'xss'=>"\\=\\+\\/v(?:8|9|\\+|\\/)|\\%0acontent\\-(?:id|location|type|transfer\\-encoding)",
    ];

    private $args_arr = [
        'xss'=>"[\\'\\\"\\;\\*\\<\\>].*\\bon[a-zA-Z]{3,15}[\\s\\r\\n\\v\\f]*\\=|\\b(?:expression)\\(|\\<script[\\s\\\\\\/]|\\<\\!\\[cdata\\[|\\b(?:eval|alert|prompt|msgbox)\\s*\\(|url\\((?:\\#|data|javascript)",
        'sql'=>"[^\\{\\s]{1}(\\s|\\b)+(?:select\\b|update\\b|insert(?:(\\/\\*.*?\\*\\/)|(\\s)|(\\+))+into\\b).+?(?:from\\b|set\\b)|[^\\{\\s]{1}(\\s|\\b)+(?:create|delete|drop|truncate|rename|desc)(?:(\\/\\*.*?\\*\\/)|(\\s)|(\\+))+(?:table\\b|from\\b|database\\b)|into(?:(\\/\\*.*?\\*\\/)|\\s|\\+)+(?:dump|out)file\\b|\\bsleep\\([\\s]*[\\d]+[\\s]*\\)|benchmark\\(([^\\,]*)\\,([^\\,]*)\\)|(?:declare|set|select)\\b.*@|union\\b.*(?:select|all)\\b|(?:select|update|insert|create|delete|drop|grant|truncate|rename|exec|desc|from|table|database|set|where)\\b.*(charset|ascii|bin|char|uncompress|concat|concat_ws|conv|export_set|hex|instr|left|load_file|locate|mid|sub|substring|oct|reverse|right|unhex)\\(|(?:master\\.\\.sysdatabases|msysaccessobjects|msysqueries|sysmodules|mysql\\.db|sys\\.database_name|information_schema\\.|sysobjects|sp_makewebtask|xp_cmdshell|sp_oamethod|sp_addextendedproc|sp_oacreate|xp_regread|sys\\.dbms_export_extension)",
        'other'=>"\\.\\.[\\\\\\/].*\\%00([^0-9a-fA-F]|$)|%00[\\'\\\"\\.]"
    ];

    private $referer;
    private $query_string;

    /**
     * @return array
     */
    function __construct($method) {
        $this->referer=empty($_SERVER['HTTP_REFERER']) ? array() : array($_SERVER['HTTP_REFERER']);
        $this->query_string=empty($_SERVER["QUERY_STRING"]) ? array() : array($_SERVER["QUERY_STRING"]);
        $this->check_data($this->query_string,$this->url_arr);
        switch ($method){
            case 'GET':
                $this->check_data($_GET,$this->args_arr);
                break;
            case 'POST':
                $this->check_data($_POST,$this->args_arr);
                break;
            default:
                die('拒绝接收非常用请求');
                break;
        }

        $this->check_data($_COOKIE,$this->args_arr);
        $this->check_data($this->referer,$this->args_arr);
    }

    function check_data($arr,$v) {
        foreach($arr as $key=>$value)
        {
            if(!is_array($key))
            { $this->check($key,$v);}
            else
            { $this->check_data($key,$v);}

            if(!is_array($value))
            { $this->check($value,$v);}
            else
            { $this->check_data($value,$v);}
        }
    }
    function check($str,$v) {
        foreach ($v as $key => $value) {
            if (preg_match("/" . $value . "/is", $str) == 1 || preg_match("/" . $value . "/is", urlencode($str)) == 1) {
                $log = "<br>IP: " . $_SERVER["REMOTE_ADDR"] . "<br>时间: " . strftime("%Y-%m-%d %H:%M:%S") . "<br>页面:" . $_SERVER["PHP_SELF"] . "<br>提交方式: " . $_SERVER["REQUEST_METHOD"] . "<br>提交数据: " . $str;
                MFLog($log,'Defend');
                die($_SERVER['REMOTE_ADDR'] . "非法操作，已记录你的行为");
            }
        }
    }
}