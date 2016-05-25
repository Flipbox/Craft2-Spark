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
use Flipbox\Craft2\Spark\Elements\Interfaces\ElementInterface;
use Flipbox\Craft2\Spark\Elements\Interfaces\ElementWithIdInterface;
use Flipbox\Craft2\Spark\Exceptions\InsufficientPrivilegesException;
use Flipbox\Craft2\Spark\Helpers\RecordHelper;
use Flipbox\Craft2\Spark\Records\Interfaces\RecordWithIdInterface;

trait ElementUpdateTrait
{

    // Common update
    use BaseUpdateTrait;

    /*******************************************
     * ABSTRACTS
     *******************************************/

    /**
     * @param array $config
     * @return ElementEvent
     */
    abstract protected function createEvent($config = []);

    /**
     * @param ElementInterface $element
     * @param bool $mirrorScenario
     * @return RecordWithIdInterface
     */
    abstract public function toRecord(ElementInterface $element, $mirrorScenario = true);

    /**
     * @param ElementWithIdInterface $element
     * @param null $attributes
     * @param null $contentAttributes
     * @param bool $mirrorScenario
     * @return bool
     * @throws InsufficientPrivilegesException
     * @throws \Exception
     */
    abstract public function insert(
        ElementWithIdInterface $element,
        $attributes = null,
        $contentAttributes = null,
        $mirrorScenario = true
    );


    /*******************************************
     * PERMISSIONS
     *******************************************/

    /**
     * @param ElementWithIdInterface $element
     * @return bool
     */
    public function hasUpdatePermission(ElementWithIdInterface $element)
    {
        return true;
    }


    /*******************************************
     * EVENTS
     *******************************************/

    /**
     * @param ElementEvent $event
     */
    protected function onBeforeUpdate(ElementEvent $event)
    {
        $this->raiseEvent(static::$onBeforeUpdateTrigger, $event);
    }

    /**
     * @param ElementEvent $event
     */
    protected function onAfterUpdate(ElementEvent $event)
    {
        $this->raiseEvent(static::$onAfterUpdateTrigger, $event);
    }

    /*******************************************
     * UPDATE
     *******************************************/

    /**
     * @param ElementWithIdInterface $element
     * @param null $attributes
     * @param null $contentAttributes
     * @param bool $mirrorScenario
     * @return bool
     * @throws InsufficientPrivilegesException
     * @throws \Exception
     */
    public function update(
        ElementWithIdInterface $element,
        $attributes = null,
        $contentAttributes = null,
        $mirrorScenario = true
    ) {

        // Ensure we're creating a record
        if (!$element->getId()) {

            return $this->insert($element, $attributes, $contentAttributes, $mirrorScenario);

        }

        // Check permission
        if ($this->hasUpdatePermission($element)) {

            return $this->updateInternal($element, $attributes, $contentAttributes, $mirrorScenario);

        }

        throw new InsufficientPrivilegesException("Insufficient privileges.");

    }

    /**
     * @param ElementWithIdInterface $element
     * @param null $attributes
     * @param null $contentAttributes
     * @param bool $mirrorScenario
     * @return bool
     * @throws \CDbException
     * @throws \Exception
     */
    protected function updateInternal(
        ElementWithIdInterface $element,
        $attributes = null,
        $contentAttributes = null,
        $mirrorScenario = true
    ) {

        // Db transaction
        $transaction = RecordHelper::beginTransaction();

        try {

            // The event
            $event = $this->createEvent($element);

            // The 'before' event
            $this->onBeforeUpdate($event);

            // Green light?
            if ($event->performAction) {

                // Convert model to record
                $record = $this->toRecord($element, $mirrorScenario);

                // Validate
                if (!$record->validate($attributes)) {
                    $element->addErrors($record->getErrors());
                }

                // Validate content
                if (!Craft::app()->content->validateContent($element)) {
                    $element->addErrors($element->getContent()->getErrors());
                }

                // Proceed (no errors)
                if (!$element->hasErrors()) {

                    // Save element (and content fields)
                    if (Craft::app()->elements->saveElement($element, false)) {

                        // Update record
                        if (false !== $record->update($attributes)) {

                            // Transfer record date attribute(s) to element
                            $element->setAttributes([
                                'dateUpdated' => $record->getAttribute('dateUpdated'),
                            ]);

                            // The 'after' event
                            $this->onAfterUpdate($event);

                            // Green light?
                            if ($event->performAction) {

                                // Commit db transaction
                                if ($transaction) {

                                    $transaction->commit();

                                }

                                return true;

                            }

                        } else {

                            // Transfer errors to model
                            $element->addErrors($record->getErrors());

                        }

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
