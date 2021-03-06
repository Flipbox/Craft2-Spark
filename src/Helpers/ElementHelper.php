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

use Flipbox\Craft2\Spark\Elements\Interfaces\ElementInterface;
use Flipbox\Craft2\Spark\Exceptions\InvalidConfigurationException;

class ElementHelper
{

    /**
     * The scenario used to populate an element
     */
    const SCENARIO_POPULATE = 'populate';

    /**
     * The scenario used to insert an element
     */
    const SCENARIO_INSERT = 'insert';

    /**
     * The scenario used to update an element
     */
    const SCENARIO_UPDATE = 'update';

    /**
     * The scenario used to save an element
     */
    const SCENARIO_SAVE = 'save';

    /**
     * @param $config
     * @param null $instanceOf
     * @param string $toScenario
     * @return ElementInterface
     * @throws InvalidConfigurationException
     */
    public static function create($config, $instanceOf = null, $toScenario = self::SCENARIO_UPDATE)
    {

        // Get class from config
        $class = ObjectHelper::checkConfig($config, $instanceOf);

        // New model
        $model = new $class();

        return static::populate($model, $config, $toScenario);

    }

    /**
     * @param $model
     * @return ElementInterface
     */
    public static function copy($model)
    {
        if ($model instanceof ElementInterface) {

            return $model::create($model->getAttributes());

        }
        return static::create($model);
    }

    /**
     * @param ElementInterface $element
     * @param $config
     * @param string $toScenario
     * @return ElementInterface
     */
    public static function populate(ElementInterface $element, $config, $toScenario = ModelHelper::SCENARIO_UPDATE)
    {

        // Set scenario
        if (!$toScenario) {

            $toScenario = $element->getScenario();

        }

        // Always set the populate scenario
        $element->setScenario(static::SCENARIO_POPULATE);

        // Populate model attributes
        $element->setAttributes($config);

        // Set scenario
        $element->setScenario($toScenario);

        return $element;

    }

}
