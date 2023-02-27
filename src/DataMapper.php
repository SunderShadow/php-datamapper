<?php

namespace Sander\Data;

class DataMapper
{
    const DIVIDER = '.';
    const EACH_ITEM = '*';

    public function __construct(
        public array $data
    )
    {}

    public function get(string $map): \Generator
    {
        return static::getData(explode(static::DIVIDER, $map), $this->data);
    }

    public static function getData(array $map, &$data): \Generator
    {
        $item = $data;

        for ($i = 0; $i < count($map); $i++) {
            if ($map[$i] === static::EACH_ITEM) {
                $newMap = array_slice($map, $i + 1);

                foreach ($item as &$it) {
                    yield from static::getData($newMap, $it);
                }

                return;
            }

            $item = $item[$map[$i]];
        }

        yield $item;
    }
}