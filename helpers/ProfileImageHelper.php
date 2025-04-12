<?php

namespace humhub\modules\gravatar\helpers;

use humhub\libs\ProfileImage;
use humhub\modules\gravatar\Module;
use humhub\modules\user\models\User;
use Yii;
use yii\helpers\Html;

class ProfileImageHelper
{
    /**
     * Get the profile image URL or Gravatar fallback.
     *
     * @param User $user
     * @param int $size
     * @return string
     */
    public static function getProfileImageUrl(User $user, int $size = 150): string
    {
        $profileImage = new ProfileImage($user);

        if ($profileImage->hasImage()) {
            return $profileImage->getUrl();
        }

        return self::getGravatarUrl($user->email, $size);
    }

    /**
     * Returns a full <img> tag for the user image (with gravatar fallback).
     *
     * @param User $user
     * @param int $size
     * @param array $htmlOptions
     * @return string
     */
    public static function getProfileImageTag(User $user, int $size = 150, array $htmlOptions = []): string
    {
        $htmlOptions['width'] = $size;
        $htmlOptions['height'] = $size;
        $htmlOptions['class'] = $htmlOptions['class'] ?? 'img-circle';

        return Html::img(self::getProfileImageUrl($user, $size), $htmlOptions);
    }

    /**
     * Get a gravatar URL from an email.
     *
     * @param string $email
     * @param int $size
     * @param string|null $style
     * @param string|null $rating
     * @return string
     */
    public static function getGravatarUrl(string $email, int $size = 150, ?string $style = null, ?string $rating = null): string
    {
        $hash = md5(strtolower(trim($email)));

        /** @var Module $module */
        $module = Yii::$app->getModule('gravatar');

        $style = $style ?? $module->settings->get('defaultStyle', $module->defaultStyle);
        $rating = $rating ?? $module->settings->get('defaultRating', $module->defaultRating);

        return "https://www.gravatar.com/avatar/$hash?s=$size&d=$style&r=$rating";
    }

    /**
     * Check if a user should use gravatar
     * 
     * @param string $guid The user's GUID
     * @return bool True if gravatar should be used
     */
    public static function shouldUseGravatar($guid)
    {
        $module = Yii::$app->getModule('gravatar');

        $imagePath = Yii::getAlias('@webroot/uploads/profile_image/') . $guid . '.jpg';
        if (file_exists($imagePath)) {
            return false;
        }

        return true;
    }
}