<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Services\Traits;

use Flipbox\Craft2\Spark\Exceptions\InsufficientPrivilegesException;
use Flipbox\Craft2\Spark\Models\Interfaces\ModelWithIdInterface;

trait ModelSaveTrait
{

    use ModelInsertTrait, ModelUpdateTrait;

    /*******************************************
     * SAVE
     *******************************************/

    /**
     * @param ModelWithIdInterface $model
     * @param null $attributes
     * @param bool $mirrorScenario
     * @return bool
     * @throws InsufficientPrivilegesException
     */
    public function save(ModelWithIdInterface $model, $attributes = null, $mirrorScenario = true)
    {

        // Determine if we're going to create or update
        if (!$model->getId()) {

            return $this->insert($model, $attributes, $mirrorScenario);

        }

        return $this->update($model, $attributes, $mirrorScenario);

    }

}
