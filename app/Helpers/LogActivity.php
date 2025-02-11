<?php


namespace App\Helpers;
use Request;
use App\Models\UserAccessTrack as LogActivityModel;


class LogActivity
{


    public static function addToLog($subject,$log_data,$table_name)
    {
        // If log_data is passed as a string (query string), parse it into an array
        if (is_string($log_data)) {
            parse_str($log_data, $get_log);
        } else {
            // Otherwise, we assume it's already an array (direct from request)
            $get_log = $log_data;
        }
		$remove = array("_token"=>'',"_method" => '', "uptoken" => '');
		$get_log = array_diff_key($get_log, $remove);

    	$log = [];
    	$log['subject'] = $subject;
    	$log['log_data'] = json_encode($get_log);
    	$log['url'] = Request::path();
    	$log['table_name'] = $table_name;
    	$log['ip'] = Request::ip();
    	$log['agent'] = "0";//Request::header('user-agent');
    	$log['user_id'] = currentUserId() ? currentUserId() : 0;
    	LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }


}
