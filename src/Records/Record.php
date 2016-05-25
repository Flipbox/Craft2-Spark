<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Records;

use Craft\BaseRecord;
use Flipbox\Craft2\Spark\Helpers\RecordHelper;

abstract class Record extends BaseRecord implements Interfaces\RecordInterface
{

    /**
     * @var string
     */
    protected $tableName = '';

    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /*******************************************
     * RULES
     *******************************************/

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return array_merge(
            parent::rules(),
            array(
                array(
                    array_keys($this->defineAttributes()),
                    'safe',
                    'on' => [
                        RecordHelper::SCENARIO_SAVE,
                        RecordHelper::SCENARIO_INSERT,
                        RecordHelper::SCENARIO_UPDATE
                    ]
                ),
                array(
                    array('dateCreated'),
                    'safe',
                    'on' => [
                        RecordHelper::SCENARIO_INSERT
                    ]
                ),
                array(
                    array('dateUpdated'),
                    'safe',
                    'on' => [
                        RecordHelper::SCENARIO_SAVE,
                        RecordHelper::SCENARIO_UPDATE
                    ]
                )
            )
        );
    }

    /**
     * Instantiates and populates a new model instance with the given set of attributes.
     *
     * @param array $config Attribute values to populate the model with (name => value).
     *
     * @return static The new model
     */
    public static function create($config = [])
    {

        // Set our class
        $config['class'] = static::className();

        return RecordHelper::create($config);

    }

    /**
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }

}
