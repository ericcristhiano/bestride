<?php

namespace app\controllers;

use app\models\Ride;
use app\models\RideSearch;
use DateTime;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RideController implements the CRUD actions for Ride model.
 */
class RideController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Ride models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RideSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ride model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Ride model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ride();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Ride created!');
            return $this->redirect(['ride/manage']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ride model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Manage page
     */
    public function actionManage() {
        $user = \Yii::$app->user->identity;
        $rides = $user->myRides;
        $associatedRides = $user->rides;

        return $this->render('manage', ['rides' => $rides, 'associatedRides' => $associatedRides]);
    }
    
    /**
     * Delete association
     */
    public function actionDelete($id) {
        $user = \Yii::$app->user->identity;
        $ride = Ride::findOne($id);
        $dt = new DateTime();

        if ($ride->date < $dt->format('Y-m-d')) {
            \Yii::$app->session->setFlash('danger', 'You cannot delete a past ride association');
            return $this->redirect(['ride/manage']);
        }

        $ride->unlink('users', $user, true);
        \Yii::$app->session->setFlash('success', 'Association removed!');
        return $this->redirect(['ride/manage']);

    }
    
    /**
     * Create an association
     */
    public function actionAssociate($id) {
        $user = \Yii::$app->user->identity;
        $ride = Ride::findOne($id);
        $dt = new DateTime(); 
        $ride->link('users', $user, ['date' => $dt->format('Y-m-d H:i:s')]);
        return json_encode([
            'success' => 'Associated success'
        ]);
    }

    /**
     * Finds the Ride model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ride the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ride::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
