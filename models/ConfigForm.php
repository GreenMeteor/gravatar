<?php

namespace humhub\modules\gravatar\models;

use Yii;
use yii\base\Model;

/**
 * ConfigForm handles the module configuration form.
 */
class ConfigForm extends Model
{
    /**
     * @var string Default gravatar style
     */
    public $defaultStyle;
    
    /**
     * @var string Default gravatar rating
     */
    public $defaultRating;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['defaultStyle', 'required'],
            ['defaultStyle', 'in', 'range' => ['identicon', 'monsterid', 'wavatar', 'retro', 'robohash', 'blank']],
            ['defaultRating', 'required'],
            ['defaultRating', 'in', 'range' => ['g', 'pg', 'r', 'x']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'defaultStyle' => Yii::t('GravatarModule.base', 'Default Style'),
            'defaultRating' => Yii::t('GravatarModule.base', 'Default Rating'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'defaultStyle' => Yii::t('GravatarModule.base', 'Default style for Gravatar images when user has no custom avatar'),
            'defaultRating' => Yii::t('GravatarModule.base', 'Maximum content rating for Gravatar images'),
        ];
    }
    
    /**
     * Returns available style options
     * 
     * @return array
     */
    public function getStyleOptions()
    {
        return [
            'identicon' => Yii::t('GravatarModule.base', 'Identicon (geometric pattern)'),
            'monsterid' => Yii::t('GravatarModule.base', 'MonsterID (monster cartoon)'),
            'wavatar' => Yii::t('GravatarModule.base', 'Wavatar (faces)'),
            'retro' => Yii::t('GravatarModule.base', 'Retro (8-bit arcade)'),
            'robohash' => Yii::t('GravatarModule.base', 'RoboHash (robots)'),
            'blank' => Yii::t('GravatarModule.base', 'Blank (transparent)'),
        ];
    }
    
    /**
     * Returns available rating options
     * 
     * @return array
     */
    public function getRatingOptions()
    {
        return [
            'g' => Yii::t('GravatarModule.base', 'G (suitable for all audiences)'),
            'pg' => Yii::t('GravatarModule.base', 'PG (may contain rude gestures, provocatively dressed individuals, etc)'),
            'r' => Yii::t('GravatarModule.base', 'R (may contain harsh language, violence, nudity, etc)'),
            'x' => Yii::t('GravatarModule.base', 'X (may contain hardcore sexual imagery or extremely disturbing violence)'),
        ];
    }
}