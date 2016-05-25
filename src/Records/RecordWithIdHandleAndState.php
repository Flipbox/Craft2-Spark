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

abstract class RecordWithIdHandleAndState extends RecordWithIdAndHandle implements Interfaces\RecordWithStateInterface
{

    use Traits\RecordWithStateTrait {
        rules as _traitRules;
    }

    /**
     * @inheritdoc
     */
    protected function defineAttributes()
    {

        return array_merge(
            parent::defineAttributes(),
            $this->defineStateAttribute()
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
