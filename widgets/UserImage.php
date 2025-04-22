<?php

namespace humhub\modules\gravatar\widgets;

use humhub\modules\user\widgets\Image as BaseUserImage;
use humhub\modules\gravatar\helpers\ProfileImageHelper;
use humhub\modules\user\services\IsOnlineService;
use humhub\modules\user\models\User;
use humhub\libs\Html;
use Yii;

/**
 * UserImage extends the base Image class and integrates with Gravatar
 */
class UserImage extends BaseUserImage
{
    /**
     * @var array HTML options for the image tag
     */
    public $htmlOptions = [];

    /**
     * @var string Additional CSS class for image
     */
    public $class;

    /**
     * @var string CSS style (will be added to htmlOptions)
     */
    public $style;

    /**
     * @inheritdoc
     */
    public function beforeRun()
    {
        return parent::beforeRun() && $this->user instanceof User;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->user->status === User::STATUS_SOFT_DELETED) {
            $this->link = false;
        }

        if ($this->class !== null) {
            if (!isset($this->imageOptions['class'])) {
                $this->imageOptions['class'] = '';
            }
            $this->imageOptions['class'] .= ' ' . $this->class;
            $this->imageOptions['class'] = trim($this->imageOptions['class']);
        }

        if ($this->style !== null) {
            $this->imageOptions['style'] = $this->style;
        }

        Html::addCssClass($this->imageOptions, 'img-rounded');
        Html::addCssStyle($this->imageOptions, 'width: ' . $this->width . 'px; height: ' . $this->height . 'px');

        if ($this->tooltipText || $this->showTooltip) {
            $this->imageOptions['data-toggle'] = 'tooltip';
            $this->imageOptions['data-placement'] = 'top';
            $this->imageOptions['data-html'] = 'true';
            $this->imageOptions['data-original-title'] = $this->tooltipText ?: Html::encode($this->user->displayName);
            Html::addCssClass($this->imageOptions, 'tt');
        }

        $this->imageOptions['data-contentcontainer-id'] = $this->user->contentcontainer_id;
        $this->imageOptions['alt'] = Yii::t('base', 'Profile picture of {displayName}', ['displayName' => Html::encode($this->user->displayName)]);

        $imageUrl = ProfileImageHelper::getProfileImageUrl($this->user, $this->width);

        $html = Html::img($imageUrl, $this->imageOptions);

        $isOnlineService = new IsOnlineService($this->user);
        if (
            !$this->hideOnlineStatus
            && ($this->showSelfOnlineStatus || $this->user->id !== Yii::$app->user->id)
            && $isOnlineService->isEnabled()
        ) {
            $imgSize = 'img-size-medium';
            if ($this->width < 28) {
                $imgSize = 'img-size-small';
            } elseif ($this->width > 48) {
                $imgSize = 'img-size-large';
            }

            if ($this->link) {
                Html::addCssClass($this->linkOptions, ['has-online-status', $imgSize]);
            } else {
                Html::addCssClass($this->htmlOptions, ['has-online-status', $imgSize]);
            }

            $userIsOnline = $isOnlineService->getStatus();
            $html .= Html::tag('span', '', [
                'class' => ['tt user-online-status', $userIsOnline ? 'user-is-online' : 'user-is-offline'],
                'title' => $userIsOnline ?
                    Yii::t('UserModule.base', 'Online') :
                    Yii::t('UserModule.base', 'Offline'),
            ]);
        }

        if ($this->link) {
            $html = Html::a($html, $this->user->getUrl(), $this->linkOptions);
        }

        return Html::tag('span', $html, $this->htmlOptions);
    }
}
