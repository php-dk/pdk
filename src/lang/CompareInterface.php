<?php

namespace phpdk\lang;


interface CompareInterface
{
    /**
     * operation: <
     *
     * @param $object
     * @return bool
     */
    public function less($object): bool;

    /**
     * operation: >
     *
     * @param $object
     * @return bool
     */
    public function more($object): bool;

    /**
     * operation: >=
     *
     * @param $object
     * @return bool
     */
    public function moreEquals($object): bool;

    /**
     * operation: <=
     *
     * @param $object
     * @return bool
     */
    public function lessEquals($object): bool;

    /**
     * operation: =
     *
     * @param $object
     * @return bool
     */
    public function equals($object): bool;

    /**
     * operation: !=
     *
     * @param $object
     * @return bool
     */
    public function notEqual($object): bool;
}