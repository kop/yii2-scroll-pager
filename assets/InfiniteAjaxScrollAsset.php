<?php

namespace kop\y2sp\assets;

use yii\web\AssetBundle;

/**
 * This is "InfiniteAjaxScrollAsset" class.
 *
 * This class is a Yii2 asset bundle for JQuery Infinite Ajax Scroll plugin.
 *
 * @link      http://kop.github.io/yii2-scroll-pager Y2SP project page.
 * @link      https://github.com/webcreate/infinite-ajax-scroll JQuery IAS project page.
 *
 * @license   https://github.com/kop/yii2-scroll-pager/blob/master/LICENSE.md MIT
 *
 * @author    Ivan Koptiev <ikoptev@gmail.com>
 * @version   1.0.2
 */
class InfiniteAjaxScrollAsset extends AssetBundle
{
    /**
     * @var string The root directory of the source asset files.
     */
    public $sourcePath = '@vendor/kop/yii2-scroll-pager/kop/y2sp/assets/infinite-ajax-scroll/dist';

    /**
     * @var array List of bundle class names that this bundle depends on.
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    /**
     * @var array List of CSS files that this bundle contains.
     */
    public $css = [
        'css/jquery.ias.css'
    ];

    /**
     * Initializes the bundle.
     */
    public function init()
    {
        parent::init();

        $this->js = [
            (YII_DEBUG) ? 'jquery-ias.js' : 'jquery-ias.min.js'
        ];
    }
}
