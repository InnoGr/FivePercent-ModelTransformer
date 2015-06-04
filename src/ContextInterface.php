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
 * All model transformer context should be implemented of this interface
 *
 * @author Dmitry Krasun <krasun.net@gmail.com>
 */
interface ContextInterface
{
    /**
     * Set groups
     *
     * @param array $groups
     *
     * @return Context
     */
    public function setGroups(array $groups);

    /**
     * Get groups
     *
     * @return array
     */
    public function getGroups();

    /**
     * Has group
     *
     * @param string $group
     */
    public function hasGroup($group);
}
