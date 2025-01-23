<?php

namespace app\models;

use yii\base\Model;


class Formulario extends Model
{

    public $valorA;

    public $valorB;

    public function rules()
    {
        return [
            [['valorA','ValorB'], 'require'],
            ['valorA','number'], ['valorB','number'],
        ];
    }


}

?>