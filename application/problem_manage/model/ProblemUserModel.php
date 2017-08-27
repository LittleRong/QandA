<?php
namespace app\problem_manage\model;

class ProblemUserModel {
	var $single;
	var $multi;
	var $judge;
	var $fill;
	var $planDate;//计划答题时间，过了不算
	function __construct() {
		$this-> planDate=date('Y-m-d', time());
	} 
	public function setSingle($single) {
		$this -> single = $single;
	}
	public function setMulti($multi) {
		$this -> multi = $multi;
	}
	public function setJudge($judge) {
		$this->judge=$judge;
	}
	public function setfill($fill) {
		$this -> fill = $fill;
	}
} 
