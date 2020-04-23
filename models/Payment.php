<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property int $cred_id
 * @property resource $data_set
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cred_id', 'data_set'], 'required'],
            [['cred_id'], 'integer'],
            [['data_set'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cred_id' => 'Cred ID',
            'data_set' => 'Data Set',
        ];
    }

    public function getCredits()
    {
        return $this->hasOne(Credit::class, ['id' => 'cred_id']);
    }
}
