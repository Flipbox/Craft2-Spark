<?php

/**
 * @package    Spark
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Craft2-Spark/blob/master/LICENSE
 * @link       https://github.com/FlipboxFactory/Craft2-Spark
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Craft2\Spark\Models\Interfaces;

use Flipbox\Craft2\Spark\Error\ErrorInterface;

interface ModelInterface extends ErrorInterface
{

    /**
     * @param array $config
     * @return self
     */
    public static function create($config = []);

    /**
     * @return string
     */
    public static function className();

    /**
     * Populates a new model instance with a given set of attributes.
     *
     * @param mixed $values
     *
     * @return ModelInterface
     */
    public static function populateModel($values);

    /**
     * Mass-populates models based on an array of attribute arrays.
     *
     * @param array $data
     * @param string|null $indexBy
     *
     * @return ModelInterface[]
     */
    public static function populateModels($data, $indexBy = null);

    /**
     * Get the class name, sans namespace and suffix.
     *
     * @return string
     */
    public function getClassHandle();

    /**
     * Returns all attribute values.
     * @param array $names list of attributes whose value needs to be returned.
     * Defaults to null, meaning all attributes as listed in {@link attributeNames} will be returned.
     * If it is an array, only the attributes in the array will be returned.
     * @return array attribute values (name=>value).
     */
    public function getAttributes($names = null);

    /**
     * Gets an attribute’s value.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getAttribute($name);

    /**
     * Sets an attribute's value.
     *
     * @param string $name
     * @param mixed $value
     *
     * @return bool
     */
    public function setAttribute($name, $value);

    /**
     * Sets the attribute values in a massive way.
     * @param array $values attribute values (name=>value) to be set.
     * @param boolean $safeOnly whether the assignments should only be done to the safe attributes.
     * A safe attribute is one that is associated with a validation rule in the current {@link scenario}.
     * @see getSafeAttributeNames
     * @see attributeNames
     */
    public function setAttributes($values);

    /**
     * Returns the validation rules for attributes.
     *
     * This method should be overridden to declare validation rules.
     * Each rule is an array with the following structure:
     * <pre>
     * array('attribute list', 'validator name', 'on'=>'scenario name', ...validation parameters...)
     * </pre>
     * where
     * <ul>
     * <li>attribute list: specifies the attributes (separated by commas) to be validated;</li>
     * <li>validator name: specifies the validator to be used. It can be the name of a model class
     *   method, the name of a built-in validator, or a validator class (or its path alias).
     *   A validation method must have the following signature:
     * <pre>
     * // $params refers to validation parameters given in the rule
     * function validatorName($attribute,$params)
     * </pre>
     *   A built-in validator refers to one of the validators declared in {@link CValidator::builtInValidators}.
     *   And a validator class is a class extending {@link CValidator}.</li>
     * <li>on: this specifies the scenarios when the validation rule should be performed.
     *   Separate different scenarios with commas. If this option is not set, the rule
     *   will be applied in any scenario that is not listed in "except". Please see {@link scenario} for more details about this option.</li>
     * <li>except: this specifies the scenarios when the validation rule should not be performed.
     *   Separate different scenarios with commas. Please see {@link scenario} for more details about this option.</li>
     * <li>additional parameters are used to initialize the corresponding validator properties.
     *   Please refer to individual validator class API for possible properties.</li>
     * </ul>
     *
     * The following are some examples:
     * <pre>
     * array(
     *     array('username', 'required'),
     *     array('username', 'length', 'min'=>3, 'max'=>12),
     *     array('password', 'compare', 'compareAttribute'=>'password2', 'on'=>'register'),
     *     array('password', 'authenticate', 'on'=>'login'),
     * );
     * </pre>
     *
     * Note, in order to inherit rules defined in the parent class, a child class needs to
     * merge the parent rules with child rules using functions like array_merge().
     *
     * @return array validation rules to be applied when {@link validate()} is called.
     * @see scenario
     */
    public function rules();

    /**
     * Performs the validation.
     *
     * This method executes the validation rules as declared in {@link rules}.
     * Only the rules applicable to the current {@link scenario} will be executed.
     * A rule is considered applicable to a scenario if its 'on' option is not set
     * or contains the scenario.
     *
     * Errors found during the validation can be retrieved via {@link getErrors}.
     *
     * @param array $attributes list of attributes that should be validated. Defaults to null,
     * meaning any attribute listed in the applicable validation rules should be
     * validated. If this parameter is given as a list of attributes, only
     * the listed attributes will be validated.
     * @param boolean $clearErrors whether to call {@link clearErrors} before performing validation
     * @return boolean whether the validation is successful without any error.
     * @see beforeValidate
     * @see afterValidate
     */
    public function validate($attributes = null, $clearErrors = true);

    /**
     * Returns a copy of this model.
     *
     * @return ModelInterface
     */
    public function copy();


    /**
     * Returns the scenario that this model is used in.
     *
     * Scenario affects how validation is performed and which attributes can
     * be massively assigned.
     *
     * A validation rule will be performed when calling {@link validate()}
     * if its 'except' value does not contain current scenario value while
     * 'on' option is not set or contains the current scenario value.
     *
     * And an attribute can be massively assigned if it is associated with
     * a validation rule for the current scenario. Note that an exception is
     * the {@link CUnsafeValidator unsafe} validator which marks the associated
     * attributes as unsafe and not allowed to be massively assigned.
     *
     * @return string the scenario that this model is in.
     */
    public function getScenario();

    /**
     * Sets the scenario for the model.
     * @param string $value the scenario that this model is in.
     * @see getScenario
     */
    public function setScenario($value);

}
