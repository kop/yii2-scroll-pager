<?php

namespace kop\y2sp\assets;

use yii\web\AssetBundle;

/**
 * This is "InfiniteAjaxScrollAsset" class.
 *
 * This class is an asset bundle for {@link http://infiniteajaxscroll.com/ JQuery Infinite Ajax Scroll plugin}.
 *
 * @link      http://kop.github.io/yii2-scroll-pager Y2SP project page.
 * @license   https://github.com/kop/yii2-scroll-pager/blob/master/LICENSE.md MIT
 *
 * @author    Ivan Koptiev <ivan.koptiev@codex.systems>
 * @version   2.2
 */
class InfiniteAjaxScrollAsset extends AssetBundle
{
    /**
     * @var array List of bundle class names that this bundle depends on.
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = '@vendor/webcreate/jquery-ias/src';
        $this->js = [
            'callbacks.js',
            'jquery-ias.js',
            'extension/history.js',
            'extension/noneleft.js',
            'extension/paging.js',
            'extension/spinner.js',
            'extension/trigger.js'
        ];
    }
}
