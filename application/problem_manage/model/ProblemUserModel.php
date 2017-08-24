<?php
namespace app\problem_manage\model;

class ProblemUserModel {
	var $single;
	var $multi;
	var $judge;
	var $planDate;//计划答题时间，过了不算
	function __construct($single,$multi) {
		$this -> single = $single;
		$this -> multi = $multi;

		$this-> planDate=date('Y-m-d', time());
	} 
} 
