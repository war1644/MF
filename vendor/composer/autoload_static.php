<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit641aec49956ef204ec8526f7ffbca286
{
    public static $classMap = array (
        'AdminC' => __DIR__ . '/../..' . '/App/C/Admin/AdminC.php',
        'AppkeyM' => __DIR__ . '/../..' . '/App/M/AppkeyM.php',
        'Base\\Base' => __DIR__ . '/../..' . '/Base/Base.php',
        'Base\\C' => __DIR__ . '/../..' . '/Base/C.php',
        'Base\\DB\\DB' => __DIR__ . '/../..' . '/Base/DB/DB.php',
        'Base\\DB\\MyPDO' => __DIR__ . '/../..' . '/Base/DB/MyPDO.php',
        'Base\\DB\\Redis' => __DIR__ . '/../..' . '/Base/DB/Redis.php',
        'Base\\M' => __DIR__ . '/../..' . '/Base/M.php',
        'Base\\MFWAF' => __DIR__ . '/../..' . '/Base/MFWAF.php',
        'Base\\Macaw' => __DIR__ . '/../..' . '/Base/Macaw.php',
        'Base\\Tool\\MFWechat' => __DIR__ . '/../..' . '/Base/Tool/MFWechat.php',
        'Base\\Tool\\Page' => __DIR__ . '/../..' . '/Base/Tool/Page.php',
        'Base\\Tool\\Socket' => __DIR__ . '/../..' . '/Base/Tool/Socket.php',
        'Base\\Tool\\Upload' => __DIR__ . '/../..' . '/Base/Tool/Upload.php',
        'Base\\Tool\\Vcode' => __DIR__ . '/../..' . '/Base/Tool/Vcode.php',
        'Base\\Tool\\Wechat\\ErrCode' => __DIR__ . '/../..' . '/Base/Tool/Wechat/ErrCode.php',
        'Base\\Tool\\Wechat\\ErrorCode' => __DIR__ . '/../..' . '/Base/Tool/Wechat/Wechat.php',
        'Base\\Tool\\Wechat\\PKCS7Encoder' => __DIR__ . '/../..' . '/Base/Tool/Wechat/Wechat.php',
        'Base\\Tool\\Wechat\\Prpcrypt' => __DIR__ . '/../..' . '/Base/Tool/Wechat/Wechat.php',
        'Base\\Tool\\Wechat\\Wechat' => __DIR__ . '/../..' . '/Base/Tool/Wechat/Wechat.php',
        'HomeC' => __DIR__ . '/../..' . '/App/C/HomeC.php',
        'IndexC' => __DIR__ . '/../..' . '/App/C/Home/IndexC.php',
        'PublicC' => __DIR__ . '/../..' . '/App/C/PublicC.php',
        'UserM' => __DIR__ . '/../..' . '/App/M/UserM.php',
        'WechatC' => __DIR__ . '/../..' . '/App/C/WechatC.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit641aec49956ef204ec8526f7ffbca286::$classMap;

        }, null, ClassLoader::class);
    }
}
