<?php

namespace kop\y2sp\tests\unit;

use Codeception\TestCase\Test;
use kop\y2sp\ScrollPager;

/**
 * This is ScrollPagerTest unit test.
 *
 * @see       \kop\y2sp\ScrollPager
 * @link      http://kop.github.io/yii2-scroll-pager Y2SP project page.
 * @license   https://github.com/kop/yii2-scroll-pager/blob/master/LICENSE.md MIT
 *
 * @author    Ivan Koptiev <ivan.koptiev@codex.systems>
 */
class ScrollPagerTest extends Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \kop\y2sp\ScrollPager
     */
    protected $instance;

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        $this->instance = new ScrollPager();
    }

    /**
     * @inheritdoc
     */
    protected function _after()
    {
        $this->instance = null;
    }
}