<?php

/**
 * This file is part of the ModelTransformer package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\ModelTransformer\Exception;

use FivePercent\Component\Exception\UnexpectedTrait;

/**
 * Fail transform
 *
 * @author Dmitry Krasun <krasun.net@gmail.com>
 */
class TransformationFailedException extends \Exception
{
    use UnexpectedTrait;
}
