<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 09.07.17
 * Time: 1:58
 */

namespace phpdk\util;

/**
 * Interface CollectionInterface
 * @package phpdk\util
 *
 * @see https://docs.oracle.com/javase/7/docs/api/java/util/Collection.html
 */
interface CollectionInterface
{
    /**
     * Ensures that this collection contains the specified element (optional operation).
     * @param $object
     * @return mixed
     */
    public function add($object);

    /**
     * @param static $collection
     * @return mixed
     */
    public function addAll($collection);

    /**
     * @param static $collection
     * @return mixed
     */
    public function removeAll($collection);

    public function clear(): void;

    public function equals($object): bool;

}