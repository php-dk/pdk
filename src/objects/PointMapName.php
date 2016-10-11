<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 18.05.16
 * Time: 14:27
 */

namespace ToolsPhp\Types\objects;

/**
 * Иминованная точка
 * Class NamePoint
 *
 * @package components\core
 */
class PointMapName extends PointMap
{
    protected $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public static function createByArray($array)
    {
        /** @var static $obj */
        $obj = parent::createByArray($array);
        if (isset($array['name'])) {
            $obj->setName($array['name']);
        }

        return $obj;
    }


    public function toArray()
    {
        return parent::toArray() + [
            'name' => $this->getName()
        ];
    }


}