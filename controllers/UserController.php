<?php

namespace app\controllers;

use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\UploadForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        $this->uploadAvatar($model);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        // Obtenemos datos por el request del formulario echo $data['User']['name'] . "<br>";
                // Esto es dato del objeto entidad echo $model->avatar;

                //   echo "<pre>";
                //   print_r($_FILES);
                //   echo "</pre>";
        $model = $this->findModel($id);
        $img_actual = $model->avatar;

        if ($this->request->isPost) {

             $imgRequest = $_FILES['User']['name']['avatar'];

                if($imgRequest){

                    // Si existe imagen o avatar

                    if (file_exists($model->avatar)) {
                        unlink($model->avatar);
                    }

                    $data = $this->request->post(); 

                    if ( $model->load( $this->request->post() )  )  {
             
                        $model->avatar = UploadedFile::getInstance($model, 'avatar');
    
                        // file is uploaded successfully
                        $pathFile = 'wc_uploads/' . time() . '_' . $model->avatar->baseName . '.' . $model->avatar->extension;
    
                        if ($model->avatar->saveAs($pathFile)) {
                            $model->avatar = $pathFile;
                        }

                        if($model->save(false)) {
                            return $this->redirect(['index']);
                        }
                    }

                } else {

                    // Información sobre guardar cierta informacion recibida por medio del metodo load();
                    
                    //$data1 = [
                    //     'username' => 'sam',
                    //     'money' => 100
                    // ];
                    
                    // $data2 = [
                    //     'User' => [
                    //         'username' => 'sam',
                    //         'money' => 100
                    //     ],
                    // ],
                    
                    // // if you want to load $data1, you have to do like this
                    // $model->load($data1, '');
                    
                    // // if you want to load $data2, you have to do like this
                    // $model->load($data2);
                    
                    // // either one of the two ways, the result is the same.
                    // echo $model->username;    // sam
                    // echo $model->money;       // 100


                    //Caso contrario si noy hay imagen
                    $data = $this->request->post(); 

                    $array = [
                        'name' => $data['User']['name'],
                        'email' => $data['User']['email'],
                        'user_pass' => $data['User']['user_pass']
                    ];

                    if( $model->load($array, '') && $model->save(false) ) {
                        return $this->redirect(['index']);
                    }

                }
        }

        return $this->render('update', [
            'model' => $model,
            'img' => $img_actual
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (file_exists($model->avatar)) {
            unlink($model->avatar);
        }

        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }



    protected function uploadAvatar(User $model)
    {
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->avatar = UploadedFile::getInstance($model, 'avatar');

                if ($model->validate()) {
                    if ($model->avatar) {

                        if (file_exists($model->avatar)) {
                            unlink($model->avatar);
                        }

                        $pathFile = 'wc_uploads/' . time() . '_' . $model->avatar->baseName . '.' . $model->avatar->extension;

                        if ($model->avatar->saveAs($pathFile)) {
                            $model->avatar = $pathFile;
                        }
                    }
                }

                if ( $model->save(false)) {
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }
    }
}
