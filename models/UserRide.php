<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_ride".
 *
 * @property integer $user_id
 * @property integer $ride_id
 * @property string $date
 *
 * @property Ride $ride
 * @property User $user
 */
class UserRide extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_ride';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'ride_id', 'date'], 'required'],
            [['user_id', 'ride_id'], 'integer'],
            [['date'], 'safe'],
            [['ride_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ride::className(), 'targetAttribute' => ['ride_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'ride_id' => 'Ride ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRide()
    {
        return $this->hasOne(Ride::className(), ['id' => 'ride_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
