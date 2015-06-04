<?php

/**
 * This file is part of the ModelTransformer package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\ModelTransformer\Transformer\Annotated\Metadata;

/**
 * All annotated metadata factories should be implemented of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface MetadataFactoryInterface
{
    /**
     * Is supports class
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class);

    /**
     * Load metadata for class
     *
     * @param string $class
     *
     * @return ObjectMetadata
     *
     * @throws \FivePercent\Component\ModelTransformer\Transformer\Annotated\Exception\TransformAnnotationNotFoundException
     */
    public function loadMetadata($class);
}
