<?php

namespace humhub\modules\gravatar\helpers;

use humhub\libs\ProfileImage;
use humhub\modules\gravatar\Module;
use humhub\modules\user\models\User;
use humhub\libs\Html;
use Yii;

class ProfileImageHelper
{
    /**
     * Tracks which user IDs have already had missing email warnings logged
     * @var array
     */
    private static $warnedMissingEmailUsers = [];

    /**
     * Flag to track if empty email warning has been logged
     * @var bool
     */
    private static $warnedEmptyEmail = false;

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

        if (isset($user->email) && $user->email !== null) {
            return self::getGravatarUrl($user->email, $size);
        }

        if (!isset(self::$warnedMissingEmailUsers[$user->id])) {
            Yii::warning(
                'Missing email for user ' . Html::encode($user->displayName) . '. ' . 'Possible soft-deleted account or registration issue. Using default image instead.',
                'gravatar'
            );

            self::$warnedMissingEmailUsers[$user->id] = true;
        }

        return self::getDefaultImageUrl($size);
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
        if (empty($email)) {
            if (!self::$warnedEmptyEmail) {
                Yii::warning("Empty email provided to getGravatarUrl(). Using default image instead.", 'gravatar');
                self::$warnedEmptyEmail = true;
            }
            return self::getDefaultImageUrl($size, $style, $rating);
        }

        $hash = md5(strtolower(trim($email)));

        /** @var Module $module */
        $module = Yii::$app->getModule('gravatar');

        $style = $style ?? $module->settings->get('defaultStyle', $module->defaultStyle);
        $rating = $rating ?? $module->settings->get('defaultRating', $module->defaultRating);

        return "https://www.gravatar.com/avatar/$hash?s=$size&d=$style&r=$rating";
    }

    /**
     * Get the default image URL when no email is available
     * 
     * @param int $size
     * @param string|null $style
     * @param string|null $rating
     * @return string
     */
    public static function getDefaultImageUrl(int $size = 150, ?string $style = null, ?string $rating = null): string
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('gravatar');

        $style = $style ?? $module->settings->get('defaultStyle', $module->defaultStyle);
        $rating = $rating ?? $module->settings->get('defaultRating', $module->defaultRating);

        return "https://www.gravatar.com/avatar/00000000000000000000000000000000?s=$size&d=$style&r=$rating";
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
    
    /**
     * Returns a user display name as a link to their profile using HumHub's Html::containerLink
     * 
     * @param User $user
     * @param array $options HTML options for the link
     * @return string
     */
    public static function getUserDisplayNameLink(User $user, array $options = []): string
    {
        return Html::containerLink($user, $options);
    }
}
