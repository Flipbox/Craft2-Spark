<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Services\Interfaces;

use Flipbox\Craft2\Spark\Models\Interfaces\ModelWithIdInterface;

interface DeletableModelAccessorInterface
{

    /**
     * @param ModelWithIdInterface $model
     * @return bool
     */
    public function delete(ModelWithIdInterface $model);

}