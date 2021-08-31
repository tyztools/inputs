<?php
namespace Tyz\Inputs\Parses;
use Tyz\Inputs\Input;
use Tyz\Inputs\Option;

class FloatParse extends BaseParse {
    /**
     * @var Option
     */
    private $option;
    protected $filters = ["floatval"];
}