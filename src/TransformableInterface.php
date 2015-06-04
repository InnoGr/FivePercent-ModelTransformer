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
 * Allows to use transformation directly in application entity, document or domain object.
 *
 * @author Dmitry Krasun <krasun.net@gmail.com>
 */
interface TransformableInterface
{
    /**
     * It receives model transformer for possibility to transform children.
     *
     * @param ModelTransformerManagerInterface $transformerManager
     * @param ContextInterface                 $context
     *
     * @return object
     */
    public function transformToModel(ModelTransformerManagerInterface $transformerManager, ContextInterface $context);
}
