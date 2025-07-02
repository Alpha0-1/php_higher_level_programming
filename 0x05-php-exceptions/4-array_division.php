<?php
/**
 * 4-array_division.php - Divide corresponding elements of two arrays.
 *
 * Performs element-wise division of two arrays safely.
 */

function arrayDivision($arr1, $arr2) {
    try {
        if (!is_array($arr1) || !is_array($arr2)) {
            throw new Exception("Inputs must be arrays.");
        }
        if (count($arr1) != count($arr2)) {
            throw new Exception("Arrays must be of equal length.");
        }

        $result = [];
        foreach ($arr1 as $i => $val) {
            if (!isset($arr2[$i])) {
                throw new Exception("Index mismatch at position $i.");
            }
            if ($arr2[$i] == 0) {
                throw new Exception("Division by zero at index $i.");
            }
            $result[] = $val / $arr2[$i];
        }
        print_r($result);
    } catch (Exception $e) {

