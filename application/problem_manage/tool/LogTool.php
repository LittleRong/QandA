<?php namespace app\problem_manage\tool;
use think\Log;
class LogTool {
    public static function record($ct)
    {
        Log::init([ 'type' => 'File', 'path' => APP_PATH . 'logs/problem_manage/' ]);
        Log::log($ct);
    } 
    static function unique_rand($min, $max, $num)
    {
        $count = 0;
        $return = array();
        while ($count < $num) {
            $return[] = mt_rand($min, $max);
            $return = array_flip(array_flip($return));
            $count = count($return);
        } 
        shuffle($return);
        return $return;
    } 
    static function object2array(&$object)
    {
        $object = json_decode(json_encode($object), true);
        return $object;
    } 
} 
