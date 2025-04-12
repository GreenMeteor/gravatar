<?php

namespace humhub\modules\gravatar\widgets;

use humhub\modules\user\widgets\Image as BaseUserImage;
use humhub\modules\gravatar\helpers\ProfileImageHelper;

class UserImage extends BaseUserImage
{
    /**
     * @var \humhub\modules\user\models\User User instance
     */
    public $user;
    
    /**
     * @var int Width of the image
     */
    public $width = 150;
    
    /**
     * @var int Height of the image
     */
    public $height = 150;
    
    /**
     * @var array HTML options for the image tag
     */
    public $htmlOptions = [];
    
    /**
     * @var string CSS class (will be added to htmlOptions)
     */
    public $class;
    
    /**
     * @var string CSS style (will be added to htmlOptions)
     */
    public $style;

    /**
     * @inheritdoc
     */
    public function run()
    {
        // Merge class if set separately
        if ($this->class !== null) {
            $this->htmlOptions['class'] = $this->htmlOptions['class'] ?? '';
            $this->htmlOptions['class'] .= ' ' . $this->class;
            $this->htmlOptions['class'] = trim($this->htmlOptions['class']);
        }
        
        // Add style if set
        if ($this->style !== null) {
            $this->htmlOptions['style'] = $this->style;
        }
        
        // Set dimensions
        $this->htmlOptions['width'] = $this->width;
        $this->htmlOptions['height'] = $this->height;
        
        return ProfileImageHelper::getProfileImageTag($this->user, $this->width, $this->htmlOptions);
    }
}