<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;

use \yii\db\Query;

use app\models\Profesion;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    /*
     * Role Based Access Control (Control de acceso basado en roles)
     */
    public function actionRbac()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        
        $crearPais = $auth->createPermission('pais-crear');
        $crearPais->description = 'Permite insertar el registro de un pais';
        $auth->add($crearPais);
        
        $ActualizarPais = $auth->createPermission('pais-actualizar');
        $ActualizarPais->description = 'Permite actualizar el registro de un pais';
        $auth->add($ActualizarPais);
        
        $ListarPais = $auth->createPermission('pais-listar');
        $ListarPais->description = 'Permite listar todos los registro de pais';
        $auth->add($ListarPais);
        
        $EliminarPais = $auth->createPermission('pais-eliminar');
        $EliminarPais->description = 'Permite eliminar el registro de un pais';
        $auth->add($EliminarPais);
        
        $rolAdminPais = $auth->createRole('pais-admin');
        $auth->add($rolAdminPais);
        
        $auth->addChild($rolAdminPais, $crearPais);
        $auth->addChild($rolAdminPais, $ActualizarPais);
        $auth->addChild($rolAdminPais, $ListarPais);
        $auth->addChild($rolAdminPais, $EliminarPais);
        
        $auth->assign($rolAdminPais, 2);
        
        echo "ok";
    }
}
