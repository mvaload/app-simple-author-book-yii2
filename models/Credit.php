<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "credits".
 *
 * @property int $id
 * @property string $cred_no
 * @property string $cred_date
 * @property float|null $cred_sum
 */
class Credit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'credits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cred_no', 'cred_date'], 'required'],
            [['cred_date'], 'safe'],
            [['cred_sum'], 'number'],
            [['cred_no'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cred_no' => 'Cred No',
            'cred_date' => 'Cred Date',
            'cred_sum' => 'Cred Sum',
        ];
    }

    public function getPayments()
    {
        return $this->hasMany(Payment::class, ['cred_id' => 'id']);
    }

}
