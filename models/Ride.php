<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ride".
 *
 * @property integer $id
 * @property string $date
 * @property string $origin
 * @property string $destination
 * @property integer $available_seats
 * @property integer $price
 * @property string $more_information
 * @property integer $user_id
 *
 * @property User $user
 * @property UserRide[] $userRides
 * @property User[] $users
 */
class Ride extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ride';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'origin', 'destination', 'available_seats', 'user_id'], 'required'],
            [['date'], 'safe'],
            [['available_seats', 'price', 'user_id'], 'integer'],
            [['more_information'], 'string'],
            [['origin', 'destination'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date of Ride',
            'origin' => 'Origin',
            'destination' => 'Destination',
            'available_seats' => 'Available Seats',
            'price' => 'Price',
            'more_information' => 'More Information',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRides()
    {
        return $this->hasMany(UserRide::className(), ['ride_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_ride', ['ride_id' => 'id']);
    }
    
    public function getDateFormated() {
        $dt = \DateTime::createFromFormat('Y-m-d', $this->date);
        return $dt->format('d/m/Y');
    }
    
    public function getCreatedAtFormated() {
        $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);
        return $dt->format('d/m/Y H:i:s');
    }

    public function beforeValidate() {
        $user = \Yii::$app->user->identity;
        $this->user_id = $user->id;
        $date = new \DateTime();
        $this->created_at = $date->format('Y-m-d H:i:s');
                
        return parent::beforeValidate();
    }

    public function getAssociatedUsers() {
        return $this->getUserRides()->count();
    }
    
    public function getUsedPlaces() {
        return round($this->associatedUsers / $this->available_seats * 100, 2);
    }
    
    public function getValueReceived() {
        return $this->associatedUsers * $this->price;
    }
    
    public function getDate($userId) {
        $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $this->getUserRides()->where(['user_id' => $userId])->one()['date']);
        return $dt->format('d/m/Y H:i:s');
    }
    
    public function isAssociated($userId) {
        foreach ($this->users as $user) {
            if ($user->id == $userId) return true;
        }

        return false;
    }
}
