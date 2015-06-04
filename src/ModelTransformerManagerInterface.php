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

/**
 * All model transformer managers should be implemented of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface ModelTransformerManagerInterface
{
    /**
     * Is supported object or class for transform
     *
     * @param string|object $class
     *
     * @return bool
     */
    public function supports($class);

    /**
     * Get transformer for class
     *
     * @param string|object $class
     *
     * @return ModelTransformerInterface
     *
     * @throws Exception\UnsupportedClassException
     */
    public function getTransformerForClass($class);

    /**
     * Transform object
     *
     * @param object           $object
     * @param ContextInterface $context
     *
     * @return object
     *
     * @throws \FivePercent\Component\ModelTransformer\Exception\TransformationFailedException
     */
    public function transform($object, ContextInterface $context = null);
}
