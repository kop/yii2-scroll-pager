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

```php
echo ListView::widget([
     'dataProvider' => $dataProvider,
     'itemOptions' => ['class' => 'item'],
     'itemView' => '_item_view',
     'pager' => ['class' => \kop\y2sp\ScrollPager::className()]
]);
```


## Configuration

### General Options

#### `container`

*Default:* ".list-view"

Enter the selector of the element containing your items that you want to paginate.

#### `item`

*Default:* ".item"

Enter the selector of the element that each item has. Make sure the elements are inside the container element.

#### `next`

*Default:* ".next a"

Enter the selector of the link element that links to the next page.
The href attribute of this element will be used to get the items from the next page.
Make sure there is only one(1) element that matches the selector.

#### `delay`

*Default:* 600

Minimal number of milliseconds to stay in a loading state.

#### `negativeMargin`

*Default:* 10

On default IAS starts loading new items when you scroll to the latest .item element.
The negativeMargin will be added to the items' offset, giving you the ability to load new items earlier (please note that the margin is always transformed to a negative integer).

For example:

Setting a negativeMargin of 250 means that IAS will start loading 250 pixel before the last item has scrolled into view.

### Extensions

#### `enabledExtensions`

*Default:*
`
Array(
    ScrollPager::EXTENSION_TRIGGER,
    ScrollPager::EXTENSION_SPINNER,
    ScrollPager::EXTENSION_NONE_LEFT,
    ScrollPager::EXTENSION_PAGING,
    ScrollPager::EXTENSION_HISTORY
)
`

The list of the enabled plugin extensions.

### Extension Options

#### `triggerText`

*Default:* "Load more items"

Text of trigger the link.

#### `triggerTemplate`

*Default:* "`<div class="ias-trigger" style="text-align: center; cursor: pointer;"><a>{text}</a></div>`"

Allows you to override the trigger html template.

#### `triggerOffset`

*Default:* 0

The number of pages which should load automatically. After that the trigger is shown for every subsequent page.

For example: if you set the offset to 2, the pages 2 and 3 (page 1 is always shown) would load automatically and for every subsequent page the user has to press the trigger to load it.

#### `spinnerSrc`

*Default:* ![Spinner Image](https://raw.githubusercontent.com/kop/yii2-scroll-pager/v1.0.2/assets/infinite-ajax-scroll/images/loader.gif)

The src attribute of the spinner image.

#### `spinnerTemplate`

*Default:* "`<div class="ias-spinner" style="text-align: center;"><img src="{src}"/></div>`"

Allows you to override the spinner html template.

#### `noneLeftText`

*Default:* "You reached the end"

Text of the "nothing left" message.

#### `noneLeftTemplate`

*Default:* "`<div class="ias-noneleft" style="text-align: center;">{text}</div>`"

Allows you to override the "nothing left" message html template.

#### `historyPrev`

*Default:* ".previous"

Enter the selector of the link element that links to the previous page.

The href attribute of this element will be used to get the items from the previous page.

Make sure there is only one element that matches the selector.

#### `overflowContainer`

*Default:* null

A selector for `div` HTML element to use as an overflow container.

### Plugin Events

#### `eventOnScroll`

*Default:* null

Triggered when the visitors scrolls.

#### `eventOnLoad`

*Default:* null

Triggered when a new url will be loaded from the server.

#### `eventOnLoaded`

*Default:* null

Triggered after a new page was loaded from the server.

#### `eventOnRender`

*Default:* null

Triggered before new items will be rendered.

#### `eventOnRendered`

*Default:* null

Triggered after new items have rendered.

#### `eventOnNoneLeft`

*Default:* null

Triggered when there are no more pages left.

#### `eventOnNext`

*Default:* null

Triggered when the next page should be loaded.

Happens before loading of the next page starts. With this event it is possible to cancel the loading of the next page.

You can do this by returning false from your callback.

#### `eventOnReady`

*Default:* null

Triggered when IAS and all the extensions have been initialized.

#### `eventOnPageChange`

*Default:* null

Triggered when a used scroll to another page.


## Report

- Report any issues [on the GitHub](https://github.com/kop/yii2-scroll-pager/issues).


## License

**yii2-scroll-pager** is released under the MIT License. See the bundled `LICENSE.md` for details.


## Resources

- [Project Page](http://kop.github.io/yii2-scroll-pager)
- [Packagist Package](https://packagist.org/packages/kop/yii2-scroll-pager)
- [Source Code](https://github.com/kop/yii2-scroll-pager)