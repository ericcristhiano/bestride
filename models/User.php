<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $birthdate
 * @property string $avatar
 *
 * @property Ride[] $rides
 * @property UserRide[] $userRides
 * @property Ride[] $myRides
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $confirmPassword;
    public $file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'birthdate', 'confirmPassword'], 'required'],
            [['name'], 'string', 'min' => 5],
            [['confirmPassword'], 'compare', 'compareAttribute' => 'password'],
            [['file'], 'safe'],
            [['birthdate'], 'date', 'format' => 'php:Y-m-d'],
            [['file'], 'image', 'extensions' => ['jpg'], 'maxSize' => 1024 * 1024, 'skipOnEmpty' => false],
            [['name', 'email', 'password', 'avatar'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'birthdate' => 'Birthdate',
            'avatar' => 'Avatar',
            'file' => 'Avatar',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getMyRides()
    {
        return $this->hasMany(Ride::className(), ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserRides()
    {
        return $this->hasMany(UserRide::className(), ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRides()
    {
        return $this->hasMany(Ride::className(), ['id' => 'ride_id'])->viaTable('user_ride', ['user_id' => 'id']);
    }

    public function getAuthKey() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
        
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        
    }
    
    public function validatePassword($password) {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function beforeValidate() {
        $this->file = UploadedFile::getInstance($this, 'file');

        $name = 'uploads/' . md5(microtime() . uniqid()) . '.' . $this->file->getExtension();
        
        $this->avatar = $name;

        return parent::beforeValidate();
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->password = \Yii::$app->security->generatePasswordHash($this->password);
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        if ($this->file->saveAs($this->avatar)) {
            return parent::afterSave($insert, $changedAttributes);
        }
    }

    public function getAge() {
        $dt = \DateTime::createFromFormat('Y-m-d', $this->birthdate);
        $actualDt = new \DateTime;
        $diff = $actualDt->diff($dt);
        return $diff->format('%y');
    }
}