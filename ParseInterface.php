<?php
namespace Tyz\Inputs;

interface ParseInterface {
    public function register(Input $input, Option $option);
    public function parsed(&$data, array $source);
}