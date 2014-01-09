<?php

namespace kop\y2sp;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\base\Widget;
use yii\web\JsExpression;
use yii\widgets\LinkPager;
use kop\y2sp\assets\InfiniteAjaxScrollAsset;

/**
 * ScrollPager turns your regular paginated page into an infinite scrolling page using AJAX.
 *
 * ScrollPager works with a [[Pagination]] object which specifies the totally number of pages and the current page number.
 *
 * <br>
 * <i>Example usage:</i>
 * <code>
 * echo ListView::widget([
 *      'dataProvider' => $dataProvider,
 *      'itemOptions' => ['class' => 'item'],
 *      'itemView' => '_item_view',
 *      'pager' => ['class' => \kop\y2sp\ScrollPager::className()]
 * ]);
 * </code>
 *
 * This widget is using {@link https://github.com/webcreate/infinite-ajax-scroll JQuery Infinite Ajax Scroll plugin}.
 *
 * @link      http://kop.github.io/yii2-scroll-pager Y2SP project page.
 * @license   https://github.com/kop/yii2-scroll-pager/blob/master/LICENSE.md MIT
 *
 * @author    Ivan Koptiev <ikoptev@gmail.com>
 * @version   0.1
 */
class ScrollPager extends Widget
{
    /**
     * @var string $container Enter the selector of the element containing your items that you want to paginate.
     */
    public $container = '.list-view';

    /**
     * @var string $item Enter the selector of the element that each item has.
     * Make sure the elements are inside the container element.
     */
    public $item = '.item';

    /**
     * @var bool|string $noneLeft Contains the message to be displayed when there are no more pages left to load.
     * FALSE means no message.
     */
    public $noneLeft = false;

    /**
     * @var string $loader Loader spinner.
     * This HTML element will be displayed when the next page with items is loaded via AJAX.
     */
    public $loader;

    /**
     * @var int $loaderDelay Minimal time (in milliseconds) the loader should be displayed before rendering the
     * items of the next page. Note: This setting will not actually delay the the loading of items itself.
     */
    public $loaderDelay = 600;

    /**
     * @var int $triggerPageThreshold Page number after which a 'Load more items' link is displayed.
     * Users will manually trigger the loading of the next page by clicking this link.
     */
    public $triggerPageThreshold = 3;

    /**
     * @var string $trigger Text of the manual trigger link.
     */
    public $trigger = 'Load more items';

    /**
     * @var int $thresholdMargin On default IAS starts loading new items when you scroll to the latest .item element.
     * The thresholdMargin will be added to the items' offset, giving you the ability to load new items earlier
     * (please note that the margin should be a negative integer for this case).
     * <br><br>
     * <i>For example:</i>
     * <br>
     * Setting a thresholdMargin of -250 means that IAS will start loading 250 pixel before the last item has scrolled
     * into view. A positive margin means that IAS will laod new items N pixels after the last item.
     */
    public $thresholdMargin = 0;

    /**
     * @var bool $history The IAS history module uses hashes (in the format "#/page/") to remember the last viewed page,
     * so when a visitor hits the back button after visiting an item from that page,
     * it will load all items up to that last page and scrolls it into view.
     * The use of hashes can be problematic in some cases, in which case you can disable this feature.
     */
    public $history = true;

    /**
     * @var string $scrollContainer By default, scroll events are listened from the $(window) object.
     * You can use this setting to specify a custom container, for example a div with overflow.
     */
    public $scrollContainer = '$(window)';

    /**
     * @var \yii\data\Pagination The pagination object that this pager is associated with.
     * You must set this property in order to make ScrollPager work.
     */
    public $pagination;

    /**
     * Executes the widget.
     *
     * This overrides the parent implementation by initializing jQuery IAS and displaying the generated page buttons.
     */
    public function run()
    {
        // Register required assets
        InfiniteAjaxScrollAsset::register($this->view);
        $bundleUrl = $this->view->getAssetManager()->getPublishedUrl((new InfiniteAjaxScrollAsset())->sourcePath);

        // Set default loader spinner if not set
        if ($this->loader === null) {
            $this->loader = Html::img("{$bundleUrl}/images/loader.gif", 'Loading...');
        }

        // Initialize jQuery IAS plugin
        $pluginSettings = Json::encode([
            'container' => $this->container,
            'item' => $this->item,
            'pagination' => "{$this->container} .pagination",
            'next' => '.next a',
            'noneleft' => $this->noneLeft,
            'loader' => $this->loader,
            'loaderDelay' => $this->loaderDelay,
            'triggerPageTreshold' => $this->triggerPageThreshold,
            'trigger' => $this->trigger,
            'tresholdMargin' => $this->thresholdMargin,
            'history' => $this->history,
            'scrollContainer' => $this->scrollContainer
        ]);
        $this->view->registerJs(new JsExpression("jQuery.ias({$pluginSettings});"), View::POS_READY);

        // Render pagination links
        echo LinkPager::widget([
            'pagination' => $this->pagination
        ]);
    }
}
