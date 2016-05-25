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

abstract class RecordWithIdAndHandle extends Record implements Interfaces\RecordWithIdInterface, Interfaces\RecordWithHandleInterface
{

    use Traits\RecordWithIdTrait, Traits\RecordWithHandleTrait {
        Traits\RecordWithIdTrait::rules as _traitRulesWithId;
        Traits\RecordWithHandleTrait::rules as _traitRulesWithHandle;
    }

    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {

        // Set some base attributes;
        return array_merge(
            parent::defineAttributes(),
            $this->defineHandleAttribute()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function defineIndexes()
    {
        // Set some base attributes;
        return array_merge(
            parent::defineIndexes(),
            $this->defineIdIndex(),
            $this->defineHandleIndex()
        );

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return array_merge(
            parent::rules(),
            $this->_traitRulesWithId(),
            $this->_traitRulesWithHandle()
        );

    }

}
