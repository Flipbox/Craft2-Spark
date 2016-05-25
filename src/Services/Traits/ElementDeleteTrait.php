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

use Craft\Craft;
use Craft\Event as ElementEvent;
use Flipbox\Craft2\Spark\Elements\Interfaces\ElementWithIdInterface;
use Flipbox\Craft2\Spark\Exceptions\InsufficientPrivilegesException;
use Flipbox\Craft2\Spark\Helpers\RecordHelper;
use Flipbox\Craft2\Spark\Records\Interfaces\RecordWithIdInterface;

trait ElementDeleteTrait
{

    // Common delete
    use BaseDeleteTrait;

    /*******************************************
     * ABSTRACTS
     *******************************************/

    /**
     * @param array $config
     * @return ElementEvent
     */
    abstract protected function createEvent($config = []);

    /**
     * @param $condition
     * @param string $scenario
     * @return RecordWithIdInterface
     */
    abstract public function getRecord($condition, $scenario = RecordHelper::SCENARIO_SAVE);

    /*******************************************
     * PERMISSIONS
     *******************************************/

    /**
     * @param ElementWithIdInterface $element
     * @return bool
     */
    public function hasDeletePermission(ElementWithIdInterface $element)
    {
        return true;
    }


    /*******************************************
     * EVENTS
     *******************************************/

    /**
     * @param ElementEvent $event
     */
    protected function onBeforeDelete(ElementEvent $event)
    {
        $this->raiseEvent(static::$onBeforeDeleteTrigger, $event);
    }

    /**
     * @param ElementEvent $event
     */
    protected function onAfterDelete(ElementEvent $event)
    {
        $this->raiseEvent(static::$onAfterDeleteTrigger, $event);
    }


    /*******************************************
     * INSERT
     *******************************************/

    /**
     * @param ElementWithIdInterface $element
     * @return bool
     * @throws InsufficientPrivilegesException
     * @throws \Exception
     */
    public function delete(ElementWithIdInterface $element)
    {

        // Check permission
        if ($this->hasDeletePermission($element)) {

            return $this->deleteInternal($element);

        }

        throw new InsufficientPrivilegesException("Insufficient privileges.");

    }

    /**
     * @param ElementWithIdInterface $element
     * @return bool
     * @throws \CDbException
     * @throws \Exception
     */
    protected function deleteInternal(ElementWithIdInterface $element)
    {

        // Db transaction
        $transaction = RecordHelper::beginTransaction();

        try {

            // The event
            $event = $this->createEvent($element);

            // The 'before' event
            $this->onBeforeDelete($event);

            // Green light?
            if ($event->performAction) {

                // Delete record
                if (Craft::app()->elements->deleteElementById($element->getId())) {

                    // The 'after' event
                    $this->onAfterDelete($event);

                    // Green light?
                    if ($event->performAction) {

                        // Commit db transaction
                        if ($transaction) {

                            $transaction->commit();

                        }

                        return true;

                    }

                }

            }

        } catch (\Exception $e) {

            // Roll back all db actions (fail)
            if ($transaction) {

                $transaction->rollback();

            }

            throw $e;

        }

        // Roll back all db actions (fail)
        if ($transaction) {

            $transaction->rollback();

        }

        return false;

    }

}
