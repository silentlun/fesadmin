<?php

namespace backend\controllers;

use Yii;
use common\models\MenuFrontend;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use backend\actions\UpdateAction;

/**
 * MenuFrontendController implements the CRUD actions for MenuFrontend model.
 */
class MenuFrontendController extends Controller
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
     * Lists all MenuFrontend models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => MenuFrontend::getMenuGrid(),
            'pagination' => false,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new MenuFrontend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = 0)
    {
        $model = new MenuFrontend();
        $model->parentid = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Save Success'));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actions()
    {
        return [
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => MenuFrontend::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => MenuFrontend::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => MenuFrontend::className(),
            ],
        ];
    }
}
