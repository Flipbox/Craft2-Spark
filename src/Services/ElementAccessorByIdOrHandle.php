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

use Flipbox\Craft2\Spark\Elements\ElementWithIdAndHandle;
use Flipbox\Craft2\Spark\Elements\Interfaces\ElementWithHandleInterface;
use Flipbox\Craft2\Spark\Elements\Interfaces\ElementWithIdInterface;
use Flipbox\Craft2\Spark\Helpers\ElementHelper;
use Flipbox\Craft2\Spark\Models\Interfaces\ModelInterface;
use Flipbox\Craft2\Spark\Records\Interfaces\RecordWithHandleInterface;
use Flipbox\Craft2\Spark\Records\Interfaces\RecordWithIdInterface;

abstract class ElementAccessorByIdOrHandle extends ElementAccessor
{

    use Traits\ElementAccessorByIdTrait,
        Traits\ElementAccessorByHandleTrait;

    /**
     * @param $identifier
     * @param string $scenario
     * @return ElementWithIdAndHandle|null
     */
    public function find($identifier, $scenario = ElementHelper::SCENARIO_SAVE)
    {

        if (is_numeric($identifier)) {

            return $this->findById($identifier, $scenario);

        } elseif (is_string($identifier)) {

            return $this->findByHandle($identifier, $scenario);

        }

        return parent::find($identifier);

    }

    /**
     * @param $identifier
     * @return null
     */
    public function findCache($identifier)
    {

        if (is_numeric($identifier)) {

            return $this->findCacheById($identifier);

        } elseif (is_string($identifier)) {

            return $this->findCacheByHandle($identifier);

        }

        return parent::findCache($identifier);

    }

    /**
     * @param ModelInterface $model
     * @return $this
     */
    public function addToCache(ModelInterface $model)
    {

        if ($model instanceof ElementWithIdInterface) {

            $this->cacheById($model);

        }

        if ($model instanceof ElementWithHandleInterface) {

            $this->cacheByHandle($model);

        }

        return parent::addToCache($model);

    }

    /**
     * @param ModelInterface $model
     * @param bool $mirrorScenario
     * @return RecordWithIdInterface|RecordWithHandleInterface
     */
    public function toRecord(ModelInterface $model, $mirrorScenario = true)
    {

        $record = null;

        // Get existing record
        if (is_null($record) && $model instanceof ElementWithIdInterface) {

            $record = $this->findRecordById($model->getId());

        }

        // Get existing record
        if (is_null($record) && $model instanceof ElementWithHandleInterface) {

            $record = $this->findRecordByHandle($model->getHandle());

        }

        if (!is_null($record)) {

            // Populate the record attributes
            $this->transferToRecord($model, $record, $mirrorScenario);

            return $record;

        }

        return parent::toRecord($model, $mirrorScenario);

    }

}
