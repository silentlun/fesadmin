<?php
namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\traits\BaseFrontendAction;

class BaseController extends \yii\web\Controller
{
    use BaseFrontendAction;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        parent::behaviors();
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    

}