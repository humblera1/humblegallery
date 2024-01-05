<?php

namespace backend\components\widgets;

use yii\widgets\ActiveField;

class HumbleActiveField extends ActiveField
{
//    public $options = ['class' => 'humble-form-group'];
    public $inputOptions = ['class' => 'humble-form-control'];

    public $labelOptions = ['class' => 'humble-control-label'];
}
