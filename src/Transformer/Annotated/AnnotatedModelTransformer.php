<?php

/**
 * This file is part of the ModelTransformer package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\ModelTransformer\Transformer\Annotated;

use FivePercent\Component\Reflection\Reflection;
use FivePercent\Component\ModelTransformer\ContextInterface;
use FivePercent\Component\ModelTransformer\Exception\TransformationFailedException;
use FivePercent\Component\ModelTransformer\ModelTransformerInterface;
use FivePercent\Component\ModelTransformer\ModelTransformerManagerAwareInterface;
use FivePercent\Component\ModelTransformer\ModelTransformerManagerInterface;
use FivePercent\Component\ModelTransformer\Transformer\Annotated\Metadata\MetadataFactoryInterface;
use FivePercent\Component\ModelTransformer\Transformer\Annotated\Metadata\PropertyMetadata;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Annotated model transformer
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class AnnotatedModelTransformer implements ModelTransformerInterface, ModelTransformerManagerAwareInterface
{
    /**
     * @var ModelTransformerManagerInterface
     */
    private $transformerManager;

    /**
     * @var MetadataFactoryInterface
     */
    private $metadataFactory;

    /**
     * @var ExpressionLanguage
     */
    private $expressionLanguage;

    /**
     * Construct
     *
     * @param MetadataFactoryInterface $metadataFactory
     * @param ExpressionLanguage       $expressionLanguage
     */
    public function __construct(
        MetadataFactoryInterface $metadataFactory,
        ExpressionLanguage $expressionLanguage = null
    ) {
        $this->metadataFactory = $metadataFactory;
        $this->expressionLanguage = $expressionLanguage;
    }

    /**
     * {@inheritDoc}
     */
    public function setModelTransformerManager(ModelTransformerManagerInterface $manager)
    {
        $this->transformerManager = $manager;
    }

    /**
     * {@inheritDoc}
     */
    public function transform($object, ContextInterface $context)
    {
        $metadata = $this->metadataFactory->loadMetadata(get_class($object));

        // Get properties for transformation
        if (!$context->getGroups()) {
            $transformProperties = $metadata->getProperties();
        } else {
            $transformProperties = $metadata->getPropertiesForGroups($context->getGroups());
        }

        // Try create transformed
        $transformedClass = $metadata->getTransformedClass();
        $transformedReflection = Reflection::loadClassReflection($transformedClass);
        $transformed = $transformedReflection->newInstanceWithoutConstructor();

        $objectReflection = Reflection::loadClassReflection($object);

        foreach ($transformProperties as $transformPropertyName => $propertyMetadata) {
            try {
                $objectPropertyReflection = $objectReflection->getProperty($transformPropertyName);
            } catch (\ReflectionException $e) {
                throw new \RuntimeException(sprintf(
                    'Error transform property: Not found property "%s" in class "%s".',
                    $transformPropertyName,
                    $objectReflection->getName()
                ), 0, $e);
            }

            try {
                $transformedPropertyReflection = $transformedReflection->getProperty(
                    $propertyMetadata->getPropertyName()
                );
            } catch (\ReflectionException $e) {
                throw new \RuntimeException(sprintf(
                    'Error transform property: Not found property "%s" in class "%s".',
                    $propertyMetadata->getPropertyName(),
                    $transformedReflection->getName()
                ));
            }

            if (!$transformedPropertyReflection->isPublic()) {
                $transformedPropertyReflection->setAccessible(true);
            }

            if (!$objectPropertyReflection->isPublic()) {
                $objectPropertyReflection->setAccessible(true);
            }

            $objectPropertyValue = $objectPropertyReflection->getValue($object);

            $transformedValue = $this->transformValue(
                $object,
                $objectPropertyValue,
                $propertyMetadata,
                $transformedPropertyReflection
            );

            $transformedPropertyReflection->setValue($transformed, $transformedValue);
        }

        return $transformed;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $this->metadataFactory->supportsClass($class);
    }

    /**
     * Transform value
     *
     * @param object              $object
     * @param mixed               $value
     * @param PropertyMetadata    $metadata
     * @param \ReflectionProperty $property
     *
     * @return mixed
     *
     * @throws TransformationFailedException
     */
    protected function transformValue($object, $value, PropertyMetadata $metadata, \ReflectionProperty $property)
    {
        if (!$value) {
            return $value;
        }

        if ($metadata->isShouldTransform()) {
            if (!is_object($value)) {
                throw new TransformationFailedException(sprintf(
                    'Can not transform property "%s" in class "%s". The value must be a object, but "%s" given.',
                    $property->getName(),
                    $property->getDeclaringClass()->getName(),
                    gettype($value)
                ));
            }

            return $this->transformerManager->transform($value);
        }

        if ($metadata->getExpressionValue()) {
            if (!$this->expressionLanguage) {
                throw new \LogicException(
                    'Can not evaluate expression language. Please inject ExpressionLanguage to transformer.'
                );
            }

            $attributes = [
                'object' => $object,
                'value' => $value
            ];

            $value = $this->expressionLanguage->evaluate($metadata->getExpressionValue(), $attributes);
        }

        return $value;
    }
}
