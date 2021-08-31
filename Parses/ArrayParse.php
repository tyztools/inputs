<?php
namespace Tyz\Inputs\Parses;
use Tyz\Inputs\Option;

class ArrayParse extends BaseParse {
    /**
     * @var Option
     */
    private $option;
    protected $filters = [];
}