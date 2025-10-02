<?php

namespace app\controllers;

use Yii;
use app\models\Todo;
use app\models\Category;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TodoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['delete' => ['POST']],
            ],
        ];
    }

    public function actionIndex() {

        return $this->render('index', ['todos' => Todo::find()->with('category')->all(), 'categories' => Category::find()->all()]);
    }

    public function actionCreate() {

        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $model = new Todo();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->refresh(); 
            
            return ['success' => true, 'todo' => ['id' => $model->id, 'name' => $model->name, 'category' => $model->category->name, 'timestamp' => Yii::$app->formatter->asDate($model->timestamp, 'php:M j'),]];
        }
        
        return ['success' => false, 'errors' => $model->errors];
    }

    public function actionDelete($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        try {
            $this->findModel($id)->delete();

            return ['success' => true];
        } catch (\Exception $e) {

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    protected function findModel($id) {
        if (($model = Todo::findOne($id)) !== null) {

            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}