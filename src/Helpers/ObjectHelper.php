<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Helpers;

use Flipbox\Craft2\Spark\Exceptions\InvalidConfigurationException;
use Flipbox\Skeleton\Helpers\ObjectHelper as BaseObjectHelper;

class ObjectHelper extends BaseObjectHelper
{

    /**
     * Checks the config for a valid class
     *
     * @param $config
     * @param null $instanceOf
     * @param bool $removeClass
     * @return null|string
     * @throws InvalidConfigurationException
     */
    public static function checkConfig(&$config, $instanceOf = null, $removeClass = true)
    {

        // Get class from config
        $class = static::getClassFromConfig($config, $removeClass);

        // Make sure we have a valid class
        if ($instanceOf && !is_subclass_of($class, $instanceOf)) {

            throw new InvalidConfigurationException(
                sprintf(
                    "The class '%s' must be an instance of '%s'",
                    (string)$class,
                    (string)$instanceOf
                )
            );
        }

        return $class;

    }

    /**
     * Get a class from a config
     *
     * @param $config
     * @param bool $removeClass
     * @return string
     * @throws InvalidConfigurationException
     */
    public static function getClassFromConfig(&$config, $removeClass = false)
    {

        // Find class
        $class = static::findClassFromConfig($config, $removeClass);

        if (empty($class)) {
            throw new InvalidConfigurationException(
                sprintf(
                    "The configuration must specify a 'class' property: '%s'",
                    JsonHelper::encode($config)
                )
            );
        }

        return $class;

    }

}
