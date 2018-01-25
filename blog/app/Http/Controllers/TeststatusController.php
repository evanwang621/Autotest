<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\CollectionStdClassl;
use Illuminate\Support\Facades\Storage;
use App\newtasks;
use DB; 
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;


class TeststatusController extends Model
{
	public function create()
	{
	    /*
		$task_status=DB::select("select * from newtasks where status = '10'or'50'");//使用时转成free和run
		$status_online_num = DB::table("newtasks")->where('status','10')->count(); //显示status为在线的测试项数目
		return view('tasklist.master',['tasknum'=>$status_online_num,'taskStatus'=>$task_status]);
	    */
        $task_status = DB::table("newtasks")->where('status','on-going')->orWhere('status','busy')->get();
        $status_online_num = DB::table("newtasks")->where('status','on-going')->orWhere('status','busy')->count(); //显示status为在线的测试项数目
        return view('tasklist.master',['tasknum'=>$status_online_num,'taskStatus'=>$task_status]);
	}
	//持续更新主板状态和信息
	public function updatefreestatus(Request $request,$id,$time)
	{
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

	public function about(Request $request,$id,$time)//代码测试使用函数
	{
		
		//return view('about');
		#SELECT * from runoob_tbl WHERE BINARY runoob_author='runoob.com';
		//$bool=DB::table("newtasks")->insert(['taskType'=>'1','circle'=>'1','status'=>10,'boardID'=>'1']);
		/*
		$task_status=DB::select("select * from newtasks where status = '10'or'50'");
		$status_online_num = DB::table("newtasks")->where('status','10')->count(); //显示status为在线的测试项数目
		*/
		
		//$bool=DB::table("newtasks")->where('vip_ID',6)->update(['vip_fenshu'=>500]); 
		
		//同步时间
		$int_time = (int)$time;
		//$officialDate = Carbon::now();//获取当前系统时间(上海时间)
		$officialDate = Carbon::now()->timestamp;//获取当前时间戳
/*		$erro = $officialDate - $int_time;//客户机与服务器之间时间通信的时间差
		//$bool=DB::table('boardstatus')->where('macAddr',$id)->update(['status'=>'offline']);
		if($erro>2)
		{
			$bool=DB::table('boardstatus')->where('macAddr',$id)->update(['status'=>'offline']);
		}
		
		return $erro;
*/
		

		
		
		//判断主板在不在线（不在线创建）
		//$board_status = DB::select("select macAddr = $id from boardstatus where status = 'free'or'on-going'");//判断主板是否在线(在线的板号是唯一的)
		//$board_status = DB::select("select status = 'free'or'on-going' from boardstatus where macAddr = $id");
		//$board_status = DB::table('boardstatus')->where('macAddr',$id)->where('status','free')->where('status','on-going')->get();
		//$board_status = DB::table('boardstatus')->where('macAddr',$id)->where('status','free')->get();



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
		{/*
			$bool=DB::table('boardstatus')->where('macAddr',$id)->update(['status'=>'free']);
			$bool=DB::table('boardstatus')->where('macAddr',$id)->update(['receiveTime'=>$int_time]);
			return $board_status;
		*/
            $task = DB::table('newtasks')->where('macAddr',$this->id)->where('status','busy')->get();
            $tasknum = $task->count();
            if($tasknum) {//任务已派发，更新主板状态为busy
                $bool = DB::table('boardstatus')->where('macAddr', $this->id)->update(['status' => 'busy']);
            }
            else {//任务没派发，更新主板状态为free
                $bool = DB::table('boardstatus')->where('macAddr', $this->id)->update(['status' => 'free']);
            }
            $bool = DB::table('boardstatus')->where('macAddr',$this->id)->update(['receiveTime'=>$int_time]);
/*
            $send_task = DB::table('newtasks')->where('status','on-going')->where('macAddr',$id)->get();//板号和状态的交集
            $send_task_count = $send_task->count();
            if($send_task_count)//只有在on-going状态下向测试机派发任务
            {
                //更新主板状态
                $bool = DB::table('newtasks')->where('macAddr', $id)->update(['status' => 'busy']);
                //$bool = DB::table('boardstatus')->where('macAddr', $id)->update(['status' => 'busy']);//更改主板状态为busy
                //返回对应的任务
                return $send_task[0]->taskType;
            }
*/
		}


		
		//主板状态更新
		
		
		
		
		#print_r($task_status);
		/*
		foreach ($task_status as $value)//输出任务结果
		{
			print_r($value);
			echo $status_online_num;
			echo "<br>";
			#$boardID = $value->boardID;
			#$testtype = $value->taskType;
			#$status = $value->status;
			#$applicant
		}
		*/
		
		
		//return $task_status;//返回任务个数和具体信息
		//$name = $id->input('name');
		
		
		
		//return view('tasklist.master');//返回任务个数和具体信息
		
		/*
		$status_online = DB::table("newtasks")->where('status','=','10')->get(); //显示status为在线的测试项 
		$status_online_num = DB::table("newtasks")->where('status','10')->count(); //显示status为在线的测试项数目
		*/
		#$status_offline = DB::table("newtasks")->where('status','offline')->get(); //显示status为的测试项
		#$status_offline = DB::table("newtasks")->where('status','offline')->count();
		#$array = object_array(status_online);
		#echo $status_online->taskType;

	}


    public function task(Request $request)
    {
            $bool = DB::table('boardstatus')->where('macAddr','c8:5b:76:f9:41:f6')->get();
            return $bool[0]->boardID;

    }
    //post方式接收文件
    public function dataProcess(Request $request)
    {
/*
        $file = $request->file('myfile');
            if ($file->isValid()) {
                $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
                $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
                $path = $file -> move(base_path().'/storage/app/uploads/1',$newName);
                $filepath = 'D:/APPser/AppServ/www/laravel/blog/storage/app/uploads/1'.$newName;
                return $filepath;
        }
*/

        if($request->isMethod('post'))
        {
            //$task = request('name');
            /*
            $task = '/'.'reboot';
            $id = '/'.'1';
            */

            $id = $request->Mac;
            $board = DB::table('boardstatus')->where('macAddr',$id)->get();
            $task = $request->App;
            $id = '/'.(string)$board[0]->boardID;
            $task = '/'.(string)$task;

            /*
            $sda = 2;
            $id = '/'.(string)$sda;
            */
            $file = $request->file('myfile');

            if($file->isValid())
            {

                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名

                $ext = $file->getClientOriginalExtension();     // 扩展名
                //$realPath = $file->getRealPath();   //临时文件的绝对路径
                //$type = $file->getClientMimeType();     // image/jpeg

                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                //$filename = $originalName;

                //设置存放路径
                $path = $file -> move(base_path().'/storage/app/uploads/'.$id.$task,$originalName);//分类路径
                $filepath = $task.$filename;//数据表中存的信息

                //$bool = DB::table("logpath")->insert(['taskType' => $task, 'fileName' => $filename]);
                //$bool = DB::table("newtasks")->where('macAddr', $id)->update(['status' => 'finished']);//更新任务状态
                // 使用我们新建的uploads本地存储空间（目录）
                //这里的uploads是配置文件的名称
                //$bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                //var_dump($bool);

                return $originalName;
                //return $filepath;
            }
        }

    }

    //文件存储路径设置
    //更改主板测试状态
    public function logPosition(Request $request)
    {
        if($request->isMethod('post'))
        {
            $file = $request->file('myfile');
            $id = $request->Mac;
            $board = DB::table('boardstatus')->where('macAddr',$id)->get();
            $task = $request->App;
            $boardid = '/'.(string)$board[0]->boardID;
            $taskname = '/'.(string)$task;
            //       return $boardid;

            if ($file->isValid())
            {
                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                //设置存放路径
                $path = $file->move(base_path().'/storage/app/uploads/'.$boardid.$taskname,$filename);//分类路径
                $filepath = $task . $filename;//数据表中存的信息
                $bool = DB::table("logpath")->insert(['taskType' => $task, 'fileName'=>$filename]);
                $bool = DB::table("newtasks")->where('macAddr', $id)->update(['status'=>'finished']);//更新任务状态
                return $originalName;
            }
        }

    }

    //文件读取
    //前端通过post方式把文件名等信息传过来
    public function fileRead1()
    {
        $file_path = "D:/APPser/1_a_ds2-1.txt";//路径不能用中文
        if(file_exists($file_path)){
            $fp = fopen($file_path,"r");
            $str = fread($fp,filesize($file_path));//指定读取大小，这里把整个文件内容读取出来
            echo $str = str_replace("\r\n","<br />",$str);
        }
    }

    public function fileRead(Request $request,$macAddr,$taskType,$fileName)
    {
        $board = DB::table("boardstatus")->where('macAddr',$macAddr)->get();
        $boardid = '/'.(string)$board[0]->boardID;
        $taskname = '/'.(string)$taskType;
        $filename = '/'.(string)$fileName;
        $file_path = 'D:/APPser/AppServ/www/laravel/blog/storage/app/uploads'.$boardid.$taskname.$filename;//路径不能用中文

        if(file_exists($file_path)){
            $fp = fopen($file_path,"r");
            $str = fread($fp,filesize($file_path));//指定读取大小，这里把整个文件内容读取出来
            echo $str = str_replace("\r\n","<br />",$str);
        }


    }

}