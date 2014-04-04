<?php

namespace kop\y2sp;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\JsExpression;
use yii\web\View;
use yii\base\Widget;
use yii\helpers\Json;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use yii\i18n\PhpMessageSource;
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
 * @version   2.1.0
 */
class ScrollPager extends Widget
{
    /**
     * @const EXTENSION_TRIGGER IAS Extension "IASTriggerExtension".
     */
    const EXTENSION_TRIGGER = 'IASTriggerExtension';

    /**
     * @const EXTENSION_SPINNER IAS Extension "IASSpinnerExtension".
     */
    const EXTENSION_SPINNER = 'IASSpinnerExtension';

    /**
     * @const EXTENSION_NONE_LEFT IAS Extension "IASNoneLeftExtension".
     */
    const EXTENSION_NONE_LEFT = 'IASNoneLeftExtension';

    /**
     * @const EXTENSION_PAGING IAS Extension "IASPagingExtension".
     */
    const EXTENSION_PAGING = 'IASPagingExtension';

    /**
     * @const EXTENSION_HISTORY IAS Extension "IASHistoryExtension".
     */
    const EXTENSION_HISTORY = 'IASHistoryExtension';

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
     * @var int $delay Minimal number of milliseconds to stay in a loading state.
     */
    public $delay = 600;

    /**
     * @var int $thresholdMargin On default IAS starts loading new items when you scroll to the latest .item element.
     * The negativeMargin will be added to the items' offset, giving you the ability to load new items earlier
     * (please note that the margin is always transformed to a negative integer).
     * <br><br>
     * <i>For example:</i>
     * <br>
     * Setting a negativeMargin of 250 means that IAS will start loading 250 pixel before the last item has scrolled into view.
     */
    public $negativeMargin = 0;

    /**
     * @var string $triggerText Text of trigger the link.
     * Default: "Load more items".
     */
    public $triggerText;

    /**
     * @var string $triggerTemplate Allows you to override the trigger html template.
     */
    public $triggerTemplate = '<div class="ias-trigger" style="text-align: center; cursor: pointer;"><a>{text}</a></div>';

    /**
     * @var int $triggerOffset The number of pages which should load automatically.
     * After that the trigger is shown for every subsequent page.
     * <br><br>
     * <i>For example:</i>
     * <br>
     * if you set the offset to 2, the pages 2 and 3 (page 1 is always shown) would load automatically and for every
     * subsequent page the user has to press the trigger to load it.
     */
    public $triggerOffset = 0;

    /**
     * @var string $spinnerSrc The src attribute of the spinner image.
     */
    public $spinnerSrc;

    /**
     * @var string $spinnerTemplate Allows you to override the spinner html template.
     */
    public $spinnerTemplate = '<div class="ias-spinner" style="text-align: center;"><img src="{src}"/></div>';

    /**
     * @var string $noneLeftText Text of the "nothing left" message.
     * Default: "You reached the end".
     */
    public $noneLeftText;

    /**
     * @var string $noneLeftTemplate Allows you to override the "nothing left" message html template.
     */
    public $noneLeftTemplate = '<div class="ias-noneleft" style="text-align: center;">{text}</div>';

    /**
     * @var string $historyPrev Enter the selector of the link element that links to the previous page.
     * The href attribute of this element will be used to get the items from the previous page.
     * Make sure there is only one element that matches the selector.
     */
    public $historyPrev = '.previous';

    /**
     * @var string|JsExpression $eventOnScroll Triggered when the visitors scrolls.
     * @see http://infiniteajaxscroll.com/docs/events.html
     */
    public $eventOnScroll;

    /**
     * @var string|JsExpression $eventOnLoad Triggered when a new url will be loaded from the server.
     * @see http://infiniteajaxscroll.com/docs/events.html
     */
    public $eventOnLoad;

    /**
     * @var string|JsExpression $eventOnLoaded Triggered after a new page was loaded from the server.
     * @see http://infiniteajaxscroll.com/docs/events.html
     */
    public $eventOnLoaded;

