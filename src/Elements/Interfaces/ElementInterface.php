<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Elements\Interfaces;

use Flipbox\Craft2\Spark\Models\Interfaces\ModelInterface;

interface ElementInterface extends ModelInterface
{

    /**
     * Returns the type of element this is.
     *
     * @return string
     */
    public function getElementType();

    /**
     * Returns the content for the element.
     *
     * @return \Craft\ContentModel
     */
    public function getContent();

    /**
     * Sets the content for the element.
     *
     * @param \Craft\ContentModel|array $content
     *
     * @return null
     */
    public function setContent($content);

}
