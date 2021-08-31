<?php
namespace Tyz\Inputs;
class Option {
    //提取数据的key
    private $getKey;
    //设置数据的key
    private $setKey;
    //设置一旦获取不到数据，是否忽略
    private $ignore = false;
    //默认值
    private $default = null;
    private $filters = [];

    public function __construct($options = []) {
        if (!empty($options["get"])) {
            $this->getKey = $options["get"];
        }
        if (!empty($options["set"])) {
            $this->setKey = $options["set"];
        }
        if (isset($options["default"])) {
            $this->default = $options["default"];
        }
        if (isset($options["ignore"]) && $options["ignore"] === true) {
            $this->ignore = true;
        }
    }

    public function setProp($key, $value):Option {
        switch ($key) {
            case "get":
                $this->getKey = $value;
                break;
            case "set":
                $this->setKey = $value;
                break;
            case "default":
                $this->default = $value;
                break;
            default:
                break;
        }
        return $this;
    }

    public function getProp($key) {
        switch ($key) {
            case "get":
                return $this->getKey;
            case "set":
                return $this->setKey;
            case "default":
                return $this->default;
            default:
                return null;
        }
    }

    public function setIgnore(bool $flag) {
        $this->ignore = $flag;
    }

    public function isIgnore():bool {
        return $this->ignore;
    }

    public function setFilters(array $filters) {
        foreach ($filters as $filter) {
            if (is_callable($filter)) {
                $this->filters[] = $filter;
            } elseif(is_string($filter) && function_exists($filter)) {
                $this->filters[] = $filter;
            }
        }
    }

    public function unshiftFilters(array $filters) {
        $results = [];
        foreach ($filters as $filter) {
            if (is_callable($filter)) {
                $results[] = $filter;
            } elseif(is_string($filter) && function_exists($filter)) {
                $results[] = $filter;
            }
        }
        $this->filters = array_merge($results, $this->filters);
    }

    public function getFilters():array {
        return $this->filters;
    }

    public function isValid():bool {
        if (empty($this->getKey) || empty($this->setKey)) {
            return false;
        }
        return true;
    }
}