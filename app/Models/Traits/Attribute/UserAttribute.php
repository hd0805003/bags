<?php

namespace App\Models\Traits\Attribute;

use Config;
use Image;

trait UserAttribute
{
    //checkbox按钮
    public function getCheckboxButtonAttribute()
    {
        return '<input type="checkbox" name="id[]" value="'.$this->id.'">';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route(env('APP_BACKEND_PREFIX').'.users.edit', $this->id) . '" class="btn btn-xs blue"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="编辑"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route(env('APP_BACKEND_PREFIX').'.users.destroy', $this->id) . '" data-method="destroy" class="btn btn-xs red"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="删除"></i></a>';
    }

    /**
     * 用户按钮
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getEditButtonAttribute() .
        $this->getDeleteButtonAttribute();
    }

    //设置用户头像访问器
    public function getAvatarAttribute($value)
    {
        if ($value) {
            $avatar['_default'] = $value;
            $avatarPath = str_replace('.png', '', $value);
            $avatar['small'] = $this->avatarMulti($avatarPath, 'small');
            $avatar['medium'] = $this->avatarMulti($avatarPath, 'medium');
            $avatar['large'] = $this->avatarMulti($avatarPath, 'large');
        } else {
            $avatar['_default'] = '';
            $avatar['small'] = '';
            $avatar['medium'] = '';
            $avatar['large'] = '';
        }
        return $avatar;
    }

    public function avatarMulti($url, $size)
    {
        $avatarPath = asset($url.'_'.config('avatar.'.$size.'.size').'x'.config('avatar.'.$size.'.size').'.png');
        return $avatarPath;
    }
}
