<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Filter\Word;

use Zend\Stdlib\StringUtils;

class CamelCaseToSeparator extends AbstractSeparator
{
    /**
     * Defined by Zend\Filter\Filter
     *
     * @param  string|array $value
     * @return string|array
     */
    public function filter($value)
    {
        if (! is_scalar($value) && ! is_array($value)) {
            return $value;
        }

        if (StringUtils::hasPcreUnicodeSupport()) {
            /**
             * First: Match right after a lowercase letter or digit following a capital letter or
             * before a capital letter with a lowercese letter on it's right.
             *
             * Second: Match right after a lowercase letter following zero or more digits
             * or a capital letter
             */
            $pattern = ['#(?<=\p{Ll}|\p{Nd})(?=\p{Lu})|(?<=\p{Lu})(?=\p{Lu}\p{Ll})#', '#(?<=(?:\p{Ll}))(\p{Lu}|(\p{Nd}+))#'];
            $replacement = [ $this->separator . '\1', $this->separator . '\1',
            ];
        } else {
            $pattern     = [ '#(?<=[a-z0-9])(?=[A-Z])|(?<=[A-Z])(?=[A-Z][a-z])#', '#(?<=(?:[a-z]))([A-Z]|([0-9]+))#' ];
            $replacement = ['\1' . $this->separator . '\2', $this->separator . '\1'];
        }

        return preg_replace($pattern, $replacement, $value);
    }
}
