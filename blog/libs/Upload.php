<?php 
namespace libs;

class Upload
{
    //让程序自动判断是多文件还是单文件, 执行对应的方法
    public static function save($dir)
    {
        //单文件: $_FILES 是二维数组
        //多文件上传: $_FILES 是 三维数组

        //reset(); 获取数组中的第一个值
        $tmp = reset($_FILES);
        $tmp1 = reset($tmp);


        if (is_array($tmp1)) {
            //三维数组
            return self::saveMultiple($dir);
        } else {
            //二维数组
            return self::saveSingle($dir);
        }
    }


    protected static function saveMultiple($dir)
    {
        //如果用户指定的目录不存在, 创建一个
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        foreach ($_FILES as $key => $value) {
            foreach ($value as $kk => $vv) {
                foreach ($vv as $k => $v) {
                    $newArr[$k][$kk] = $v;
                }
            }
        }

        $images = [];

        foreach ($newArr as $key => $value) {
            $filename = $value['tmp_name'];

            $name = $value['name'];
            $extension = pathinfo($name, PATHINFO_EXTENSION);

            $unique = md5(microtime(true) . mt_rand(0, 9e8));

            $uniqueName = "{$unique}.{$name}";

            $destination = "{$dir}/{$uniqueName}";


            $suc = move_uploaded_file($filename, $destination);

            // echo $suc ? '成功' : '失败';
            // echo '<hr>';

            if ($suc) {
                $images[] = $uniqueName;
            } else {
                return false;
            }
        }

        return $images;
    }


    protected static function saveSingle($dir)
    {
        //如果用户指定的目录不存在, 创建一个
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $file = reset($_FILES);

        //把上传文件从临时位置 移动到 目标位置
        $filename = $file['tmp_name']; //原位置, 临时位置

        //同名文件会覆盖: 生成一个唯一名称
        $unique = md5(microtime(true) . mt_rand(0, 9e8));

        //读取上传文件的后缀名
        $name = $file['name'];
        $extension = pathinfo($name, PATHINFO_EXTENSION);

        //拼接出名称
        $uniqueName = "{$unique}.{$extension}";

        //目标位置
        $destination = "{$dir}/$uniqueName";

        /**
         * 参数1: 文件的原位置
         * 参数2: 文件的目标位置
         */
        $suc = move_uploaded_file($filename, $destination);
        // echo $suc ? '成功' : '失败';

        return  $suc ? $uniqueName : false;
    }
}
 