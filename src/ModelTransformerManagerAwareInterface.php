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
 * ModelTransformerManagerAwareInterface should be implemented by classes that depends on a ModelTransformerInterface.
 *
 * @author Dmitry Krasun <krasun.net@gmail.com>
 */
interface ModelTransformerManagerAwareInterface
{
    /**
     * It should receive transformer to work with underlying objects.
     *
     * @param ModelTransformerManagerInterface $manager
     *
     * @return mixed
     */
    public function setModelTransformerManager(ModelTransformerManagerInterface $manager);
}
