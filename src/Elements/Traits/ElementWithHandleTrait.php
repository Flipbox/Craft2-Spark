<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Elements\Traits;

use Craft\AttributeType;
use Flipbox\Craft2\Spark\Helpers\ElementHelper;

trait ElementWithHandleTrait
{

    /*******************************************
     * ABSTRACTS
     *******************************************/

    /**
     * @param $name
     * @param $value
     * @return bool
     */
    public abstract function setAttribute($name, $value);

    /**
     * @param $name
     * @return mixed
     */
    public abstract function getAttribute($name);


    /*******************************************
     * DEFINE ATTRIBUTE
     *******************************************/

    /**
     * @return array
     */
    protected function defineHandleAttribute()
    {
        return array(
            'handle' => array(
                AttributeType::Handle,
                'required' => true
            )
        );
    }


    /*******************************************
     * RULES
     *******************************************/

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [
                'handle',
                'safe',
                'on' => [
                    ElementHelper::SCENARIO_POPULATE,
                    ElementHelper::SCENARIO_SAVE,
                    ElementHelper::SCENARIO_INSERT,
                    ElementHelper::SCENARIO_UPDATE
                ]
            ]
        ];
    }


    /*******************************************
     * METHODS
     *******************************************/

    /**
     * @inheritdoc
     */
    public function getHandle()
    {
        return $this->getAttribute('handle');
    }

    /**
     * @inheritdoc
     */
    public function setHandle($handle)
    {
        $this->setAttribute('handle', $handle);
        return $this;
    }

}
