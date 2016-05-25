<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Records\Traits;

use Flipbox\Craft2\Spark\Helpers\RecordHelper;

trait RecordWithIdTrait
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
     * {@inheritdoc}
     */
    protected function defineIdIndex()
    {
        return array(
            array(
                'columns' => array('id'),
                'unique' => true
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
                'id',
                'safe',
                'on' => [
                    RecordHelper::SCENARIO_SAVE,
                    RecordHelper::SCENARIO_UPDATE
                ]
            ]
        ];
    }


    /*******************************************
     * METHODS
     *******************************************/

    /**
     * @return int
     */
    public function getId()
    {
        return (int)$this->getAttribute('id');
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
