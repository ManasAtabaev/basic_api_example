<?php

namespace app\modules\v1\controllers;

// use yii\web\Controller;
use yii\rest\ActiveController;

/**
 * Client controller for the `modules` module
 */
class ClientController extends ActiveController
{
    public $modelClass = 'app\models\Client';
}
