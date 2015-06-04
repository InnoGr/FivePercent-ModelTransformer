<?php

/**
 * This file is part of the ModelTransformer package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\ModelTransformer;

use FivePercent\Component\Exception\UnexpectedTypeException;
use FivePercent\Component\ModelTransformer\Exception\UnsupportedClassException;

/**
 * Base model transformer manager
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ModelTransformerManager implements ModelTransformerManagerInterface
{
    /**
     * @var array
     */
    private $transformers = [];

    /**
     * @var bool
     */
    private $sorted = false;

    /**
     * Add transformer to manager
     *
     * @param ModelTransformerInterface $transformer
     * @param int                       $priority
     *
     * @return ModelTransformerManager
     */
    public function addTransformer(ModelTransformerInterface $transformer, $priority = 0)
    {
        $this->sorted = false;

        $hash = spl_object_hash($transformer);

        $this->transformers[$hash] = [
            'transformer' => $transformer,
            'priority' => $priority
        ];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($class)
    {
        try {
            $this->getTransformerForClass($class);

            return true;
        } catch (UnsupportedClassException $e) {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getTransformerForClass($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $this->sortTransformers();

        foreach ($this->transformers as $entry) {
            /** @var ModelTransformerInterface $transformer */
            $transformer = $entry['transformer'];

            if ($transformer->supportsClass($class)) {
                return $transformer;
            }
        }

        throw new UnsupportedClassException(sprintf(
            'Not found transformer for class "%s".',
            $class
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function transform($object, ContextInterface $context = null)
    {
        if (!is_object($object)) {
            throw UnexpectedTypeException::create($object, 'object');
        }

        if (!$context) {
            $context = new Context();
        }

        $transformer = $this->getTransformerForClass($object);

        if ($transformer instanceof ModelTransformerManagerAwareInterface) {
            $transformer->setModelTransformerManager($this);
        }

        $transformed = $transformer->transform($object, $context);

        return $transformed;
    }

    /**
     * Sort transformers
     */
    private function sortTransformers()
    {
        if ($this->sorted) {
            return;
        }

        $this->sorted = true;

        uasort($this->transformers, function ($a, $b) {
            if ($a['priority'] == $b['priority']) {
                return 0;
            }

            return $a['priority'] > $b['priority'] ? -1 : 1;
        });
    }
}
