<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use app\models\Profesion;
use yii\helpers\ArrayHelper;
use kartik\growl\Growl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Personas');
$this->params['breadcrumbs'][] = $this->title;

if ( Yii::$app->session->getFlash('success') ) {
    $type = Growl::TYPE_SUCCESS;
    $title = 'todo OK';
    $icon = 'glyphicon glyphicon-ok-sign';
    $body = Yii::$app->session->getFlash('success');
} elseif ( Yii::$app->session->getFlash('error') ) {
    $type = Growl::TYPE_DANGER;
    $title = 'Error';
    $icon = 'glyphicon glyphicon-remove-sign';
    $body = Yii::$app->session->getFlash('error');
}

$flashMessages = Yii::$app->session->getAllFlashes();
if ($flashMessages) {
        echo Growl::widget([
            'type' => $type,
            'title' => $title,
            'icon' => $icon,
            'body' => $body,
            'showSeparator' => true,
            'delay' => 0,
            'pluginOptions' => [
                'showProgressbar' => true,
                'placement' => [
                    'from' => 'top',
                    'align' => 'right',
                ],
                'timer' => 3000,
            ]
        ]);
}
?>
<div class="persona-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Persona'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'biografia:ntext',
            'fecha_nac',
            [
                'attribute'  => 'created_by',
                'value'     => 'createdBy.username',
            ],
            // 'created_at',
            // 'updated_by',
            // 'updated_at',
            // 'profesion.profesion',
            [
                'attribute' => 'profesion_id',
                'value'     => 'profesion.profesion',
                'format'    => 'raw', // email, number
                'filter'    => Select2::widget([
                                'model' => $searchModel,
                                'attribute' => 'profesion_id',
                                'data' => ArrayHelper::map(Profesion::find()->all(), 'id', 'profesion'),
                                'options' => [
                                    //'multiple' => true,
                                    'placeholder' => 'Seleccion una profesión...'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
