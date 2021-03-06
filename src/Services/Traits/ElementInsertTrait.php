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
use Flipbox\Craft2\Spark\Helpers\ElementHelper;
use Flipbox\Craft2\Spark\Helpers\RecordHelper;
use Flipbox\Craft2\Spark\Records\Interfaces\RecordWithIdInterface;

trait ElementInsertTrait
{

    // Common insert
    use BaseInsertTrait;

    /*******************************************
     * ABSTRACTS
     *******************************************/

    /**
     * @param array $config
     * @return ElementEvent
     */
    abstract protected function createEvent($config = []);

    /**
     * @param array $config
     * @param string $scenario
     * @return RecordWithIdInterface
     */
    abstract public function createRecord($config = [], $scenario = RecordHelper::SCENARIO_SAVE);

    /**
     * @param ElementWithIdInterface $element
     * @param null $attributes
     * @param null $contentAttributes
     * @param bool $mirrorScenario
     * @return bool
     * @throws InsufficientPrivilegesException
     * @throws \Exception
     */
    abstract public function update(
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
    public function hasInsertPermission(ElementWithIdInterface $element)
    {
        return true;
    }


    /*******************************************
     * EVENTS
     *******************************************/

    /**
     * @param ElementEvent $event
     */
    protected function onBeforeInsert(ElementEvent $event)
    {
        $this->raiseEvent(static::$onBeforeInsertTrigger, $event);
    }

    /**
     * @param ElementEvent $event
     */
    protected function onAfterInsert(ElementEvent $event)
    {
        $this->raiseEvent(static::$onAfterInsertTrigger, $event);
    }

    /*******************************************
     * INSERT
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
    public function insert(
        ElementWithIdInterface $element,
        $attributes = null,
        $contentAttributes = null,
        $mirrorScenario = true
    ) {

        // Ensure we're creating a record
        if ($element->getId()) {

            return $this->update($element, $attributes, $contentAttributes, $mirrorScenario);

        }

        // Check permission
        if ($this->hasInsertPermission($element)) {

            return $this->insertInternal($element, $attributes, $contentAttributes, $mirrorScenario);

        }

        throw new InsufficientPrivilegesException("Insufficient privileges.");

    }

    /**
     * @param ElementWithIdInterface $element
     * @param null $attributes
     * @param null $contentAttributes
     * @param bool $mirrorScenario
     * @return bool
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    protected function insertInternal(
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
            $this->onBeforeInsert($event);

            // Green light?
            if ($event->performAction) {

                // New record (from model)
                if ($mirrorScenario) {

                    $record = $this->createRecord($element, $element->getScenario());

                } else {

                    $record = $this->createRecord($element);

                }

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

                        // Insert record
                        if (false !== $record->insert(false, $attributes)) {

                            // Transfer record Id to element
                            $element->setId($record->getId());

                            // Transfer record date attribute(s) to element
                            $element->setAttributes([
                                'dateUpdated' => $record->getAttribute('dateUpdated'),
                                'dateCreated' => $record->getAttribute('dateCreated')
                            ]);

                            // Change scenario
                            $element->setScenario(ElementHelper::SCENARIO_UPDATE);

                            // The 'after' event
                            $this->onAfterInsert($event);

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
