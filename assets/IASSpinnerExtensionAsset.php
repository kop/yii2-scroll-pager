<?php

namespace kop\y2sp\assets;

use yii\web\AssetBundle;


/**
 * Class IASSpinnerExtensionAsset
 * @package kop\y2sp\assets
 */
class IASSpinnerExtensionAsset extends AssetBundle
{

    public $sourcePath = '@vendor/webcreate/jquery-ias/src';

    public $js = [
        'extension/spinner.js'
    ];

    /**
     * @var array List of bundle class names that this bundle depends on.
     */
    public $depends = [
        'kop\y2sp\assets\InfiniteAjaxScrollAsset',
    ];

}
