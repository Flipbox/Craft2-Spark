<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Services\Traits;

use yii\base\Event as BaseEvent;

trait BaseUpdateTrait
{

    /*******************************************
     * TRIGGERS
     *******************************************/

    /**
     * @var string The event that is triggered after an object is updated
     */
    public static $onBeforeUpdateTrigger = 'onBeforeUpdate';

    /**
     * @var string The event that is triggered after an object is updated
     */
    public static $onAfterUpdateTrigger = 'onAfterUpdate';


    /*******************************************
     * ABSTRACTS
     *******************************************/

    /**
     * Raises an event.
     * This method represents the happening of an event. It invokes
     * all attached handlers for the event.
     * @param string $name the event name
     * @param \CEvent $event the event parameter
     * @throws \CException if the event is undefined or an event handler is invalid.
     */
    abstract public function raiseEvent($name, $event);

}