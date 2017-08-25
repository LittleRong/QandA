<?php
namespace app\problem_manage\model;
use think\Model;
use think\Db;
use app\problem_manage\tool\LogTool;
class PanticipantModel {
	public function getPanticipant($user_id, $refer_event_id) { // 获取用户的参赛者信息
		$participant = Db :: table('participant') -> where('refer_event_id', $refer_event_id) -> where('user_id', $user_id) -> select(); 
		LogTool::record($participant);
		Return $participant[0];
	} 

	public static function writeWaitedAnswer($pant_id,$waJson) {
		Return Db :: table('participant') -> where('participant_id',$pant_id) -> setField('waited_answer', $waJson);
	} 

	public static function getWaitedAnswer($pant_id) {
		$waited_answer=Db :: table('participant')->field('waited_answer') ->where('participant_id',$pant_id).select();
		Return waited_answer;
	}

	
} 
