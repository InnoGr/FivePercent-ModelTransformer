<?php

/**
 * This file is part of the ModelTransformer package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\ModelTransformer\Annotation;

/**
 * Indicate property for available in transformation
 *
 * @Annotation
 * @Target("PROPERTY")
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class Property
{
    /** @var string */
    public $propertyName;
    /** @var array */
    public $groups = [];
    /** @var bool */
    public $shouldTransform = false;
    /** @var string */
    public $expressionValue = '';
}
