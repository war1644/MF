<?php
namespace Base\Tool;
/**
 * 导出数据为excel
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @since
 * <p>v0.9 2017/1/23 9:10  初版</p>
 * <p>v1.0 2017/1/23 11:55  增强对特殊字符的支持</p>
 */

class SaveToExcel {

    /**
     * 导出数据为excel表格
     * @param array $data    一个二维数组,结构如同从数据库查出来的数组
     * @param array $title   excel第一行的标题
     * @param string $filename 文件名
     */
    public static function exportExcel($data=array(),$title=array(),$filename='report'){
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t ", $title);
            echo "$title\n";
        }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    if ($ck=='id'){
                        $cv = strval($key);
                    }
//                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                    $data[$key][$ck]=mb_convert_encoding($cv,"GB2312","UTF-8");

                }
                $data[$key]=implode("\t ", $data[$key]);

            }
            echo implode("\n",$data);
        }
    }

}