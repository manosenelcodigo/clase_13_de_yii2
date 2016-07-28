<?php

namespace app\models;
use \yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;

use Yii;

/**
 * This is the model class for table "profesion".
 *
 * @property integer $id
 * @property string $profesion
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property Persona[] $personas
 */
class Profesion extends MiActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profesion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //['profesion', 'filter', 'filter' => 'stroupper'],
            ['profesion', 'trim'],
            [['profesion'], 'required', 'message' => 'por favor complete este campo'],
            ['profesion', 'unique'],
            [['created_by', 'updated_by'], 'integer'],
            //['profesion', 'string', 'max' => 3],
            //['profesion', 'url', 'defaultScheme' => 'http', 'message' => 'URL inválida'],
            //['created_at', 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profesion' => 'Profesion',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Persona::className(), ['profesion_id' => 'id']);
    }
}
