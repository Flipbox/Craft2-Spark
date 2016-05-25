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

abstract class RecordWithId extends Record implements Interfaces\RecordWithIdInterface
{

    use Traits\RecordWithIdTrait {
        rules as _traitRules;
    }

    /**
     * {@inheritdoc}
     */
    public function defineIndexes()
    {
        // Set some base attributes;
        return array_merge(
            parent::defineIndexes(),
            $this->defineIdIndex()
        );

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return array_merge(
            parent::rules(),
            $this->_traitRules()
        );

    }

}
