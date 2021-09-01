<?php
namespace Tyz\Inputs;

class Input
{
    private $_parses = [];

    public function parsed(&$output, $source)
    {
        foreach ($this->_parses as $parse) {
            $parse->parsed($output, $source);
        }
    }

    /**
     * 数组类型接收
     * @param $get
     * @param $set
     * @param null $default
     * @param false $igNore
     * @param array $filters
     */
    public function arrayVar($get, $set, $default = null, $igNore = false, $filters = [])
    {
        $params = [
            "get"     => $get,
            "set"     => $set,
            "default" => $default,
        ];
        $option = OptionFactory::getOption($params);
        if (!$option->isValid()) {
            return;
        }
        $igNore && $option->setIgnore(true);
        $option->setFilters($filters);
        $parse = ParseFactory::getParseByType("array");
        $parse->register($this, $option);
    }

    public function typeVarMulti($type, array $fields, $defaults = [], $options = [])
    {
        foreach ($fields as $k => $v) {
            $set = $v;
            $get = is_string($k) ? $k : $v;
            if (is_array($defaults)) {
                $default = $defaults[$k] ?? ($defaults['default'] ?? null);
            } else {
                $default = $defaults;
            }
            if (is_object($options) && $options instanceof Option) {
                $option = $options;
                $option->setProp("get", $get)->setProp("set", $set)->setProp("default", $default);
            } elseif (is_array($options) && isset($options[$get]) && $options[$get] instanceof Option) {
                $option = $options[$get];
                $option->setProp("get", $get)->setProp("set", $set)->setProp("default", $default);
            } else {
                $option = new Option(["get" => $get, "set" => $set, "default" => $default]);
            }
            if (!$option->isValid()) {
                continue;
            }
            $method = $type . "Var";
            $this->$method($option);
        }
    }

    /**
     *
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        if (substr($name, -3) != "Var") {
            return;
        }
        $parse = ParseFactory::getParseByType(substr($name, 0, -3));
        if (empty($parse)) {
            return;
        }
        if (!empty($arguments[0]) && $arguments[0] instanceof Option) {
            $option = $arguments[0];
        } else {
            $option = OptionFactory::getOptionByTypeVar($arguments);
        }
        if (!$option->isValid()) {
            return;
        }
        $parse->register($this, $option);
    }

    public function setParse(ParseInterface $parse)
    {
        $this->_parses[] = $parse;
    }
}
