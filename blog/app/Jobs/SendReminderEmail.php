<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use DB;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id;
    private $time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id,$time)
    {
        //
        $this->id = $id;
        $this->time = $time;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        /*
      static $i=1;
      $n=strval($i);

      $file = 'D:/APPser/AppServ/www/laravel/test'.$n.'.txt';//字符串拼接
      file_put_contents($file,$i++);
      */

        $int_time = (int)$this->time;
        $find_board = DB::table('boardstatus')->where('macAddr',$this->id)->get();//有没有记录过这个主板
        $find_board_num = $find_board->count();
        $board_status = DB::table('boardstatus')->where('macAddr',$this->id)->where(function($query){	//两个属性的交集
            $query->where('status','free')->orWhere('status','on-going');						//两种状态的并集
        })->get();																				//macAddr&(free||on-going)
        $n = $board_status->count();

       if($find_board_num == 0)//记录中没有这块主板
        {
            if($n == 0)//主板不在线  不在线：0   空闲：1  工作：2
            {
                //return $id;//测试专用
                $bool=DB::table("boardstatus")->insert(['macAddr'=>$this->id,'status'=>'free','receiveTime'=>$int_time]);//设置主板在free状态
                //return 1;
            }
            //else
                //return $board_status;
            //   return 1;

        }
       else//记录中有这块主板，更新主板状态
        {
            //$bool = DB::table('boardstatus')->where('macAddr', $this->id)->update(['status' => 'free']);

            //查看任务是否派发（busy为已经派发，on-going为准备派发，finished为任务执行完成）
            $task = DB::table('newtasks')->where('macAddr',$this->id)->where('status','busy')->get();
            $tasknum = $task->count();
            if($tasknum) {//任务已派发，更新主板状态为busy
                $bool = DB::table('boardstatus')->where('macAddr', $this->id)->update(['status' => 'busy']);
            }
            else {//任务没派发，更新主板状态为free
                $bool = DB::table('boardstatus')->where('macAddr', $this->id)->update(['status' => 'free']);
            }

            $bool = DB::table('boardstatus')->where('macAddr',$this->id)->update(['receiveTime'=>$int_time]);
            //return $board_status;
            //return 1;


        }

    }


}
