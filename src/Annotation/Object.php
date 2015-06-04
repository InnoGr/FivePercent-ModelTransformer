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
 * Indicate object for available transform
 *
 * @Annotation
 * @Target("CLASS")
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class Object
{
    /** @var string @Required */
    public $transformedClass;
}
