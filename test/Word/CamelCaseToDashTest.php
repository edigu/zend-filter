<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Filter\Word;

use PHPUnit\Framework\TestCase;
use Zend\Filter\Word\CamelCaseToDash as CamelCaseToDashFilter;

class CamelCaseToDashTest extends TestCase
{
    public function testFilterSeparatesCamelCasedWordsWithDashes()
    {
        $string   = 'CamelCasedWords';
        $filter   = new CamelCaseToDashFilter();
        $filtered = $filter($string);

        $this->assertNotEquals($string, $filtered);
        $this->assertEquals('Camel-Cased-Words', $filtered);
    }

    /**
     * @dataProvider camelizedStrings
     */
    public function testFilterSeparatesCamelCasedWordsContainingNumbersWithDashes($camel, $dashed)
    {
        $filter   = new CamelCaseToDashFilter();
        $filtered = $filter($camel);
        $this->assertNotEquals($camel, $filtered);
        $this->assertEquals($dashed, $filtered);
    }

    /**
     * Provides CamelizedStrings to test
     *
     * @return array
     */
    public function camelizedStrings()
    {
        return [
            [ 'CamelCasedWith2016Numbers', 'Camel-Cased-With-2016-Numbers' ],
            [ '10NumbersAsPrefix', '10-Numbers-As-Prefix' ],
            [ 'NumberSuffix42', 'Number-Suffix-42' ],
            [ 'lower50Upper', 'lower-50-Upper' ],
            [ 'dashed-2016Bar', 'dashed-2016-Bar'],
        ];
    }
}
