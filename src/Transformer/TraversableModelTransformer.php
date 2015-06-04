<?php

/**
 * This file is part of the ModelTransformer package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\ModelTransformer\Transformer;

use FivePercent\Component\ModelTransformer\ContextInterface;
use FivePercent\Component\ModelTransformer\Exception\UnsupportedClassException;
use FivePercent\Component\ModelTransformer\ModelTransformerManagerAwareInterface;
use FivePercent\Component\ModelTransformer\ModelTransformerInterface;
use FivePercent\Component\ModelTransformer\ModelTransformerManagerInterface;

/**
 * Transform \Traversable instances
 *
 * @author Dmitry Krasun <krasun.net@gmail.com>
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class TraversableModelTransformer extends AbstractTraversableModelTransformer
{
    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return is_a($class, 'Traversable', true);
    }

    /**
     * {@inheritDoc}
     */
    protected function createCollection($collection)
    {
        $class = get_class($collection);
        $transformed = new $class();

        return $transformed;
    }
}
