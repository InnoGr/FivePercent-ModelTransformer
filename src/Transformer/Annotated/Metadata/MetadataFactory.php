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

use Doctrine\Common\Annotations\Reader;
use FivePercent\Component\Reflection\Reflection;
use FivePercent\Component\ModelTransformer\Annotation\Object as ObjectAnnotation;
use FivePercent\Component\ModelTransformer\Annotation\Property as PropertyAnnotation;
use FivePercent\Component\ModelTransformer\Transformer\Annotated\Exception\TransformAnnotationNotFoundException;

/**
 * Base metadata factory
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class MetadataFactory implements MetadataFactoryInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * Construct
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        try {
            $this->loadMetadata($class);

            return true;
        } catch (TransformAnnotationNotFoundException $e) {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadMetadata($class)
    {
        // Try get object annotation from class
        $objectAnnotation = null;
        $classAnnotations = Reflection::loadClassAnnotations($this->reader, $class, true);

        foreach ($classAnnotations as $classAnnotation) {
            if ($classAnnotation instanceof ObjectAnnotation) {
                if ($objectAnnotation) {
                    throw new \RuntimeException(sprintf(
                        'Many @Transformer\Object annotation in class "%s".',
                        $class
                    ));
                }

                $objectAnnotation = $classAnnotation;
            }
        }

        if (!$objectAnnotation) {
            throw new TransformAnnotationNotFoundException(sprintf(
                'Not found @Object annotations in class "%s".',
                $class
            ));
        }

        // Try get properties annotations
        $properties = [];
        $classProperties = Reflection::getClassProperties($class, true);

        foreach ($classProperties as $classProperty) {
            $propertyAnnotations = $this->reader->getPropertyAnnotations($classProperty);

            foreach ($propertyAnnotations as $propertyAnnotation) {
                if ($propertyAnnotation instanceof PropertyAnnotation) {
                    $property = new PropertyMetadata(
                        $propertyAnnotation->propertyName ?: $classProperty->getName(),
                        $propertyAnnotation->groups,
                        $propertyAnnotation->shouldTransform,
                        $propertyAnnotation->expressionValue
                    );

                    $properties[$classProperty->getName()] = $property;
                }
            }
        }

        return new ObjectMetadata($objectAnnotation->transformedClass, $properties);
    }
}
