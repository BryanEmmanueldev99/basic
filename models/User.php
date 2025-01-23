<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $user_pass
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'user_pass'], 'string', 'max' => 255],
            [['name', 'email', 'user_pass'], 'required'],
            [['avatar'], 'file','extensions' => 'png,jpg,jpeg'],
        ];

        // return [
        //     [
        //         [['name', 'email', 'user_pass'], 'string', 'max' => 255],
        //         [['name', 'email', 'user_pass'], 'required'],
        //         [['archivo'], 'file','extensions' => 'png,jpg'],
        //     ]
        // ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'email' => 'correo',
            'user_pass' => 'Contraseña',
            'avatar' => 'Avatar'
        ];
    }
}
