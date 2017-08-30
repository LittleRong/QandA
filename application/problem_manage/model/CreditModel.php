<?php
namespace app\problem_manage\model;
use think\Model;
use think\Db;
use app\problem_manage\tool\LogTool;
class CreditModel {
  //var $credit_rule = array('single_choice_score' => 2,'multiple_choice_score'=>4);
  var $fill_score;//  填空题分数fill_score
  var $team_score;//当日团队全对额外加分team_score
  var $judge_score;//、判断题分数judge_score、
  var $person_score;//当日本人全对额外加分person_score
  var $single_score;//单选题分数single_score
  var $team_score_up;//团队总积分上限team_score_up
  var $multiple_score;//多选题分数multiple_score
  var $person_score_up;//个人总积分上限person_score_up
  var $part_have_score;//参赛者已有分数
  var $team_have_score;//队伍已有分数
  var $answer_score=0;//答题分数
  var $if_all_right=1;//判断用户答题是否全对
  var $participant_id;
  var $refer_event_id;
  var $answer_num=0;
  function __construct($refer_event_id,$participant_id) {
    $this->participant_id=$participant_id;
      $this->refer_event_id=$refer_event_id;
      $res=Db :: table('event')->field('credit_rule') ->where('event_id',$refer_event_id)->select();
    //  $part=Db :: table('participant')->field('credit,team_id') ->where('participant_id',$participant_id)->select();
      //$this->part_have_score=$part[0]['credit'];//获得参赛者个人积分
      //$team=Db :: table('team')->where('team_id',$part[0]['team_id'])->select();
    //  $this->$team_have_score=$team[0]['']
      //$this->part_have_score=$part[0]['credit'];//获得参赛者个人积分
      $credit_rule=json_decode($res[0]['credit_rule'],true);
      $this->fill_score=$credit_rule['fill_score'];
      $this->team_score=$credit_rule['team_score'];
      $this->judge_score=$credit_rule['judge_score'];
      $this->person_score=$credit_rule['person_score'];
      $this->single_score=$credit_rule['single_score'];
      $this->team_score_up=$credit_rule['team_score_up'];
      $this->multiple_score=$credit_rule['multiple_score'];
      $this->person_score_up=$credit_rule['person_score_up'];

  }

  public function dealAnswer($ifRight,$type){
    $this->answer_num=$this->answer_num+1;
    if($ifRight){
      switch ($type) {
        case 'single':
          $this->answer_score=$this->answer_score+$this->single_score;
          break;
          case 'multi':
            $this->answer_score=$this->answer_score+$this->multiple_score;
            break;
            case 'judge':
              $this->answer_score=$this->answer_score+$this->judge_score;
              break;
              case 'fill':
                $this->answer_score=$this->answer_score+$this->fill_score;
                break;

      }

    }else{
        $this->if_all_right=0;

    }


  }
  private function judgeIfTeamRight($team_id){
        $res=Db :: table('participant_haved_answer')
        -> where('refer_team_id',$team_id)
        -> where('answer_date',date('Y-m-d', time()))
        -> where('refer_participant_id','<>',$this->participant_id)
        -> where('true_or_false',1)
        -> select();
        if(count($res)<$this->answer_num*2){
              Return 0;

        }else{
          Return 1;
        }



  }
  public function dealFinal(){
      $part_add_score=$this->answer_score;

      if($this->if_all_right){
            $part_score=  $part_add_score+$this->person_score;
      }
      $part_res=Db :: table('participant') -> where('participant_id',$this->participant_id) -> select();
      //$old_credit=$part_res[0]['credit'];
        Db :: table('participant')-> where('participant_id',$this->participant_id) -> setInc('credit', $part_add_score);
      //*****************处理team的分数***************************//

      $team_add_score=$this->answer_score;
      if($this->judgeIfTeamRight($part_res[0]['team_id'])){
          $team_add_score=$team_add_score+$team_score;
      }
      Db :: table('team') -> where('team_id',$part_res[0]['team_id']) -> setInc('team_credit', $team_add_score);
      //分数

      $res_final=array();
      $part_final=Db :: table('participant')
      -> where('participant_id',$this->participant_id) ->select();
      
      $team_final=Db :: table('team') -> where('team_id',$part_res[0]['team_id']) ->select();
      LogTool::info('--------------$team_final-----------',$team_final);
      $team_mates=Db::view('user','name,login_name')
    ->view('participant','credit','participant.user_id=user.id')
    -> where('team_id',$part_res[0]['team_id'])
    ->select();
      $res_final['user_credit']=$part_final[0]['credit'];
      $res_final['team']=$team_final[0]['team_credit'];
      $res_final['team_mates']=$team_mates;
      Return $res_final;

  }



}
