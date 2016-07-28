<?php

namespace app\controllers;

use Yii;
use app\models\Profesion;
use app\models\ProfesionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\filters\AccessControl;

/**
 * ProfesionController implements the CRUD actions for Profesion model.
 */
class ProfesionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only'  => ['index'],
                /*
                 * ? para usuario invitado
                 * @ para usuarios logueados
                 */
                'rules' => [
                    [
                        'actions'   => ['index'],
                        'allow'     => true,
                        'roles'     => ['?','@']
                    ],
                    [
                        'actions'   => ['create', 'update'],
                        'allow'     => false,
                        'roles'     => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profesion models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*
        if ( Yii::$app->user->isGuest ) {
            //$model = new LoginForm();
            //$this->render("/site/login", ["model" => $model]);
            return $this->redirect(["site/login"]);
        }
        */
        
        $searchModel = new ProfesionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profesion model.
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
     * Creates a new Profesion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profesion();

        if ($model->load(Yii::$app->request->post())) {
            /*
            $model->created_by = Yii::$app->user->id;
            $model->created_at = new Expression("NOW()");
            $model->updated_by = Yii::$app->user->id;
            $model->updated_at = new Expression("NOW()");
            */
            if ( !$model->save() ) {
                print_r($model->getErrors());
                exit;
            }
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Profesion model.
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
     * Deletes an existing Profesion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Profesion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profesion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profesion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionValidar()
    {
        $profesion = new Profesion(['scenario' => 'actualizar']);
        $profesion->created_by = 1;
        if ($profesion->save()) {
            echo "todo bien";
        } else {
            print_r($profesion->getErrors());
        }
        
    }
}
