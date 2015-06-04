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
 * Object transformation metadata
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ObjectMetadata
{
    /**
     * @var string
     */
    private $transformedClass;

    /**
     * @var array|PropertyMetadata[]
     */
    private $properties;

    /**
     * Construct
     *
     * @param string                   $transformedClass
     * @param array|PropertyMetadata[] $properties
     */
    public function __construct($transformedClass, array $properties)
    {
        $this->transformedClass = $transformedClass;
        $this->properties = $properties;
    }

    /**
     * Get transformed class
     *
     * @return string
     */
    public function getTransformedClass()
    {
        return $this->transformedClass;
    }

    /**
     * Get properties
     *
     * @return array|PropertyMetadata[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Get properties for groups
     *
     * @param array $groups
     *
     * @return array|PropertyMetadata[]
     */
    public function getPropertiesForGroups(array $groups)
    {
        $properties = [];

        foreach ($groups as $group) {
            foreach ($this->properties as $key => $property) {
                if (in_array($group, $property->getGroups())) {
                    $properties[$key] = $property;
                }
            }
        }

        return $properties;
    }
}
