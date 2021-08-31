<?php
namespace Tyz\Inputs;

class OptionFactory {
    public static function getOption(array $params):Option {
        return new Option($params);
    }

    public static function getIgnoreOption(array $params):Option {
        $option = static::getOption($params);
        $option->setIgnore(true);
        return $option;
    }

    /**
     * 根据类型接收参数获取option
     * @param $params
     * @return Option
     */
    public static function getOptionByTypeVar(array $params):Option {
        $optionParam = [];
        !empty($params[0]) && $optionParam["get"] = $params[0];//接收get参数
        !empty($params[1]) && $optionParam["set"] = $params[1];//接收set参数
        isset($params[2]) && $optionParam["default"] = $params[2];//接收默认值
        $option = new Option($optionParam);
        isset($params[3]) && $params[3] === true && $option->setIgnore(true);
        if (isset($params[4]) && is_array($params[4])) {
            $option->setFilters($params[4]);
        }
        return $option;
    }
}