<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\CollectionStdClassl;
use App\newtasks;
use DB; 

use Illuminate\Http\Request;
use App\User;
use App\Jobs\SendRemindEmail;

#use config\queued;
use Carbon\Carbon;
use Queue;
use App\Console\Commands\PushMessage;
use App\Jobs\SendReminderEmail;
class TestrecordController extends Model
{
    //此方法获取所有主板号、任务项、日期和log等信息
	public function create()
	{/*
		$task_status=DB::select("select * from newtasks where status = '10'or'50'");
		$status_online_num = DB::table("newtasks")->where('status','10')->count(); //显示status为在线的测试项数目
		return view('taskrecord.master',['tasknum'=>$status_online_num,'taskStatus'=>$task_status]);
	*/

        $board_ID = DB::table("boardstatus")->select('macAddr')->get();//取得mac地址（板号）
        $board_ID_count = DB::table("boardstatus")->select('macAddr')->count();
        return view('taskrecord.master',['board_id'=>$board_ID,'boardnum'=>$board_ID_count]);
	}

	//此方法按板号、任务类型、任务日期查询指定的log文件
	public function findlog(Request $request)
    {

        $id = request('boardid');
        $board = DB::table('boardstatus')->where('macAddr',$id)->get();
        $boardID = '/'.(string)$board[0]->boardID;
        $taskType = request('tasktype');
        $taskname = '/'.$taskType;
        $date = request('date');
        //通过上面的参数定位log文件
        //如果日期为空，展示此任务的所有文件
        $log = DB::table('logpath')->where('macAddr',$id)->where('taskType',$taskType)->get();
        $lognum = $log->count();


        return view('fileopen.master',['log'=>$log,'lognum'=>$lognum]);
        //return $log;
    }
	
	//队列测试
	//此方法将任务推送到队列
	public function sendReminderEmail(Request $request,$id,$time)
	{

		//Queue::later(0, new PushMessage($id,$time));// 60s后推进队列
        Queue::later(0, $bool = new SendReminderEmail($id,$time));

        //派发任务

        $send_task = DB::table('newtasks')->where('status','on-going')->where('macAddr',$id)->get();//板号和状态的交集
        $send_task_count = $send_task->count();
        if($send_task_count)//只有在on-going状态下向测试机派发任务
        {
            //更新主板状态
            $bool = DB::table('newtasks')->where('macAddr',$id)->update(['status'=>'busy']);
           // $bool = DB::table('boardstatus')->where('macAddr',$id)->update(['status'=>'busy']);//更改主板状态为busy
            //返回对应的任务
            return $send_task[0]->taskType;
/*
            $task = DB::table('newtasks')->where('macAddr',$id)->where('status','busy')->get();
            $tasknum = $task->count();
            return $task;
*/
        }



	}

    public function rtmp()
    {
        return view('rtmp');
    }
	
}