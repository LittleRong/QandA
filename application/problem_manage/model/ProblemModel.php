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
	public function getEventProblem($refer_event_id) {//获得事件关联的题目
		$eventProblem =Db :: table('event_problem')->field('problem_id') -> where('refer_event_id', $refer_event_id) -> select();

		$eventProblemArr=array();
		for($i=0; $i<count($eventProblem); $i++) {
			array_push($eventProblemArr,$eventProblem[$i]['problem_id']);
		}
		Return $eventProblemArr;

	}
	public function getCantSelectProblem($participant) {//获得不能被用户答的题
		$cantProblem = Db :: table('participant_haved_answer') -> field('refer_problem_id') -> where('refer_team_id', $participant['team_id']) -> where('answer_date', date('Y-m-d', time())) -> whereOr('refer_participant_id', $participant['participant_id']) -> select(); // 不能选的题目
		//取出来把不能选的题目id组成数组
		$cantProblem_Arr=array();
		//LogTool::info('------------cantProblem sql---------',$cantProblem);
		for($i=0; $i<count($cantProblem); $i++) {
			array_push($cantProblem_Arr,$cantProblem[$i]['refer_problem_id']);
		}
		Return $cantProblem_Arr;
	}
	public function getPartProblem($participant,$problem_type,$problem_num,$cantProblem,$eventProblem,$if_random) { // 获取参赛者可以答的题目
 			
			if($if_random){
						$partProblem=Db :: table('problem') -> where('problem_id', 'not in', $cantProblem)->where('problem_id', 'in',$eventProblem) -> where('problem_type', $problem_type) -> order('rand()') -> limit($problem_num)-> select();
			}else{
				    $partProblem=Db :: table('problem') -> where('problem_id', 'not in', $cantProblem)->where('problem_id', 'in',$eventProblem) -> where('problem_type', $problem_type) ->  limit($problem_num)-> select();
			}

		Return $partProblem;
	}

}
