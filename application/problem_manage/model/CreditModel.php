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
  var $participant;
  var $answer_num=0;
  function __construct($participant) {
      $this->participant=$participant;
      $this->participant_id=$participant['participant_id'];
      $this->refer_event_id=$participant['refer_event_id'];
      $res=Db :: table('event')->field('credit_rule') ->where('event_id',$participant['refer_event_id'])->select();
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
  private function addTeamScore($team,$score){
        $credit_add=$score;
        $score_add=$score;
        if(($team['team_credit']+$score)>$this->team_score_up){
              $credit_add=$this->team_score_up-$team['team_credit'];
        }
        if(($team['team_score']+$score)>$this->team_score_up){
              $score_add=$this->team_score_up-$team['team_score'];
        }
        Db :: table('team') -> where('team_id',$team['team_id'])
        ->inc('team_score', $score_add)
        ->inc('team_credit', $credit_add)
        ->update();

        $data=[];
        $data['team_id']=$team['team_id'];
        $data['refer_event_id']=$this->refer_event_id;
        $data['change_time']=date('Y-m-d H:i:s', time());
        $data['change_value']=$score;
        $data['change_reason']='增加';
        $data['item_id']=0;
        Db::table('credit')->insert($data);

  }
  public function dealFinal(){
      $part_add_score=$this->answer_score;
      $res_final=array();//最后返回的结果array
      if($this->if_all_right){
            $part_add_score=  $part_add_score+$this->person_score;
            $res_final['user_all_right']=$this->person_score;
      }
      $this->participant['credit']=$this->participant['credit']+$part_add_score;
      if($this->participant['credit']>$this->person_score_up){
            Db::table('participant')
              ->where('participant_id',$this->participant_id)
              ->update(['credit' => $this->person_score_up]);

      }else{
            Db :: table('participant')
              -> where('participant_id',$this->participant_id)
              -> setInc('credit', $part_add_score);
      }


      //*****************处理team的分数***************************//
      $team_s=Db :: table('team') -> where('team_id',$this->participant['team_id']) ->select();
      $team=$team_s[0];
      $team_add_score=$this->answer_score;

      if($this->judgeIfTeamRight($this->participant['team_id'])){
          $team_add_score=$team_add_score+$this->team_score;
          $res_final['team_all_right']=$this->team_score;
      }

      $this->addTeamScore($team,$team_add_score);

      //LogTool::info('--------------$team_final-----------',$team);
      //********************************最后***************************************

      $team_mates=Db::view('user','name,login_name')
        ->view('participant','credit','participant.user_id=user.id')
        -> where('team_id',$this->participant['team_id'])
        ->select();
      $res_final['user_credit']=$this->participant['credit']+$part_add_score;
      $res_final['team_credit']=$team['team_credit'];
      $res_final['team_mates']=$team_mates;
      $res_final['user_score']=  $part_add_score;//用户当次获得的分数


      Return $res_final;

  }



}
