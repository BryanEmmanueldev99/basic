<?php 

namespace app\controllers;

use Yii;
use yii\filters\AccessController;
use yii\web\Controller;

class SitioController extends Controller 
{

    private $logs;

    public function actionInicio()
    {
        return $this->render('inicio.php');
    }

}