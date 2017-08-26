<?php
namespace app\problem_manage\model;
use think\Model;
use think\Db;
use app\problem_manage\tool\LogTool;
class ProblemModel extends Model {
	protected $table = 'problem'; // 对应数据库中的problem表
	
	var $problem_content;
	var $problem_class;
	var $problem_type;
	/**
	 * function __construct($problem_content, $problem_class,$problem_type){
	 * $this -> problem_content = $problem_content;
	 * $this -> problem_class = $problem_class;
	 * $this -> problem_type = $problem_type;
	 * }
	 */
	public function saveOneProblem($problem_content, $problem_class, $problem_type) {
		$data = ['problem_content' => $problem_content, 'problem_class' => $problem_class, 'problem_type' => $problem_type];
		Db :: table('problem') -> insert($data);
	} 
	public static function getProblem() {
		$problems=Db :: table('problem') -> select();
		//$data = ['refer_event_id' => 7, 'user_id' => 3, 'team_id' => 1,'credit'=>0,'leader'=>1];
		//Db :: table('participant') -> insert($data);
		LogTool :: record($problems);
	}
	public static function getProblemFromId($problemIds) { // 输入，id的数组
		$problems=Db :: table('problem') -> where('problem_id', 'in', $problemIds) -> select();
		Return $problems;
	} 

	public function getUserWaitedQ($user_id, $refer_event_id) { // 获取参赛者可以答的题目
		$waitedQ = array();
		// $map = ['refer_event_id' => $refer_event_id, 'user_id' => $user_id];
		$referEvent=Db::table('event')->where('event_id',$refer_event_id)->select();
		//$questNum=$referEvent[0]['event_num'];//每种题目的数量，single_choice_number、多选题数量multiple_choice_number、填空题数量                                                 //fill_number、判断题数量true_or_false_number'
		$participant = Db :: table('participant') -> where('refer_event_id', $refer_event_id) -> where('user_id', $user_id) -> select();

		$HavedAnswer = Db :: table('participant_haved_answer') -> field('refer_problem_id') -> where('refer_team_id', $participant[0]['team_id']) -> where('answer_date', date('Y-m-d', time())) -> whereOr('refer_participant_id', $participant[0]['participant_id']) -> select(); // 不能选的题目 
		// LogTool::record($teamHaved);
		$userWaitedSingleQ = Db :: table('problem') -> where('problem_id', 'not in', json_encode($HavedAnswer)) -> where('problem_type', 1) -> order('rand()') -> limit(2)-> select();// 单选 $questNum[1] 
		$waitedQ ['single']= $userWaitedSingleQ;

		$userWaitedMultiQ=Db :: table('problem') -> where('problem_id', 'not in', json_encode($HavedAnswer)) -> where('problem_type', 2) -> order('rand()') -> limit(2)-> select();// 多选 $questNum[1]
		$waitedQ['multi'] =$userWaitedMultiQ;

		LogTool :: record($waitedQ);
		Return $waitedQ;
	} 
} 
