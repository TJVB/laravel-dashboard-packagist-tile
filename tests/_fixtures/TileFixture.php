<?php

namespace TJVB\PackagistTile\Tests\_fixtures;

use Illuminate\Support\Arr;

class TileFixture extends \Spatie\Dashboard\Models\Tile
{
    public $data = [];

    public static $tiles = [];

    public static function firstOrCreateForName(string $name): self
    {
        if (!isset(self::$tiles[$name])) {
            $object = new self();
            $object->name = $name;
            self::$tiles[$name] = $object;
        }
        return self::$tiles[$name];
    }

    public function putData($name, $value)
    {
        $this->data[$name] = $value;
        return $this;
    }

    public function getData(string $name)
    {
        return Arr::get($this->data, $name);
    }
}
