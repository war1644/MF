<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit641aec49956ef204ec8526f7ffbca286
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'War1644\\Phpwechatsdk\\' => 21,
        ),
        'N' => 
        array (
            'NoahBuscher\\Macaw\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'War1644\\Phpwechatsdk\\' => 
        array (
            0 => __DIR__ . '/..' . '/war1644/phpwechatsdk',
        ),
        'NoahBuscher\\Macaw\\' => 
        array (
            0 => __DIR__ . '/..' . '/noahbuscher/macaw',
        ),
    );

    public static $classMap = array (
        'AdminC' => __DIR__ . '/../..' . '/App/C/Admin/AdminC.php',
        'AppkeyM' => __DIR__ . '/../..' . '/App/M/AppkeyM.php',
        'Base' => __DIR__ . '/../..' . '/Base/Base.php',
        'Base\\C' => __DIR__ . '/../..' . '/Base/C/C.php',
        'Base\\DB' => __DIR__ . '/../..' . '/Base/DB/DB.php',
        'Base\\M' => __DIR__ . '/../..' . '/Base/M/M.php',
        'Base\\MFWAF' => __DIR__ . '/../..' . '/Base/Tool/MFWAF.php',
        'Base\\Page' => __DIR__ . '/../..' . '/Base/Tool/Page.php',
        'Base\\Redis' => __DIR__ . '/../..' . '/Base/DB/Redis.php',
        'Base\\Tool\\MFWechat' => __DIR__ . '/../..' . '/Base/Tool/MFWechat.php',
        'Base\\Upload' => __DIR__ . '/../..' . '/Base/Tool/Upload.php',
        'Base\\Vcode' => __DIR__ . '/../..' . '/Base/Tool/Vcode.php',
        'HomeC' => __DIR__ . '/../..' . '/App/C/HomeC.php',
        'PublicC' => __DIR__ . '/../..' . '/App/C/PublicC.php',
        'UserM' => __DIR__ . '/../..' . '/App/M/UserM.php',
        'WechatC' => __DIR__ . '/../..' . '/App/C/WechatC.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit641aec49956ef204ec8526f7ffbca286::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit641aec49956ef204ec8526f7ffbca286::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit641aec49956ef204ec8526f7ffbca286::$classMap;

        }, null, ClassLoader::class);
    }
}
