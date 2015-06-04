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
 * Property transformation metadata
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class PropertyMetadata
{
    /**
     * @var string
     */
    private $propertyName;

    /**
     * @var array
     */
    private $groups;

    /**
     * @var bool
     */
    private $shouldTransform;

    /**
     * @var string
     */
    private $expressionValue;

    /**
     * Construct
     *
     * @param string $propertyName
     * @param array  $groups
     * @param bool   $shouldTransform
     * @param string $expressionValue
     */
    public function __construct($propertyName, array $groups, $shouldTransform, $expressionValue)
    {
        $this->propertyName = $propertyName;
        $this->groups = $groups;
        $this->shouldTransform = $shouldTransform;
        $this->expressionValue = $expressionValue;
    }

    /**
     * Get field name
     *
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * Get groups
     *
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Is should transform
     *
     * @return bool
     */
    public function isShouldTransform()
    {
        return $this->shouldTransform;
    }

    /**
     * Get expression value
     *
     * @return string
     */
    public function getExpressionValue()
    {
        return $this->expressionValue;
    }
}
