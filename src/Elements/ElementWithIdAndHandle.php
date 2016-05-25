<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Elements;

abstract class ElementWithIdAndHandle extends Element implements Interfaces\ElementWithIdInterface, Interfaces\ElementWithHandleInterface
{

    use Traits\ElementWithIdTrait, Traits\ElementWithHandleTrait {
        Traits\ElementWithIdTrait::rules as _traitRulesWithId;
        Traits\ElementWithHandleTrait::rules as _traitRulesWithHandle;
    }

    /**
     * @inheritdoc
     */
    protected function defineAttributes()
    {

        return array_merge(
            parent::defineAttributes(),
            $this->defineIdAttribute(),
            $this->defineHandleAttribute()
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
