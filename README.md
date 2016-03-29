Yii2 Scroll Pager
=================

[Yii2 Scroll Pager (Y2SP)](http://kop.github.io/yii2-scroll-pager) turns your regular paginated page into an
infinite scrolling page using AJAX.

Y2SP works with a `Pagination` object which specifies the totally number of pages and the current page number.

Pager is build with help of [JQuery Infinite Ajax Scroll plugin](http://infiniteajaxscroll.com/).

[![Latest Stable Version](https://poser.pugx.org/kop/yii2-scroll-pager/v/stable.svg)](https://packagist.org/packages/kop/yii2-scroll-pager)
[![Code Climate](https://codeclimate.com/github/kop/yii2-scroll-pager.png)](https://codeclimate.com/github/kop/yii2-scroll-pager)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kop/yii2-scroll-pager/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kop/yii2-scroll-pager/?branch=master)
[![Dependency Status](https://gemnasium.com/kop/yii2-scroll-pager.svg)](https://gemnasium.com/kop/yii2-scroll-pager)
[![License](https://poser.pugx.org/kop/yii2-scroll-pager/license.svg)](https://packagist.org/packages/kop/yii2-scroll-pager)



## Requirements

- Yii 2.0
- PHP 5.4



## Installation

The preferred way to install this extension is through [Composer](http://getcomposer.org/).

Either run

``` php composer.phar require kop/yii2-scroll-pager "dev-master" ```

or add

``` "kop/yii2-scroll-pager": "dev-master"```

to the `require` section of your `composer.json` file.



## Usage

Just pass the ScrollPager class name to the ListView `pager` configuration.
Make sure that items in your list have some classes that can be used as JavaScript selectors.

### ListView

```php
echo ListView::widget([
     'dataProvider' => $dataProvider,
     'itemOptions' => ['class' => 'item'],
     'itemView' => '_item_view',
     'pager' => ['class' => \kop\y2sp\ScrollPager::className()]
]);
```

### GridView

```php
echo GridView::widget([
     'dataProvider' => $dataProvider,
     'pager' => [
        'class' => \kop\y2sp\ScrollPager::className(),
        'container' => '.grid-view tbody',
        'item' => 'tr',
        'paginationSelector' => '.grid-view .pagination',
        'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
     ],
]);
```


## Configuration


### General Options

| Option name  	     | Description  	| Default value |
|---	             |---	            |---	        |
| container  	     | The selector of the element containing your items that you want to paginate. | `.list-view` |
| item  	         | The selector of the element that each item has.<br Make sure the elements are inside the container element. | `.item` |
| paginationSelector | The selector of the element containing the pagination. | `.list-view .pagination` |
| next  	         | The selector of the link element that links to the next page.<br> The href attribute of this element will be used to get the items from the next page.<br> Make sure there is only one(1) element that matches the selector. | `.next a` |
| delay  	         | Minimal number of milliseconds to stay in a loading state. | `600` |
| negativeMargin  	 | By default IAS starts loading new items when you scroll to the latest `.item` element.<br> The `negativeMargin` will be added to the items offset, giving you the ability to load new items earlier (please note that the margin is always transformed to a negative integer).<br><br> *Example:* Setting a negativeMargin of 250 means that IAS will start loading 250 pixel before the last item has scrolled into view. | `10` |


### Extensions

| Option name  	     | Description  	| Default value |
|---	             |---	            |---	        |
| enabledExtensions  | The list of the enabled plugin extensions. | [<br>&emsp; `ScrollPager::EXTENSION_TRIGGER`, <br>&emsp; `ScrollPager::EXTENSION_SPINNER`, <br>&emsp; `ScrollPager::EXTENSION_NONE_LEFT`, <br>&emsp; `ScrollPager::EXTENSION_PAGING`, <br>&emsp; `ScrollPager::EXTENSION_HISTORY` <br>] |


### Extension Options

| Option name  	     | Description  	| Default value |
|---	             |---	            |---	        |
| triggerText  	     | Text of trigger the link. | `Load more items` |
| triggerTemplate  	 | Allows you to override the trigger html template. | `<div class="ias-trigger" style="text-align: center; cursor: pointer;"><a>{text}</a></div>` |
| triggerOffset  	 | The number of pages which should load automatically. After that the trigger is shown for every subsequent page.<br><br> *Example:* if you set the offset to 2, the pages 2 and 3 (page 1 is always shown) would load automatically and for every subsequent page the user has to press the trigger to load it. | `0` |
| spinnerSrc  	     | The src attribute of the spinner image. | ![Spinner Image](https://raw.githubusercontent.com/kop/yii2-scroll-pager/v1.0.2/assets/infinite-ajax-scroll/images/loader.gif) |
| spinnerTemplate  	 | Allows you to override the spinner html template. | `<div class="ias-spinner" style="text-align: center;"><img src="{src}"/></div>` |
| noneLeftText  	 | Text of the "nothing left" message. | `You reached the end` |
| noneLeftTemplate   | Allows you to override the "nothing left" message html template. | `<div class="ias-noneleft" style="text-align: center;">{text}</div>` |
| historyPrev  	     | The selector of the link element that links to the previous page.<br> The href attribute of this element will be used to get the items from the previous page.<br> Make sure there is only one element that matches the selector. | `.previous` |
| overflowContainer  | A selector for `div` HTML element to use as an overflow container. | `null` |


### Plugin Events

| Option name  	     | Description  	| Default value |
|---	             |---	            |---	        |
| eventOnScroll  	 | Triggered when the visitors scrolls. | `null` |
| eventOnLoad  	     | Triggered when a new url will be loaded from the server. | `null` |
| eventOnLoaded  	 | Triggered after a new page was loaded from the server. | `null` |
| eventOnRender  	 | Triggered before new items will be rendered. | `null` |
| eventOnRendered  	 | Triggered after new items have rendered. | `null` |
| eventOnNoneLeft  	 | Triggered when there are no more pages left. | `null` |
| eventOnNext  	     | Triggered when the next page should be loaded.<br> Happens before loading of the next page starts. With this event it is possible to cancel the loading of the next page.<br> You can do this by returning false from your callback. | `null` |
| eventOnReady  	 | Triggered when IAS and all the extensions have been initialized. | `null` |
| eventOnPageChange  | Triggered when a used scroll to another page. | `null` |



## Report

- Report any issues [on the GitHub](https://github.com/kop/yii2-scroll-pager/issues).



## License

**yii2-scroll-pager** is released under the MIT License. See the bundled `LICENSE.md` for details.



## Resources

- [Project Page](http://kop.github.io/yii2-scroll-pager)
- [Packagist Package](https://packagist.org/packages/kop/yii2-scroll-pager)
- [Source Code](https://github.com/kop/yii2-scroll-pager)