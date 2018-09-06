<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 24/08/2018
 * Time: 4:39 PM
 */

// 仅为了支持Google Proto的JSON解析，肯定都是int64
if(!extension_loaded("bcmath")) {
    function bcadd($left_operand,  $right_operand, $scale = 0 )
    {
        return (string)(intval($left_operand) + intval($right_operand));
    }

    function bccomp($left_operand, $right_operand, $scale = 0)
    {
        $left_operand = intval($left_operand);
        $right_operand = intval($right_operand);

        if($left_operand > $right_operand) {
            return 1;
        } else if($left_operand == $right_operand) {
            return 0;
        } else {
            return -1;
        }
    }

    function bcsub($left_operand, $right_operand, $scale = 0)
    {
        return (string)(intval($left_operand) - intval($right_operand));
    }
}