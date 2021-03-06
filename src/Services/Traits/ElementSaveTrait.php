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

use Flipbox\Craft2\Spark\Elements\Interfaces\ElementWithIdInterface;
use Flipbox\Craft2\Spark\Exceptions\InsufficientPrivilegesException;

trait ElementSaveTrait
{

    use ElementInsertTrait, ElementUpdateTrait;

    /*******************************************
     * SAVE
     *******************************************/

    /**
     * @param ElementWithIdInterface $element
     * @param null $attributes
     * @param null $contentAttributes
     * @param bool $mirrorScenario
     * @return bool
     * @throws InsufficientPrivilegesException
     */
    public function save(
        ElementWithIdInterface $element,
        $attributes = null,
        $contentAttributes = null,
        $mirrorScenario = true
    ) {

        // Determine if we're going to create or update
        if (!$element->getId()) {

            return $this->insert($element, $attributes, $contentAttributes, $mirrorScenario);

        }

        return $this->update($element, $attributes, $contentAttributes, $mirrorScenario);

    }

}
