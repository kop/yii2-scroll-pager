<?php

namespace kop\y2sp\tests\unit;

use Codeception\TestCase\Test;
use kop\y2sp\assets\InfiniteAjaxScrollAsset;

/**
 * This is InfiniteAjaxScrollAssetTest unit test.
 *
 * @see       \kop\y2sp\assets\InfiniteAjaxScrollAsset
 * @link      http://kop.github.io/yii2-scroll-pager Y2SP project page.
 * @license   https://github.com/kop/yii2-scroll-pager/blob/master/LICENSE.md MIT
 *
 * @author    Ivan Koptiev <ivan.koptiev@codex.systems>
 */
class InfiniteAjaxScrollAssetTest extends Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \kop\y2sp\assets\InfiniteAjaxScrollAsset
     */
    protected $instance;

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        $this->instance = new InfiniteAjaxScrollAsset();
    }

    /**
     * @inheritdoc
     */
    protected function _after()
    {
        $this->instance = null;
    }
}