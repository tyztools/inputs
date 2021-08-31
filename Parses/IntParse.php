<?php
namespace Tyz\Inputs\Parses;
use Tyz\Inputs\Input;
use Tyz\Inputs\Option;

class IntParse extends BaseParse {
    /**
     * @var Option
     */
    private $option;
    protected $filters = ["intval"];
}