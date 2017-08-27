<?php
namespace app\problem_manage\controller;
use think\Controller;
use app\problem_manage\model\ProblemModel;
use app\problem_manage\model\ProblemContentModel;
use app\problem_manage\model\ProblemUserModel;
use app\problem_manage\model\ParticipantModel;
use app\problem_manage\tool\LogTool;
use think\Db;
class ProblemController extends Controller{
	var $partModel ;
	var $part;//用户所属的参赛者
	var $pm ;
	public function _initialize()
    {
        $this->partModel=new ParticipantModel();
		$this->pm=new ProblemModel();
		
    }
	public function index() {
	} 
	public function getSy() {
		echo("sy");
		$a = Db :: table('problem') -> order('rand()') -> limit(5) -> select();
		LogTool :: info('--------------',$a);
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
	private function dealNoOption($pros) {//处理非选择题
		$d_pro=array();
		$answer=array();
		for($i=0; $i<count($pros); $i++) {
			$problem_content = json_decode($pros[$i]['problem_content']);
			$d_pro[$i]=array('problem_id'=>$pros[$i]['problem_id'],'problem'=>$problem_content -> problem);
			$answer[$pros[$i]['problem_id']] = $problem_content -> answer;
		}
		$res = array('problem' => $d_pro, 'answer' => $answer);
		Return $res;
	}
	private function rebuildQuestion() { // 完全重新生成题目

		$eventProblem=$this-> pm ->getEventProblem($this->part['refer_event_id']);
		$cantProblem=$this-> pm ->getCantSelectProblem($this->part);
		$questNum=['single'=>3,'multiple'=>3,'judge'=>3,'fill'=>3];
		$pum_answer = new ProblemUserModel();
		$pum_problem = new ProblemUserModel();
		//$waitedQ = $this-> pm -> getUserWaitedQ($this->part, $cantProblem,$eventProblem);//得到用户需要答的题目
		//***********************填空***********************************//
		if($questNum['fill']>0) {
			$fill_pros=$this-> pm ->getPartProblem($this->part,0,$questNum['fill'],$cantProblem,$eventProblem);
			$fillRes = $this -> dealNoOption($fill_pros);
			$pum_answer->setfill($fillRes['answer']);
			$pum_problem->setfill($fillRes['problem']);
		}
		//**********************单选***********************************//
		if($questNum['single']>0) {
			$single_pros = $this-> pm ->getPartProblem($this->part,1,$questNum['single'],$cantProblem,$eventProblem);
			$singleRes= $this -> buildOption($single_pros);
			$pum_answer->setSingle($singleRes['answer']);
			$pum_problem->setSingle($singleRes['problem']);
		}
		
		//**********************多选**********************************//
		if($questNum['multiple']>0) {
			$multi_pros = $this-> pm ->getPartProblem($this->part,2,$questNum['multiple'],$cantProblem,$eventProblem);
			$multiRes = $this -> buildOption($multi_pros);
			$pum_answer->setMulti($multiRes['answer']);
			$pum_problem->setMulti($multiRes['problem']);
		}
		
		//**********************判断***********************************//
		if($questNum['judge']>0) {
			$judge_pros=$this-> pm ->getPartProblem($this->part,3,$questNum['judge'],$cantProblem,$eventProblem);
			$judgeRes = $this -> dealNoOption($multi_pros);
			$pum_answer->setJudge($judgeRes['answer']);
			$pum_problem->setJudge($judgeRes['problem']);
		}

		ParticipantModel :: writeWaitedAnswer($this->part['participant_id'], json_encode($pum_answer)); //把生成的题目id和答案保存到数据库
		LogTool :: info('------------$pum_answer-------',json_encode($pum_answer));
		Return $pum_problem;

	} 
	private function buildQuestion() { // 从participant表的waited_answer找的本来就要答的题目
		$all_answer = json_decode($this->part['waited_answer']); //json变obj,格式problem_id:正确选项  
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
		$user_id = 1;
		$refer_event_id = 46;
		$this->part = $this->partModel -> getParticipant($user_id, $refer_event_id); //array ('participant_id' => 1, 'refer_event_id' => 1, 'user_id' =>     
		// 1,'team_id' => 1,'credit' => 0,'leader' => 0, 'waited_answer' => NULL,
		$ifRebuild = 0; //用来判断是否重新生成题目  
		// LogTool::record($pant);
		if ($this->part['waited_answer']) {
			if (json_decode($this->part['waited_answer']) -> planDate == date('Y-m-d', time())) { // 判断题目是否是当天的
				//$ifRebuild = 1;
			} 
		} 
		$res=null;
		if ($ifRebuild) {
			$res=$this -> buildQuestion();
		} else {
			$res=$this -> rebuildQuestion();
		} 
		$res = json_decode(json_encode($res),true);//转换为数组，方便传输给页面
		LogTool :: info('----------------getUserProblem最后生成的问题---------------------',$res);
		$this->assign('data',$res);
		return $this->fetch('user_problem/user_problem');
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

} 
