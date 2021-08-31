<?php
namespace Tyz\Inputs;
class ParseFactory {
    /**
     * @param $type
     * @return ParseInterface|void
     */
    public static function getParseByType($type) {
        $class = "Tyz\\Inputs\\Parses\\" . ucfirst($type)."Parse";
        if (!class_exists($class)) {
            return;
        }
        return new $class;
    }
}