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
 * Responds for transformation of internal application entities, documents and domain objects
 * to exposed domain models provided by public APIs (JSON-RPC API, AMQP API and so on).
 *
 * @author Dmitry Krasun <krasun.net@gmail.com>
 */
interface ModelTransformerInterface
{
    /**
     * Transforms only supported object to model.
     *
     * @param object                    $object
     * @param ContextInterface          $context
     *
     * @return object
     */
    public function transform($object, ContextInterface $context);

    /**
     * Returns true if it can transform object, otherwise false.
     *
     * @param string $class
     *
     * @return boolean
     */
    public function supportsClass($class);
}
