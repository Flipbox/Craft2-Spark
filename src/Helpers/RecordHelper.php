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

use Craft\Craft;
use Flipbox\Craft2\Spark\Exceptions\InvalidConfigurationException;
use Flipbox\Craft2\Spark\Records\Interfaces\RecordInterface;

class RecordHelper
{

    /**
     * The scenario used to populate a model
     */
    const SCENARIO_POPULATE = 'populate';

    /**
     * The scenario used to insert a record
     */
    const SCENARIO_INSERT = 'insert';

    /**
     * The scenario used to update a record
     */
    const SCENARIO_UPDATE = 'update';

    /**
     * The scenario used to save a record
     */
    const SCENARIO_SAVE = 'save';

    /**
     * @param $config
     * @param null $instanceOf
     * @param string $toScenario
     * @return RecordInterface
     * @throws InvalidConfigurationException
     */
    public static function create($config, $instanceOf = null, $toScenario = self::SCENARIO_SAVE)
    {

        // Get class from config
        $class = ObjectHelper::checkConfig($config, $instanceOf);

        // New model
        $model = new $class();

        return static::populate($model, $config, $toScenario);

    }

    /**
     * @param RecordInterface $record
     * @param $config
     * @param string $toScenario
     * @return RecordInterface
     */
    public static function populate(RecordInterface $record, $config, $toScenario = ModelHelper::SCENARIO_UPDATE)
    {

        // Set scenario
        if (!$toScenario) {

            $toScenario = $record->getScenario();

        }

        // Always set the populate scenario
        $record->setScenario(static::SCENARIO_POPULATE);

        // Populate model attributes
        $record->setAttributes($config);

        // Set scenario
        $record->setScenario($toScenario);

        return $record;

    }


    /**
     * @return \CDbTransaction
     */
    public static function beginTransaction()
    {
        return Craft::app()->db->getCurrentTransaction() === null ? Craft::app()->db->beginTransaction() : null;
    }

}
