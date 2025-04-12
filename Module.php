<?php

namespace humhub\modules\gravatar;

use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\gravatar\models\ConfigForm;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use yii\helpers\Url;

/**
 * Gravatar Module for HumHub
 */
class Module extends \humhub\components\Module
{
    /**
     * @inheritdoc
     */
    public $resourcesPath = 'resources';

    /**
     * @var string Default gravatar style (identicon, monsterid, wavatar, retro, robohash, blank)
     */
    public $defaultStyle = 'identicon';

    /**
     * @var string Default gravatar rating (g, pg, r, x)
     */
    public $defaultRating = 'g';

    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/gravatar/admin/index']);
    }

    /**
     * @inheritdoc
     */
    public function disable()
    {
        // Clear assets on disable
        parent::disable();
    }

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer instanceof Space) {
            return [];
        } elseif ($contentContainer instanceof User) {
            return [];
        }

        return [];
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Gravatar';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Uses Gravatar as fallback profile images for users.';
    }

    /**
     * Get config form model
     * 
     * @return ConfigForm
     */
    public function getConfigModel()
    {
        $model = new ConfigForm();
        $model->defaultStyle = $this->settings->get('defaultStyle', $this->defaultStyle);
        $model->defaultRating = $this->settings->get('defaultRating', $this->defaultRating);

        return $model;
    }
    
    /**
     * Save module settings
     * 
     * @param ConfigForm $form
     * @return bool
     */
    public function saveSettings(ConfigForm $form)
    {
        $this->settings->set('defaultStyle', $form->defaultStyle);
        $this->settings->set('defaultRating', $form->defaultRating);

        return true;
    }
}