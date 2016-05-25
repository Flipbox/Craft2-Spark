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

trait ElementWithStateTrait
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
    protected function defineStateAttribute()
    {
        return array(
            'enabled' => array(
                AttributeType::Bool
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
                'enabled',
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
    public function isEnabled()
    {
        return (bool)$this->getAttribute('enabled');
    }

    /**
     * @inheritdoc
     */
    public function isDisabled()
    {
        return !$this->isEnabled();
    }

    /**
     * @inheritdoc
     */
    public function toEnabled()
    {
        $this->setAttribute('enabled', true);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function toDisabled()
    {
        $this->setAttribute('enabled', false);
        return $this;
    }

}
