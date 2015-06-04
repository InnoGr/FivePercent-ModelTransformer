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
 * Transform instances, if instance implement "TransformableInterface"
 *
 * @author Dmitry Krasun <krasun.net@gmail.com>
 */
class TransformableModelTransformer implements ModelTransformerInterface, ModelTransformerManagerAwareInterface
{
    /**
     * @var ModelTransformerInterface
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
    public function transform($object, ContextInterface $context = null)
    {
        if (!$this->supportsClass(get_class($object))) {
            throw UnsupportedClassException::create($object);
        }

        return $object->transformToModel($this->manager, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return is_a($class, 'FivePercent\Component\ModelTransformer\TransformableInterface', true);
    }
}
