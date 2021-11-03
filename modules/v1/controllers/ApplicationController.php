<?php

namespace app\modules\v1\controllers;

// use yii\web\Controller;
use yii\rest\ActiveController;

/**
 * Application controller for the `modules` module
 */
class ApplicationController extends ActiveController
{
    public $modelClass = 'app\models\Application';
}
