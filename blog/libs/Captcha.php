<?php

namespace libs;

class Captcha
{
    //静态属性: 在静态方法中可以直接使用
    protected static $image;
    protected static $width;
    protected static $height;
    protected static $num;

    //主方法: 可以清晰展现代码的整体工作逻辑
    public static function show($width = 200, $height = 80, $num = 4)
    {
        self::$width = $width;
        self::$height = $height;
        self::$num = $num;

        self::$image = self::createImage();

        self::drawCode();

        self::drawLines();

        self::showOnWeb();
    }

    //1.建立画布
    //2.背景色填充
    protected static function createImage()
    {
        //1.建立画布
        $image = imagecreatetruecolor(self::$width, self::$height);

        //2.背景色填充
        $color = imagecolorallocate($image, 220, 220, 220);
        imagefill($image, 0, 0, $color);

        return $image;
    }

    //3.绘制验证码: 注意复制字体文件
    protected static function drawCode()
    {
        $string = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';

        $code = '';

        for ($i = 0; $i < self::$num; $i++) {
            $size = self::$height / 2;
            $angle = mt_rand(-25, 25);

            $x = $i * (self::$width / self::$num) + 10;
            $y = 3 / 4 * self::$height;

            $color = self::randColor();

            $fontfile = __DIR__ . '/Roboto.ttf';

            $index = mt_rand(0, strlen($string) - 1);
            $text = $string[$index];

            $code .= $text;

            imagettftext(self::$image, $size, $angle, $x, $y, $color, $fontfile, $text);
        }

        //正确的验证码 存到session中
        $_SESSION['code'] = $code;
    }

    //4.干扰线
    protected static function drawLines()
    {
        for ($i = 0; $i < 30; $i++) {
            $x1 = mt_rand(0, self::$width);
            $y1 = mt_rand(0, self::$height);

            $x2 = mt_rand(0, self::$width);
            $y2 = mt_rand(0, self::$height);

            $color = self::randColor();

            imageline(self::$image, $x1, $y1, $x2, $y2, $color);
        }
    }

    //5.导出
    //6.销毁
    protected static function showOnWeb()
    {
        ob_clean();    ////关键代码，防止出现'图像因其本身有错无法显示'的问题
        header('content-type:image/jpeg');
        imagejpeg(self::$image);

        //6.销毁
        imagedestroy(self::$image);
    }

    //随机颜色 代码比较长, 可以提取一下
    protected static function randColor()
    {
        $color = imagecolorallocate(self::$image, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200));
        return $color;
    }
}
