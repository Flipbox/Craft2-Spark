<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Services;

use Flipbox\Craft2\Spark\Objects\Interfaces\ObjectInterface;

abstract class ObjectAccessorByHandle extends ObjectAccessor
{

    use Traits\ObjectAccessorByHandleTrait;

    /**
     * @param $identifier
     * @return ObjectInterface|null
     */
    public function find($identifier)
    {

        if (is_string($identifier)) {

            return $this->findByHandle($identifier);

        }

        return parent::find($identifier);

    }

    /*******************************************
     * CACHE
     *******************************************/

    /**
     * @param $identifier
     * @return null
     */
    public function findCache($identifier)
    {

        if (is_string($identifier)) {

            return $this->findCacheByHandle($identifier);

        }

        return parent::findCache($identifier);

    }

}
