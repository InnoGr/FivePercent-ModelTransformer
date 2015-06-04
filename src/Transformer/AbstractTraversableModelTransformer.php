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
 * Abstract system for \Traversable transformation
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
abstract class AbstractTraversableModelTransformer implements ModelTransformerInterface, ModelTransformerManagerAwareInterface
{
    /**
     * @var ModelTransformerManagerInterface
     */
    private $manager;

    /**
     * {@inheritdoc}
     */
    public function setModelTransformerManager(ModelTransformerManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($object, ContextInterface $context)
    {
        if (!$object instanceof \Traversable) {
            throw UnsupportedClassException::create($object);
        }

        if (!$object instanceof \ArrayAccess) {
            throw new UnsupportedClassException(sprintf(
                'The collection object for transform should implement \ArrayAccess, %s given.',
                get_class($object)
            ));
        }

        // Try crete a new collection
        try {
            $transformed = $this->createCollection($object);
        } catch (\Exception $e) {
            throw new UnsupportedClassException(sprintf(
                'Could not create new collection instance with class "%s" (Use constructor).',
                get_class($object)
            ), 0, $e);
        }

        foreach ($object as $key => $child) {
            $transformed[$key] = $this->manager->transform($child);
        }

        return $transformed;
    }

    /**
     * Create collection
     *
     * @param object $collection
     *
     * @return \Traversable|\ArrayAccess
     */
    abstract protected function createCollection($collection);
}
