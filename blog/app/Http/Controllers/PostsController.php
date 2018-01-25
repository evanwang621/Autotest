<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use App\newtasks;
use DB;
use Carbon\Carbon; 

class PostsController extends Model
{
	public function create()
	{
		//$usable_board_num = DB::table('boardstatus')->where('status','free')->count();
		//$usable_board = DB::table('boardstatus')->where('status','free')->get();
		//一切只要在线的状态都需要判断
		$usable_board_num = DB::table('boardstatus')->where('status','free')->orWhere('status','busy')->orWhere('status','pause')->orWhere('status','stop')->count();
        $usable_board = DB::table('boardstatus')->where('status','free')->orWhere('status','busy')->orWhere('status','pause')->orWhere('status','stop')->get();
		//判断这些主板状态是否正常(先修正状态)
		for($i = 0;$i < $usable_board_num;$i++)
		{
			$int_time = $usable_board[$i]->receiveTime;//获得测试机发来的时间
			$officialDate = Carbon::now()->timestamp;//获取当前时间戳
			$erro = $officialDate - $int_time;//客户机与服务器之间时间通信的时间差
			if($erro > 5)//5s误差判断，修正主板状态
			{
				$bool = DB::table('boardstatus')->where('macAddr',$usable_board[$i]->macAddr)->update(['status'=>'offline']);//主板掉线
                //$bool = DB::table('newtasks')->where('macAddr',$usable_board[$i]->macAddr)->update(['status'=>'on-going']);//主板掉线后更新为任务派发状态，重新跑
                //$bool = DB::table('newtasks')->where('macAddr',$usable_board[$i]->macAddr)->update(['taskType'=>'FreeBenchMark2']);
			}
		}
		//重新获取状态为空闲的主板
		$usable_board_num = DB::table('boardstatus')->where('status','free')->count();
		$usable_board = DB::table('boardstatus')->where('status','free')->get();
		return view('reboot.master',['usable_board_num'=>$usable_board_num,'usable_board'=>$usable_board]);
	}

	
	public function store()//创建任务  post数据到这里
	{
		
		$post = new newtasks();
		$post->num = request('Rate');
		//$post->circle = request('circle');
		$post->name = request('name');
		$post->testtype = request('testtype');
		$post->macAddr = request('$value->macAddr');


		$boardID_Array = array();//创建数组
		for($i = 0;$i < $post->num;$i++)
		{
			$boardID_Array[$i] = request($i);
		}


		//$boardID_Array = array($post->NO1,$post->NO2,$post->NO3,$post->NO4,$post->NO5,$post->NO6);
		$arrlength = count($boardID_Array);
		
		
		
		#$bool = DB::table("newtasks")->select('taskType','circle')->get();//查找所有
		#$bool = DB::table("newtasks")->first();查找第一行
		#echo $bool->circle;
		#$bool = DB::table("newtasks")->where('id',2)->update(['status'=>50]);//修改
		#echo $bool;
		
		for($id = 0;$id < $arrlength;$id++)//新建任务存入数据库中
		{
			if($boardID_Array[$id])
			{
			    //优化板号对应MAC地址
                $board = DB::table("boardstatus")->where('macAddr',$boardID_Array[$id])->get();
                $boardID = $board[0]->boardID;
				//$bool=DB::table("newtasks")->insert(['taskType'=>request('testtype'),'circle'=>request('circle'),'status'=>'on-going','boardID'=>$boardID_Array[$id]]);
                $bool=DB::table("newtasks")->insert(['taskType'=>request('testtype'),'status'=>'on-going','boardID'=>$boardID,'macAddr'=>$boardID_Array[$id]]);
			}
		}
		
		//从boardstatus中找出在线空闲的主板
		//board_status = DB::table('boardstatus')->where('status','=','free')->get();
		
		//从tasklist中copy

        $task_status = DB::table("newtasks")->where('status','on-going')->orWhere('status','busy')->get();
		$status_online_num = DB::table("newtasks")->where('status','on-going')->orWhere('status','busy')->count(); //显示status为在线的测试项数目

        /*
        $task_status = DB::table("boardstatus")->where('status','free')->orWhere('status','busy')->orWhere('status','pause')->get();
        $status_online_num = DB::table("boardstatus")->where('status','free')->orWhere('status','busy')->orWhere('status','pause')->count(); //显示status为在线的测试项数目
        */
		return view('tasklist.master',['tasknum'=>$status_online_num,'taskStatus'=>$task_status]);
		//return redirect("/test");
		//return view('tasklist.index');
		
		//return $post->num;
	

	}

		
}