<?php

namespace humhub\modules\gravatar\controllers;

use humhub\modules\admin\components\Controller;
use humhub\modules\gravatar\models\ConfigForm;
use Yii;

/**
 * Admin controller for gravatar module
 */
class AdminController extends Controller
{
    /**
     * Render the admin settings form
     */
    public function actionIndex()
    {
        $module = Yii::$app->getModule('gravatar');
        $form = $module->getConfigModel();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $module->saveSettings($form);
            $this->view->success(Yii::t('GravatarModule.base', 'Gravatar settings saved!'));
        }

        return $this->render('index', [
            'model' => $form
        ]);
    }
}