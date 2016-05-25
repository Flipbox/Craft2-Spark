<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Elements;

use Craft\BaseElementModel as BaseElement;
use Flipbox\Craft2\Spark\Helpers\ElementHelper;

abstract class Element extends BaseElement implements Interfaces\ElementInterface
{

    /**
     * @inheritdoc
     */
    public static function create($config = [])
    {

        // Set our class
        $config['class'] = static::className();

        return ElementHelper::create($config);

    }

    /**
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }

}