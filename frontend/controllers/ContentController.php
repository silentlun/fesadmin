<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\Content;
use common\models\ContentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Category;
use common\models\Page;

/**
 * ContentController implements the CRUD actions for Content model.
 */
class ContentController extends Controller
{

    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex($catdir = '')
    {
        $categoryModel = Category::findOne(['catdir' => $catdir]);
        if (empty($categoryModel)) {
            throw new NotFoundHttpException('None page named ' . $catdir);
        }
        $category = [];
        $categorys = Category::getCategory();
        if ($categoryModel->parentid == 0) {
            $catids = [$categoryModel->id];
            foreach ($categorys as $cat) {
                if ($cat['parentid'] != $categoryModel->id) continue;
                $catids[] = $cat['id'];
                $category[] = $cat;
            }
            $where = ['in', 'catid', $catids];
            $bannerImg = $categoryModel->image;
        } else {
            foreach ($categorys as $cat) {
                if ($cat['parentid'] != $categoryModel->parentid) continue;
                $category[] = $cat;
            }
            $where = ['catid' => $categoryModel->id];
            foreach ($categorys as $cat){
                if ($cat['id'] == $categoryModel->parentid){
                    $bannerImg = $cat['image'];
                }
            }
        }
        if ($categoryModel->type == 0) {
            $query = Content::find()->select(['id', 'catid', 'title', 'thumb', 'url', 'description', 'created_at'])->where(['status' => 99])
            ->andFilterWhere($where)->orderBy('sort DESC,id DESC');
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
            $template = 'list_news';
            $categoryModel->list_template != "" && $template = $categoryModel->list_template;
            
            
            return $this->render($template, [
                'dataProvider' => $dataProvider,
                'category' => $category,
                'categoryModel' => $categoryModel,
                'bannerImg' => $bannerImg,
            ]);
        } else {
            $model = Page::findOne(['catid' => $categoryModel->id]);
            $template = $categoryModel->page_template ? $categoryModel->page_template : 'page';
            return $this->render($template, [
                'model' => $model,
                'category' => $category,
                'categoryModel' => $categoryModel,
                'bannerImg' => $bannerImg,
            ]);
        }
        
    }

    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        //exit('view/'.$id);
        $model = $this->findModel($id);
        $categoryModel = Category::findOne($model->catid);
        $template = 'show_news';
        $categoryModel->show_template != "" && $template = $categoryModel->show_template;
        $model->template != "" && $template = $model->template;
        if ($categoryModel->parentid == 0) {
            $bannerImg = $categoryModel->image;
        } else {
            $parentCatModel = Category::findOne($categoryModel->parentid);
            $bannerImg = $parentCatModel->image;
        }
        
        $previousPage = Content::find()->select(['id', 'title', 'url'])
        ->where(['catid' => $model->catid, 'status' => 99])
        ->andWhere(['<', 'id', $id])
        ->limit(1)->asArray()->one();
        $nextPage = Content::find()->select(['id', 'title', 'url'])
        ->where(['catid' => $model->catid, 'status' => 99])
        ->andWhere(['>', 'id', $id])
        ->limit(1)->asArray()->one();
        if (empty($previousPage)) {
            $previousPage = ['title' => Yii::t('app', 'First Page'), 'url' => 'javascript:;'];
        }
        
        if (empty($nextPage)) {
            $nextPage = ['title' => Yii::t('app', 'Last Page'), 'url' => 'javascript:;'];
        }
        
        return $this->render($template, [
            'model' => $model,
            'categoryModel' => $categoryModel,
            'previousPage' => $previousPage,
            'nextPage' => $nextPage,
            'bannerImg' => $bannerImg,
        ]);
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Content the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
