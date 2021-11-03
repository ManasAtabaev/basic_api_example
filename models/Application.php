<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property int $clientId
 * @property int $term
 * @property float $amount
 * @property string $currency
 * @property bool $active
 * @property int $created_by
 * @property string $created_time
 * @property int|null $modified_by
 * @property string|null $modified_time
 *
 * @property Client $client
 */
class Application extends \app\db\ActiveRecord
{
    public $allowedCurrency = [
        'EUR',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clientId', 'term', 'amount', 'currency'], 'required'],
            [['clientId', 'term', 'created_by', 'modified_by'], 'default', 'value' => null],
            [['clientId', 'created_by', 'modified_by'], 'integer'],
            [['term'], 'integer', 'min' => 10, 'max' => 30],
            [['amount'], 'number', 'min' => 100, 'max' => 5000],
            [['active'], 'boolean'],
            [['created_time', 'modified_time'], 'safe'],
            [['currency'], 'string', 'max' => 3],
            [['currency'], 'checkCurrency'],
            [['clientId'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['clientId' => 'id']],
        ];
    }

    public function checkCurrency($attribute)
    {
        if (!in_array($this->{$attribute}, $this->allowedCurrency)) {
            $this->addError(
                $attribute,
                Yii::t(
                    'app',
                    'Invalid {attribute}, allowed values: {allowedCurrency}',
                    [
                        'attribute' => $attribute,
                        'allowedCurrency' => implode(', ', $this->allowedCurrency)
                    ]
                )
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'clientId' => Yii::t('app', 'Client ID'),
            'term' => Yii::t('app', 'Term'),
            'amount' => Yii::t('app', 'Amount'),
            'currency' => Yii::t('app', 'Currency'),
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
            'clientId',
            'term',
            'amount',
            'currency',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'clientId']);
    }
}
