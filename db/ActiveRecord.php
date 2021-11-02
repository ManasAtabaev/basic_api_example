<?php

namespace app\db;

use yii\db\{ActiveQueryInterface, ActiveRecord as BaseActiveRecord};

/**
 * Class ActiveRecord
 *
 * @author Manas Atabaev <manas.atabaev@gmail.com>
 *
 */
class ActiveRecord extends BaseActiveRecord
{
    /**
     * {@inheritDoc}
     */
    public function behaviors(): array
    {
        $behaviors = [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'createdAtAttribute' => 'created_time',
                'updatedAtAttribute' => 'modified_time',
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'created_time',
                    self::EVENT_BEFORE_UPDATE => 'modified_time'
                ],
                'value' => date('Y-m-d H:i:s')
            ],
            [
                'class' => 'yii\behaviors\BlameableBehavior',
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'modified_by',
                'defaultValue' => 1,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'modified_by',
                ],
            ],
        ];

        return array_merge($behaviors, parent::behaviors());
    }
}
