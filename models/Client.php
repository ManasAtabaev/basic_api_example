<?php

namespace app\models;

use Yii;
use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $phoneNumber
 * @property bool $active
 * @property int $created_by
 * @property string $created_time
 * @property int|null $modified_by
 * @property string|null $modified_time
 */
class Client extends \app\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'email', 'phoneNumber'], 'required'],
            [['active'], 'boolean'],
            [['active'], 'default', 'value' => true],
            [['created_by', 'modified_by'], 'default', 'value' => null],
            [['created_by', 'modified_by'], 'integer'],
            [['created_time', 'modified_time'], 'safe'],
            [['firstName', 'lastName'], 'string', 'max' => 32],
            [['email', 'phoneNumber'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['phoneNumber'], PhoneInputValidator::className()],
            [['firstName', 'lastName'], 'unique', 'targetAttribute' => ['firstName', 'lastName']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'firstName' => Yii::t('app', 'First Name'),
            'lastName' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'phoneNumber' => Yii::t('app', 'Phone Number'),
            'active' => Yii::t('app', 'Active'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_time' => Yii::t('app', 'Created Time'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_time' => Yii::t('app', 'Modified Time'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'id',
            'firstName',
            'lastName',
            'email',
            'phoneNumber',
        ];
    }
}
