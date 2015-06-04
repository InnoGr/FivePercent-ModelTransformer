<?php

/**
 * This file is part of the ModelTransformer package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\ModelTransformer\Exception;

/**
 * Unsupported object for transformation
 *
 * @author Dmitry Krasun <krasun.net@gmail.com>
 */
class UnsupportedClassException extends \Exception
{
    /**
     * Create a new instance via class or object
     *
     * @param string|object $class
     * @param int           $code
     * @param \Exception    $prev
     *
     * @return UnsupportedClassException
     */
    public static function create($class, $code = 0, \Exception $prev = null)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $message = sprintf(
            'The class "%s" nor supports for transformation.',
            $class
        );

        return new static($message, $code, $prev);
    }
}
