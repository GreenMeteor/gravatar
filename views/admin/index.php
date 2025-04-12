<?php

use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\widgets\Button;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model \humhub\modules\gravatar\models\ConfigForm */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('GravatarModule.base', '<strong>Gravatar</strong> module configuration'); ?>
    </div>

    <div class="panel-body">
        <div class="help-block">
            <?= Yii::t('GravatarModule.base', 'This module provides Gravatar integration for HumHub. If a user does not have a profile image, their Gravatar will be displayed instead.'); ?>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'configure-form']); ?>

        <?= $form->field($model, 'defaultStyle')->dropDownList($model->getStyleOptions()); ?>

        <div class="help-block">
            <?= Yii::t('GravatarModule.base', 'This is the style that will be used for users who do not have a Gravatar account.'); ?>
            <br>
            <?= Yii::t('GravatarModule.base', 'Learn more about Gravatar default images at {link}.', [
                'link' => Html::a('https://en.gravatar.com/site/implement/images/', 'https://en.gravatar.com/site/implement/images/', ['target' => '_blank'])
            ]); ?>
        </div>

        <?= $form->field($model, 'defaultRating')->dropDownList($model->getRatingOptions()); ?>

        <div class="help-block">
            <?= Yii::t('GravatarModule.base', 'This sets the maximum content rating for Gravatar images.'); ?>
        </div>

        <div class="form-group">
            <?= Button::save()->submit() ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('GravatarModule.base', '<strong>Gravatar</strong> preview'); ?>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <p><?= Yii::t('GravatarModule.base', 'Here are some examples of the default Gravatar styles:'); ?></p>
            </div>
        </div>
        <div class="row text-center">
            <?php
            $styles = ['identicon', 'monsterid', 'wavatar', 'retro', 'robohash'];
            $email = 'example@example.com';
            $hash = md5(strtolower(trim($email)));
            $size = 80;

            foreach ($styles as $style): ?>
                <div class="col-md-2 col-sm-4 col-xs-6" style="margin-bottom: 20px;">
                    <img src="https://www.gravatar.com/avatar/<?= $hash ?>?s=<?= $size ?>&d=<?= $style ?>&r=g" 
                         class="img-circle" 
                         width="<?= $size ?>" 
                         height="<?= $size ?>"
                         alt="<?= $style ?>">
                    <p><?= ucfirst($style) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>