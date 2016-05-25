<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Records\Interfaces;

interface RecordWithStateInterface extends RecordInterface
{

    /**
     * @return bool
     */
    public function isEnabled();

    /**
     * @return bool
     */
    public function isDisabled();

    /**
     * @return $this
     */
    public function toEnabled();

    /**
     * @return $this
     */
    public function toDisabled();

}
