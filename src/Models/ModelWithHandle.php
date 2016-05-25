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

abstract class ModelWithHandle extends Model implements Interfaces\ModelWithHandleInterface
{

    use Traits\ModelWithHandleTrait {
        rules as _traitRules;
    }

    /**
     * @inheritdoc
     */
    protected function defineAttributes()
    {

        return array_merge(
            parent::defineAttributes(),
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
            $this->_traitRules()
        );

    }

}
