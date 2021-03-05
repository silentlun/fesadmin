<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-token',
            'cookieValidationKey' => 'kknyFVGPh51AWdieii9rSf6zEb6YJqPz',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-token', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'session-token',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'assetManager' => [
            'linkAssets' => false,
            'appendTimestamp' => true,
            'bundles' => [
                'yii\web\YiiAsset' => [
                    'js' => [],  // 去除 yii.js
                    'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
                ],
                
                'yii\widgets\ActiveFormAsset' => [
                    'js' => [],  // 去除 yii.activeForm.js
                    'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
                ],
                
                'yii\validators\ValidationAsset' => [
                    'js' => [],  // 去除 yii.validation.js
                    'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
                ],
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null, // 一定不要发布该资源
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],  // 去除 bootstrap.css
                    'sourcePath' => null, // 防止在 frontend/web/asset 下生产文件
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [],  // 去除 bootstrap.js
                    'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
                ],
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
            ],
            'rules' => [
                '/' => 'site/index',
                '<alias:login|logout|signup|request-password-reset|reset-password>' => 'site/<alias>',
                'contest' => 'contest/index',
                '<catdir>' => 'content/index',
                'detail/<id:\d+>' => 'content/view',
                /* [
                    'pattern' => '<catdir>',
                    'route' => 'content/index',
                    'encodeParams' => false,
                    'defaults' => ['catdir' => null],
                ],
                
                [
                    'pattern' => 'p/<id>',
                    'route' => 'content/view',
                    'encodeParams' => false,
                    'defaults' => ['id' => null],
                ], */
                
            ],
        ],
    ],
    'params' => $params,
    'on beforeRequest' => [common\components\Config::className(), 'frontendInit'],
];
