<?php
namespace app\problem_manage\controller;
use think\Controller;
use app\problem_manage\model\ProblemModel;
use app\problem_manage\model\ProblemContentModel;
use app\problem_manage\model\ProblemUserModel;
use app\problem_manage\model\PanticipantModel;
use app\problem_manage\tool\LogTool;
use think\Db;
class Problem extends Controller{
	public function index() {
	} 
	public function getSy() {
		echo("sy");
		$a = Db :: table('problem') -> order('rand()') -> limit(5) -> select();
		LogTool :: record($a);
	} 

	private function buildOption($single_pros) { // 建立选择题选项，打乱选项
		
		$shuffled = array();
		$answer = array(); //答案
		for($i = 0; $i < count($single_pros);$i++) {
			$problem_content = json_decode($single_pros[$i]['problem_content']);
			$option = LogTool :: object2array($problem_content -> option); //取出来是object，转array
			
			$keys = array_keys($option);
			shuffle($keys);
			$question_option = array();
			for($key_i = 0; $key_i < count($keys);$key_i++) {
				$question_option[chr(65 + $key_i)] = array('q_id' => $keys[$key_i], 'content' => $option[$keys[$key_i]]);
			} 

			$shuffled[$i] = array('problem_id' => $single_pros[$i]['problem_id'], 'problem' => $problem_content -> problem, 'option' => $question_option); 
			// LogTool :: record($problem_content);
			$answer[$single_pros[$i]['problem_id']] = $problem_content -> answer;
		} 
		$res = array('problem' => $shuffled, 'answer' => $answer);
		Return $res;
	} 

	private function rebuildQuestion($user_id, $event_id, $pant) { // 完全重新生成题目
		$pm = new ProblemModel();
		$waitedQ = $pm -> getUserWaitedQ($user_id, $event_id);
		//**********************单选***********************************//
		$single_pros = $waitedQ['single'];
		$singleRes = $this -> buildOption($single_pros);
		$single_d_pros = $singleRes['problem'];
		//**********************多选**********************************//
		$multi_pros = $waitedQ['multi'];
		$multiRes = $this -> buildOption($multi_pros);
		$multi_d_pros = $multiRes['problem'];
		//**********************************************************//
		
		$pum_answer = new ProblemUserModel($singleRes['answer'],$multiRes['answer']);
		//PanticipantModel :: writeWaitedAnswer($pant['participant_id'], json_encode($pum)); //把生成的题目id和答案保存到数据库
		//LogTool :: record(json_encode($pum));
		$pum_problem=new ProblemUserModel($single_d_pros,$multi_d_pros);
		Return $pum_problem;

	} 
	private function buildQuestion($pant) { // 从panticipant表的waited_answer找的本来就要答的题目
		$all_answer = json_decode($pant['waited_answer']); //json变obj,格式problem_id:正确选项  
		// single=>{"10":"a","2":"a","17":"a","12":"a","5":"a"},multi=>....
		$single_answer = Logtool :: object2array($all_answer -> single);
		LogTool :: record($single_answer);
		$singleProId = array_keys($single_answer);
		$single_pros = ProblemModel :: getProblemFromId($singleProId); //得到single的题目
		$single_d_pros = $this -> buildOption($single_pros);
		//LogTool :: record(json_encode($single_d_pros)); 
		// 未完成！！！！
	} 
	public function getUserProblem() {
		$user_id = 3;
		$refer_event_id = 7;
		$pantM = new PanticipantModel();
		$pant = $pantM -> getPanticipant($user_id, $refer_event_id); //array ('participant_id' => 1, 'refer_event_id' => 1, 'user_id' =>     
		// 1,'team_id' => 1,'credit' => 0,'leader' => 0, 'waited_answer' => NULL,
		$ifRebuild = 0; //用来判断是否重新生成题目  
		// LogTool::record($pant);
		if ($pant['waited_answer']) {
			if (json_decode($pant['waited_answer']) -> planDate == date('Y-m-d', time())) { // 判断题目是否是当天的
				//$ifRebuild = 1;
			} 
		} 
		$res=null;
		if ($ifRebuild) {
			$res=$this -> buildQuestion($pant);
		} else {
			$res=$this -> rebuildQuestion($user_id, $refer_event_id, $pant);
		} 
		LogTool :: record(json_encode($res));

		$this->assign('data',$res);
		//$this->fetch('');
	} 

	public function getNewProblem() { // 写入新题目
		print("geNewProblem");
		$pcm = new ProblemContentModel();
		$pcm_json = json_encode($pcm);
		$pm = new ProblemModel();

		$pm -> saveOneProblem($pcm_json, 2, 2);
	} 

	public function getProblem() {
		ProblemModel::getProblem();
	}
	public function save() {
	} 
	public function update() {
	} 
	public function delete() {
	} 
} 
