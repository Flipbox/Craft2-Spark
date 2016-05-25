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

trait ElementWithIdTrait
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
    protected function defineIdAttribute()
    {
        return array(
            'id' => array(
                AttributeType::Number
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
    public function getId()
    {
        return $this->getAttribute('id');
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        $this->setAttribute('id', $id);
        return $this;
    }

}
