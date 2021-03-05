<?php

namespace backend\controllers;

use Yii;
use common\models\Partner;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;

/**
 * PartnerController implements the CRUD actions for Partner model.
 */
class PartnerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Partner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Partner::find(),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
                'attributes' => [
                    'id',
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actions()
    {
        return [
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Partner::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Partner::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Partner::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Partner::className(),
            ],
        ];
    }
}
