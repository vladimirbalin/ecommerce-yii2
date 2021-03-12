<?php


namespace frontend\controllers;


use frontend\models\ProfileEditForm;

class ProfileController extends base\BaseController
{
    public function actionIndex(): string
    {
        $model = \Yii::$app->user->getIdentity();
        return $this->render('index', ['model' => $model]);
    }

    public function actionEdit(): string
    {
        $model = new ProfileEditForm(\Yii::$app->user->id);
        if ($model->load(\Yii::$app->request->post()) && $model->edit()) {
            \Yii::$app->session->setFlash('success', 'Profile information was successfully updated');
            $this->redirect(['profile/index']);
        }
        return $this->render('edit', ['model' => $model]);
    }
}