    /**
     * @var string|JsExpression $eventOnRender Triggered before new items will be rendered.
     * @see http://infiniteajaxscroll.com/docs/events.html
     */
    public $eventOnRender;

    /**
     * @var string|JsExpression $eventOnRendered Triggered after new items have rendered.
     * Note: This event is only fired once.
     * @see http://infiniteajaxscroll.com/docs/events.html
     */
    public $eventOnRendered;

    /**
     * @var string|JsExpression $eventOnNoneLeft Triggered when there are no more pages left.
     * @see http://infiniteajaxscroll.com/docs/events.html
     */
    public $eventOnNoneLeft;

    /**
     * @var string|JsExpression $eventOnNext Triggered when the next page should be loaded.
     * Happens before loading of the next page starts. With this event it is possible to cancel the loading of the next page.
     * You can do this by returning false from your callback.
     * @see http://infiniteajaxscroll.com/docs/events.html
     */
    public $eventOnNext;

    /**
     * @var string|JsExpression $eventOnReady Triggered when IAS and all the extensions have been initialized.
     * @see http://infiniteajaxscroll.com/docs/events.html
     */
    public $eventOnReady;

    /**
     * @var string|JsExpression $eventOnPageChange Triggered when a used scroll to another page.
     * @see http://infiniteajaxscroll.com/docs/extension-paging.html
     */
    public $eventOnPageChange;

    /**
     * @var array $enabledExtensions The list of the enabled plugin extensions.
     */
    public $enabledExtensions = [
        self::EXTENSION_TRIGGER,
        self::EXTENSION_SPINNER,
        self::EXTENSION_NONE_LEFT,
        self::EXTENSION_PAGING,
        self::EXTENSION_HISTORY
    ];

    /**
     * @var \yii\data\Pagination The pagination object that this pager is associated with.
     * You must set this property in order to make ScrollPager work.
     */
    public $pagination;

    /**
     * Initializes the pager.
     */
    public function init()
    {
        parent::init();

        // Register translations source
        Yii::$app->i18n->translations = ArrayHelper::merge(Yii::$app->i18n->translations, [
            'kop\y2sp' => [
                'class' => PhpMessageSource::className(),
                'basePath' => '@vendor/kop/yii2-scroll-pager/messages',
                'fileMap' => [
                    'kop\y2sp' => 'general.php'
                ]
            ]
        ]);

        // Register required assets
        InfiniteAjaxScrollAsset::register($this->view);

        // Set default trigger text if not set
        if ($this->triggerText === null) {
            $this->triggerText = Yii::t('kop\y2sp', 'Load more items');
        }

        // Set default "none left" message text if not set
        if ($this->noneLeftText === null) {
            $this->noneLeftText = Yii::t('kop\y2sp', 'You reached the end');
        }
    }

