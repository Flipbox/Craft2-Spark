<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Models;

use Craft\BaseModel;
use Flipbox\Craft2\Spark\Helpers\ModelHelper;
use Flipbox\Craft2\Spark\Models\Interfaces\ModelInterface;

abstract class Model extends BaseModel implements Interfaces\ModelInterface
{

    /**
     * @inheritdoc
     */
    public function rules()
    {

        // Base rules
        $rules = parent::rules();

        // Add UID rule if property exists
        if (in_array('uid', $this->attributeNames())) {
            $rules[] = [
                [
                    'uid'
                ],
                'safe',
                'on' => [
                    ModelHelper::SCENARIO_POPULATE
                ]
            ];
        }

        // Add dateCreated rule if property exists
        if (in_array('dateCreated', $this->attributeNames())) {
            $rules[] = [
                [
                    'dateCreated'
                ],
                'safe',
                'on' => [
                    ModelHelper::SCENARIO_POPULATE
                ]
            ];
        }

        // Add dateUpdated rule if property exists
        if (in_array('dateUpdated', $this->attributeNames())) {
            $rules[] = [
                [
                    'dateUpdated'
                ],
                'safe',
                'on' => [
                    ModelHelper::SCENARIO_POPULATE,
                    ModelHelper::SCENARIO_SAVE,
                    ModelHelper::SCENARIO_UPDATE
                ]
            ];
        }

        return $rules;

    }

    /**
     * @inheritdoc
     */
    public static function create($config = [])
    {

        // Set our class
        $config['class'] = static::className();

        return ModelHelper::create($config);

    }

    /**
     * @return ModelInterface
     */
    public function copy()
    {
        return ModelHelper::copy($this);
    }

    /**
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }

}