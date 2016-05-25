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

use Flipbox\Craft2\Spark\Models\Interfaces\ModelInterface;

interface RecordInterface extends ModelInterface
{

    /**
     * @return string
     */
    public function getTableName();

    /**
     * @return bool
     */
    public function isNewRecord();

    /**
     * @param mixed $id
     * @param mixed $condition
     * @param array $params
     *
     * @return static
     */
    public function findById($id, $condition = '', $params = array());

    /**
     * @param mixed $id
     * @param mixed $condition
     * @param array $params
     *
     * @return static[]
     */
    public function findAllById($id, $condition = '', $params = array());

    /**
     * Finds a single active record with the specified condition.
     * @param mixed $condition query condition or criteria.
     * If a string, it is treated as query condition (the WHERE clause);
     * If an array, it is treated as the initial values for constructing a {@link CDbCriteria} object;
     * Otherwise, it should be an instance of {@link CDbCriteria}.
     * @param array $params parameters to be bound to an SQL statement.
     * This is only used when the first parameter is a string (query condition).
     * In other cases, please use {@link CDbCriteria::params} to set parameters.
     * @return static the record found. Null if no record is found.
     */
    public function find($condition = '', $params = array());

    /**
     * Finds all active records satisfying the specified condition.
     * See {@link find()} for detailed explanation about $condition and $params.
     * @param mixed $condition query condition or criteria.
     * @param array $params parameters to be bound to an SQL statement.
     * @return static[] list of active records satisfying the specified condition. An empty array is returned if none is found.
     */
    public function findAll($condition = '', $params = array());

    /**
     * Finds a single active record with the specified primary key.
     * See {@link find()} for detailed explanation about $condition and $params.
     * @param mixed $pk primary key value(s). Use array for multiple primary keys. For composite key, each key value must be an array (column name=>column value).
     * @param mixed $condition query condition or criteria.
     * @param array $params parameters to be bound to an SQL statement.
     * @return static the record found. Null if none is found.
     */
    public function findByPk($pk, $condition = '', $params = array());

    /**
     * Finds all active records with the specified primary keys.
     * See {@link find()} for detailed explanation about $condition and $params.
     * @param mixed $pk primary key value(s). Use array for multiple primary keys. For composite key, each key value must be an array (column name=>column value).
     * @param mixed $condition query condition or criteria.
     * @param array $params parameters to be bound to an SQL statement.
     * @return static[] the records found. An empty array is returned if none is found.
     */
    public function findAllByPk($pk, $condition = '', $params = array());

    /**
     * Finds a single active record that has the specified attribute values.
     * See {@link find()} for detailed explanation about $condition and $params.
     * @param array $attributes list of attribute values (indexed by attribute names) that the active records should match.
     * An attribute value can be an array which will be used to generate an IN condition.
     * @param mixed $condition query condition or criteria.
     * @param array $params parameters to be bound to an SQL statement.
     * @return static the record found. Null if none is found.
     */
    public function findByAttributes($attributes, $condition = '', $params = array());

    /**
     * Finds all active records that have the specified attribute values.
     * See {@link find()} for detailed explanation about $condition and $params.
     * @param array $attributes list of attribute values (indexed by attribute names) that the active records should match.
     * An attribute value can be an array which will be used to generate an IN condition.
     * @param mixed $condition query condition or criteria.
     * @param array $params parameters to be bound to an SQL statement.
     * @return static[] the records found. An empty array is returned if none is found.
     */
    public function findAllByAttributes($attributes, $condition = '', $params = array());

    /**
     * Finds a single active record with the specified SQL statement.
     * @param string $sql the SQL statement
     * @param array $params parameters to be bound to the SQL statement
     * @return static the record found. Null if none is found.
     */
    public function findBySql($sql, $params = array());

    /**
     * Finds all active records using the specified SQL statement.
     * @param string $sql the SQL statement
     * @param array $params parameters to be bound to the SQL statement
     * @return static[] the records found. An empty array is returned if none is found.
     */
    public function findAllBySql($sql, $params = array());

    /**
     * Inserts a row into the table based on this active record attributes.
     * If the table's primary key is auto-incremental and is null before insertion,
     * it will be populated with the actual value after insertion.
     * Note, validation is not performed in this method. You may call {@link validate} to perform the validation.
     * After the record is inserted to DB successfully, its {@link isNewRecord} property will be set false,
     * and its {@link scenario} property will be set to be 'update'.
     * @param array $attributes list of attributes that need to be saved. Defaults to null,
     * meaning all attributes that are loaded from DB will be saved.
     * @return boolean whether the attributes are valid and the record is inserted successfully.
     * @throws \CDbException if the record is not new
     */
    public function insert($attributes = null);

    /**
     * Updates the row represented by this active record.
     * All loaded attributes will be saved to the database.
     * Note, validation is not performed in this method. You may call {@link validate} to perform the validation.
     * @param array $attributes list of attributes that need to be saved. Defaults to null,
     * meaning all attributes that are loaded from DB will be saved.
     * @return boolean whether the update is successful
     * @throws \CDbException if the record is new
     */
    public function update($attributes = null);

    /**
     * Deletes the row corresponding to this active record.
     * @throws \CDbException if the record is new
     * @return boolean whether the deletion is successful.
     */
    public function delete();

}