    /**
     * Executes the widget.
     *
     * This overrides the parent implementation by initializing jQuery IAS and displaying the generated page buttons.
     */
    public function run()
    {
        // Initialize jQuery IAS plugin
        $pluginSettings = Json::encode([
            'container' => $this->container,
            'item' => $this->item,
            'pagination' => "{$this->container} .pagination",
            'next' => '.next a',
            'delay' => $this->delay,
            'negativeMargin' => $this->negativeMargin
        ]);
        $this->view->registerJs("var {$this->id}_ias = jQuery.ias({$pluginSettings});", View::POS_READY);

        // Register "IASTriggerExtension"
        if (in_array(self::EXTENSION_TRIGGER, $this->enabledExtensions)) {
            $triggerSettings = Json::encode([
                'text' => $this->triggerText,
                'html' => $this->triggerTemplate,
                'offset' => $this->triggerOffset
            ]);
            $this->view->registerJs(
                "{$this->id}_ias.extension(new IASTriggerExtension({$triggerSettings}));",
                View::POS_READY
            );
        }

        // Register "IASSpinnerExtension"
        if (in_array(self::EXTENSION_SPINNER, $this->enabledExtensions)) {
            $spinnerSettings = Json::encode([
                'src' => $this->spinnerSrc,
                'html' => $this->spinnerTemplate
            ]);
            $this->view->registerJs(
                "{$this->id}_ias.extension(new IASSpinnerExtension({$spinnerSettings}));",
                View::POS_READY
            );
        }

        // Register "IASNoneLeftExtension"
        if (in_array(self::EXTENSION_NONE_LEFT, $this->enabledExtensions)) {
            $noneLeftSettings = Json::encode([
                'text' => $this->noneLeftText,
                'html' => $this->noneLeftTemplate
            ]);
            $this->view->registerJs(
                "{$this->id}_ias.extension(new IASNoneLeftExtension({$noneLeftSettings}));",
                View::POS_READY
            );
        }

        // Register "IASPagingExtension"
        if (in_array(self::EXTENSION_PAGING, $this->enabledExtensions)) {
            $this->view->registerJs("{$this->id}_ias.extension(new IASPagingExtension());", View::POS_READY);
        }

        // Register "IASHistoryExtension"
        if (in_array(self::EXTENSION_HISTORY, $this->enabledExtensions)) {

            // Make sure dependencies are met
            if (
                !in_array(self::EXTENSION_TRIGGER, $this->enabledExtensions)
                || !in_array(self::EXTENSION_TRIGGER, $this->enabledExtensions)
            ) {
                throw new InvalidConfigException(
                    'This IASHistoryExtension requires the IASTriggerExtension and the IASPagingExtension to be enabled.'
                );
            }

            $historySettings = Json::encode([
                'prev' => $this->noneLeftText
            ]);
            $this->view->registerJs(
                "{$this->id}_ias.extension(new IASHistoryExtension({$historySettings}));",
                View::POS_READY
            );
        }

        // Register event handlers
        if (!empty($this->eventOnScroll)) {
            $this->view->registerJs("jQuery.ias().on('scroll', {$this->eventOnScroll});", View::POS_READY);
        }
        if (!empty($this->eventOnLoad)) {
            $this->view->registerJs("jQuery.ias().on('load', {$this->eventOnLoad});", View::POS_READY);
        }
        if (!empty($this->eventOnLoaded)) {
            $this->view->registerJs("jQuery.ias().on('loaded', {$this->eventOnLoaded});", View::POS_READY);
        }
        if (!empty($this->eventOnRender)) {
            $this->view->registerJs("jQuery.ias().on('render', {$this->eventOnRender});", View::POS_READY);
        }
        if (!empty($this->eventOnRendered)) {
            $this->view->registerJs("jQuery.ias().on('rendered', {$this->eventOnRendered});", View::POS_READY);
        }
        if (!empty($this->eventOnNoneLeft)) {
            $this->view->registerJs("jQuery.ias().on('noneLeft', {$this->eventOnNoneLeft});", View::POS_READY);
        }
        if (!empty($this->eventOnNext)) {
            $this->view->registerJs("jQuery.ias().on('next', {$this->eventOnNext});", View::POS_READY);
        }
        if (!empty($this->eventOnReady)) {
            $this->view->registerJs("jQuery.ias().on('ready', {$this->eventOnReady});", View::POS_READY);
        }
        if (!empty($this->eventOnPageChange)) {

            // Make sure dependencies are met
            if (!in_array(self::EXTENSION_PAGING, $this->enabledExtensions)) {
                throw new InvalidConfigException(
                    'The "pageChange" event requires the IASPagingExtension to be enabled.'
                );
            }

            $this->view->registerJs("jQuery.ias().on('pageChange', {$this->eventOnPageChange});", View::POS_READY);
        }

        // Render pagination links
        echo LinkPager::widget([
            'pagination' => $this->pagination,
            'options' => [
                'class' => 'pagination hidden'
            ]
        ]);
    }
}