<?php

namespace humhub\modules\gravatar;

use humhub\components\Event;
use humhub\modules\gravatar\helpers\ProfileImageHelper;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\modules\ui\menu\MenuLink;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\modules\admin\permissions\ManageModules;
use Yii;
use yii\base\BaseObject;
use yii\base\Event as BaseEvent;

/**
 * Events handler for Gravatar module
 */
class Events extends BaseObject
{
    /**
     * Bootstrap method for module
     * 
     * @param \yii\base\Application $app
     */
    public static function bootstrap($app)
    {
        self::registerEvents();
    }

    /**
     * Register event handlers for the module
     */
    protected static function registerEvents()
    {
        Yii::$container->set(\humhub\modules\user\widgets\Image::class, \humhub\modules\gravatar\widgets\UserImage::class);

        // Register the admin menu item
        Event::on(AdminMenu::class, AdminMenu::EVENT_INIT, [self::class, 'onAdminMenuInit']);
    }

    /**
     * Adds menu entry to admin menu
     *
     * @param BaseEvent $event
     */
    public static function onAdminMenuInit($event)
    {
        /** @var AdminMenu $menu */
        $menu = $event->sender;

        $menu->addEntry(new MenuLink([
            'label' => Yii::t('GravatarModule.base', 'Gravatar Settings'),
            'url' => ['/gravatar/admin/index'],
            'icon' => Icon::get('image'),
            'isActive' => Yii::$app->controller->module && Yii::$app->controller->module->id === 'gravatar',
            'sortOrder' => 650,
            'isVisible' => Yii::$app->user->can(ManageModules::class)
        ]));
    }
}