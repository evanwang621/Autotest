<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PushMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Request $request,$id,$time)
    {
       /*
		static $i=1;
		$n=strval($i);
		
		$file = 'D:/APPser/AppServ/www/laravel/test'.$n.'.txt';//字符串拼接
		file_put_contents($file,$i++);
		*/

		$int_time = (int)$time;
		$find_board = DB::table('boardstatus')->where('macAddr',$id)->get();//有没有记录过这个主板
		$find_board_num = $find_board->count();
		$board_status = DB::table('boardstatus')->where('macAddr',$id)->where(function($query){	//两个属性的交集
			$query->where('status','free')->orWhere('status','on-going');						//两种状态的并集
		})->get();																				//macAddr&(free||on-going)
		$n = $board_status->count();

		if($find_board_num == 0)//记录中没有这块主板
		{
			if($n == 0)//主板不在线  不在线：0   空闲：1  工作：2
			{
				//return $id;//测试专用
				$bool=DB::table("boardstatus")->insert(['macAddr'=>$id,'status'=>'free','receiveTime'=>$int_time]);//设置主板在free状态
				return 1;
			}else
				return $board_status;
			
		}
		else//记录中有这块主板，更新主板状态
		{
			$bool=DB::table('boardstatus')->where('macAddr',$id)->update(['status'=>'free']);
			$bool=DB::table('boardstatus')->where('macAddr',$id)->update(['receiveTime'=>$int_time]);
			return $board_status;
		}

    }
}
