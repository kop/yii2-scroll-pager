<?php

namespace kop\y2sp\assets;

use yii\web\AssetBundle;

/**
 * This is "InfiniteAjaxScrollAsset" class.
 *
 * This class is an asset bundle for {@link https://github.com/webcreate/infinite-ajax-scroll JQuery Infinite Ajax Scroll plugin}.
 *
 * @link      http://kop.github.io/yii2-scroll-pager Y2SP project page.
 * @license   https://github.com/kop/yii2-scroll-pager/blob/master/LICENSE.md MIT
 *
 * @author    Ivan Koptiev <ikoptev@gmail.com>
 * @version   2.1.1
 */
class InfiniteAjaxScrollAsset extends AssetBundle
{
    /**
     * @var string The root directory of the source asset files.
     */
    public $sourcePath = '@vendor/kop/yii2-scroll-pager/assets/infinite-ajax-scroll';

    /**
     * @var array List of bundle class names that this bundle depends on.
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    /**
     * @var array $js List of CSS files that this bundle contains.
     */
    public $js = [
        'jquery-ias.min.js'
    ];
}
