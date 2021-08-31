<?php
namespace Tyz\Inputs\Parses;
use Tyz\Inputs\Input;
use Tyz\Inputs\Option;
use Tyz\Inputs\ParseInterface;

abstract class BaseParse implements ParseInterface {
    /**
     * @var Option
     */
    private $option;
    protected $filters = [];

    public function register(Input $input, Option $option) {
        $this->option = $option;
        if ($this->filters) {
            $this->option->unshiftFilters($this->filters);
        }
        $input->setParse($this);
    }

    public function parsed(&$data, array $source) {
        $isIgnore = $this->option->isIgnore();
        $get = $this->option->getProp("get");
        $set = $this->option->getProp("set");
        if (!isset($source[$get]) && $isIgnore) {
            return;
        }
        if (isset($source[$get])) {
            $res = $source[$get];
            try {
                $this->filterData($res, $this->option->getFilters());
            } catch (\Exception $e) {

            }
        } else {
            $res = $this->option->getProp("default");
        }
        $data[$set] = $res;
    }

    public function filterData(&$data, $filters) {
        foreach ($filters as $filter) {
            if (is_callable($filter)) {
                $data = $filter($data);
            } elseif(is_string($filter) && function_exists($filter)) {
                $data = $filter($data);
            }
        }
    }
}