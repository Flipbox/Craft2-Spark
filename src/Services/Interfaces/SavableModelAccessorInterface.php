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

interface SavableModelAccessorInterface
{

    /**
     * @param ModelWithIdInterface $model
     * @param null $attributes
     * @param bool $mirrorScenario
     * @return bool
     */
    public function save(ModelWithIdInterface $model, $attributes = null, $mirrorScenario = true);

    /**
     * @param ModelWithIdInterface $model
     * @param null $attributes
     * @param bool $mirrorScenario
     * @return bool
     */
    public function update(ModelWithIdInterface $model, $attributes = null, $mirrorScenario = true);

    /**
     * @param ModelWithIdInterface $model
     * @param null $attributes
     * @param bool $mirrorScenario
     * @return bool
     */
    public function insert(ModelWithIdInterface $model, $attributes = null, $mirrorScenario = true);

}
