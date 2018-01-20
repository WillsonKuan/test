<?php

namespace backend\controllers;

use backend\models\SignupForm;
use common\models\AuthAssignment;
use common\models\AuthItem;
use Yii;
use common\models\Adminuser;
use common\models\AdminuserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use backend\models\ResetPasswordForm;

/**
 * AdminuserController implements the CRUD actions for Adminuser model.
 */
class AdminuserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Adminuser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adminuser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Adminuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {
            if($user = $model->signup()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
            return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Adminuser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Adminuser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Adminuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adminuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adminuser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->redirect(['index']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionResetpwd($id)
    {
        $model1 = self::findModel($id);
        if ($model1->reset()){
            return $this->actionResetPassword($model1->password_reset_token);
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrivilege($id)
    {
        $model = $this->findModel($id);

        //找出所有权限
        $authItem = AuthItem::find()->select('name, description')->where('type=1')->all();
        foreach ($authItem as $ai){
            $authItemArray[$ai->name] = $ai->description;
        }

        //找出当前用户权限
        $authAssign = AuthAssignment::find()->select('item_name')
                        ->where('user_id = :id',[':id'=>$id])->all();
        $authAssignArray = array();
        foreach ($authAssign as $aa){
            array_push($authAssignArray, $aa->item_name);
        }

        //修改权限
        if(isset($_POST['newpriv'])) {
            echo var_dump($_POST['newPriv']);
            exit(0);
            AuthAssignment::deleteAll('user_id = :id',[':id'=>$id]);
            /*for($i=0;$i<count($_POST['newPriv']);$i++){
                $authModel = new AuthAssignment();
                $authModel->item_name =
            }*/
        }

        //渲染页面
        return $this->render('privilege',['model'=>$model,'authItemArray'=>$authItemArray,'authAssignArray'=>$authAssignArray]);
    }
}
