<?php
namespace ToolsPhp\Types\interfaces;
/**
 * Interface IStorage
 */
interface IStorage
{
    /**
     * @param $name
     *
     * @return mixed
     */
    public function get($name);

    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function set($name, $value);

    /**
     * @param $name
     *
     * @return mixed
     */
    public function rm($name);


    /**
     * @param $db
     *
     * @return mixed
     */
    public function select($db);
}