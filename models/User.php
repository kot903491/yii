<?php

namespace app\models;

use Yii;
use \yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $surname
 * @property string $password_hash
 * @property string $access_token
 * @property string $auth_key
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Access[] $accesses
 * @property Note[] $notes
 *
 * @mixin TimestampBehavior
 */


class User extends yii\db\ActiveRecord implements yii\web\IdentityInterface
{

    public $password;


    const SCENARIO_CREATE='create';
    const SCENARIO_UPDATE='update';

    const RELATION_ACCESSES='accesses';
    const RELATION_NOTES='notes';
    const RELATION_ACCESEDNOTES='accessedNotes';
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
            [['username', 'name', 'password'], 'required', 'on'=>self::SCENARIO_CREATE],
            [['created_at', 'updated_at'], 'integer'],
            [['username', 'name', 'surname', 'password', 'access_token',
                'auth_key'], 'string', 'max' => 255,'on'=>self::SCENARIO_CREATE],
            [['name'],'required','on'=>self::SCENARIO_UPDATE],
            [['name','surname','password'],'string','max'=>255,'on'=>self::SCENARIO_UPDATE]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'surname' => 'Surname',
            'password_hash' => 'Password Hash',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccesses()
    {
        return $this->hasMany(Access::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessedNotes()
    {
        return $this->hasMany(Note::class, ['id' => 'note_id'])
            ->viaTable('access',['user_id'=>'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->hasMany(Note::className(), ['creator_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UserQuery(get_called_class());
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username'=>$username]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return app()->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * @param bool $insert
     * @return bool|void
     */
    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert)){
            return false;
        }
        if ($this->password){
            $this->password_hash=app()->getSecurity()
                ->generatePasswordHash($this->password);
        }
        if ($this->isNewRecord){
            $this->auth_key=app()->getSecurity()->generateRandomString();
        }
        return true;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
            'class'=>TimestampBehavior::className(),
            'attributes'=>[
                ActiveRecord::EVENT_BEFORE_INSERT=>['created_at'],
                ActiveRecord::EVENT_BEFORE_UPDATE=>['updated_at']
                ]
            ]
        ];
    }

    public function scenarios()
    {
        $scenarios=parent::scenarios();
        $scenarios[self::SCENARIO_CREATE]=['username','name','password','surname','created_at'];
        $scenarios[self::SCENARIO_UPDATE]=['surname','name','password'];
        return $scenarios;
    }
}
