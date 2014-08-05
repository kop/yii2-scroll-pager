<?php

namespace kop\y2sp;

use kop\y2sp\assets\InfiniteAjaxScrollAsset;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\i18n\PhpMessageSource;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\LinkPager;
use Yii;

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
 * This widget is using {@link http://infiniteajaxscroll.com/ JQuery Infinite Ajax Scroll plugin}.
 *
 * @link      http://kop.github.io/yii2-scroll-pager Y2SP project page.
 * @license   https://github.com/kop/yii2-scroll-pager/blob/master/LICENSE.md MIT
 *
 * @author    Ivan Koptiev <ikoptev@gmail.com>
 * @version   2.1.2
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
    public $negativeMargin = 10;

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
     *
     * @throws \yii\base\InvalidConfigException
     * @return mixed
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
        $this->view->registerJs(
            "var {$this->id}_ias = jQuery.ias({$pluginSettings});",
            View::POS_READY,
            "{$this->id}_ias_main"
        );

        // Register IAS extensions
        $this->registerExtensions([
            [
                'name' => self::EXTENSION_PAGING
            ],
            [
                'name' => self::EXTENSION_SPINNER,
                'options' =>
                    !empty($this->spinnerSrc)
                        ? ['html' => $this->spinnerTemplate, 'src' => $this->spinnerSrc]
                        : ['html' => $this->spinnerTemplate]
            ],
            [
                'name' => self::EXTENSION_TRIGGER,
                'options' => [
                    'text' => $this->triggerText,
                    'html' => $this->triggerTemplate,
                    'offset' => $this->triggerOffset
                ]
            ],
            [
                'name' => self::EXTENSION_NONE_LEFT,
                'options' => [
                    'text' => $this->noneLeftText,
                    'html' => $this->noneLeftTemplate
                ]
            ],
            [
                'name' => self::EXTENSION_HISTORY,
                'options' => [
                    'prev' => $this->historyPrev
                ],
                'depends' => [
                    self::EXTENSION_TRIGGER,
                    self::EXTENSION_PAGING
                ]
            ]
        ]);

        // Register event handlers
        $this->registerEventHandlers([
            'scroll' => [],
            'load' => [],
            'loaded' => [],
            'render' => [],
            'rendered' => [],
            'noneLeft' => [],
            'next' => [],
            'ready' => [],
            'pageChange' => [
                self::EXTENSION_PAGING
            ]
        ]);

        // Render pagination links
        echo LinkPager::widget([
            'pagination' => $this->pagination,
            'options' => [
                'class' => 'pagination hidden'
            ]
        ]);
    }

    /**
     * Register jQuery IAS extensions.
     *
     * This method takes jQuery IAS extensions definition as a parameter and registers this extensions.
     *
     * @param array $config jQuery IAS extensions definition.
     * @throws \yii\base\InvalidConfigException If extension dependencies are not met.
     */
    protected function registerExtensions(array $config)
    {
        foreach ($config as $entry) {

            // Parse config entry values
            $name = ArrayHelper::getValue($entry, 'name', false);
            $options = ArrayHelper::getValue($entry, 'options', '');
            $depends = ArrayHelper::getValue($entry, 'depends', []);

            // If extension is enabled
            if (in_array($name, $this->enabledExtensions)) {

                // Make sure dependencies are met
                if (!$this->checkEnabledExtensions($depends)) {
                    throw new InvalidConfigException(
                        "Extension {$name} requires " . implode(', ', $depends) . " extensions to be enabled."
                    );
                }

                // Register extension
                $options = Json::encode($options);
                $this->view->registerJs(
                    "{$this->id}_ias.extension(new {$name}({$options}));",
                    View::POS_READY,
                    "{$this->id}_ias_{$name}"
                );
            }
        }
    }

    /**
     * Register jQuery IAS event handlers.
     *
     * This method takes jQuery IAS event handlers definition as a parameter and registers this event handlers.
     *
     * @param array $config jQuery IAS event handlers definition.
     * @throws \yii\base\InvalidConfigException If vent handlers dependencies are not met.
     */
    protected function registerEventHandlers(array $config)
    {
        foreach ($config as $name => $depends) {

            // If event is enabled
            $eventName = 'eventOn' . ucfirst($name);
            if (!empty($this->$eventName)) {

                // Make sure dependencies are met
                if (!$this->checkEnabledExtensions($depends)) {
                    throw new InvalidConfigException(
                        "The \"{$name}\" event requires " . implode(', ', $depends) . " extensions to be enabled."
                    );
                }

                // Register event
                $this->view->registerJs(
                    "jQuery.ias().on('{$name}', {$this->$eventName});",
                    View::POS_READY,
                    "{$this->id}_ias_{$name}"
                );
            }
        }
    }

    /**
     * Check whether the given extensions are enabled.
     *
     * @param string|array $extensions Single or multiple extensions names.
     * @return bool Operation result.
     */
    protected function checkEnabledExtensions($extensions)
    {
        $extensions = (array) $extensions;
        if (empty($extensions)) {
            return true;
        } else {
            return (count(array_intersect($this->enabledExtensions, $extensions)) == count($extensions));
        }
    }
}