Yii2 Scroll Pager
=================

[Yii2 Scroll Pager (Y2SP)](http://kop.github.io/yii2-scroll-pager) turns your regular paginated page into an
infinite scrolling page using AJAX.

Y2SP works with a `Pagination` object which specifies the totally number of pages and the current page number.

Pager is build with help of [JQuery Infinite Ajax Scroll plugin](https://github.com/webcreate/infinite-ajax-scroll).


## Requirements

- Yii 2.0 (dev-master)
- PHP 5.4

> Note:
This extension mandatorily requires [Yii Framework 2](https://github.com/yiisoft/yii2).
The framework is under active development and the first stable release of Yii 2 is expected in early 2014.


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

### `container`

*Default:* ".list-view"

Enter the selector of the element containing your items that you want to paginate.

### `item`

*Default:* ".item"

Enter the selector of the element that each item has. Make sure the elements are inside the container element.

### `noneLeft`

*Default:* false

Contains the message to be displayed when there are no more pages left to load.

### `loader`

*Default:* `<img src="images/loader.gif"/>` ![Spinner Image](https://raw2.github.com/kop/yii2-scroll-pager/master/assets/infinite-ajax-scroll/images/loader.gif)

Loader spinner. This HTML element will be displayed when the next page with items is loaded via AJAX.

### `loaderDelay`

*Default:* 600

Minimal time (in milliseconds) the loader should be displayed before rendering the items of the next page.
Note: This setting will _not_ actually delay the the loading of items itself.

### `triggerPageThreshold`

*Default:* 3

Page number after which a 'Load more items' link is displayed.
Users will manually trigger the loading of the next page by clicking this link.

### `trigger`

*Default:* "Load more items"

Text of the manual trigger link.

### `thresholdMargin`

*Default:* 0

On default IAS starts loading new items when you scroll to the latest .item element.
The thresholdMargin will be added to the items' offset, giving you the ability to load new items earlier
(please note that the margin should be a negative integer for this case).

For example:

Setting a thresholdMargin of -250 means that IAS will start loading 250 pixel _before_ the last item has scrolled into view.
A positive margin means that IAS will load new items N pixels after the last item.

### `history`

*Default:* true

Set this to false to disable the history module.

The IAS history module uses hashes (in the format "#/page/<num>") to remember the last viewed page,
so when a visitor hits the back button after visiting an item from that page,
it will load all items up to that last page and scrolls it into view.
The use of hashes can be problematic in some cases, in which case you can disable this feature.

### `scrollContainer`

*Default:* `$(window)`

By default, scroll events are listened from the `$(window)` object.
You can use this setting to specify a custom container, for example a div with overflow.


## Report

- Report any issues [on the GitHub](https://github.com/kop/yii2-scroll-pager/issues).


## License

**yii2-scroll-pager** is released under the MIT License. See the bundled `LICENSE.md` for details.


## Resources

- [Project Page](http://kop.github.io/yii2-scroll-pager)
- [Packagist Package](https://packagist.org/packages/kop/yii2-scroll-pager)
- [Source Code](https://github.com/kop/yii2-scroll-pager)