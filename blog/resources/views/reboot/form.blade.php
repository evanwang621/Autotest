<form class="form-horizontal" action="{{ action('PostsController@store') }}"  method="post">
{{ csrf_field() }}
	<div class="form-group">
		<label for="testtype" class="col-sm-2 control-label">测试类型</label>
		<div class="col-sm-10">
			<select class="form-control" name="testtype">
			  	<option>reboot</option>
			  	<option>copycompare</option>
			  	<option>passmark</option>
			  	<option>acpi</option>
			  	<option>3D-mark</option>
				<option>FreeBenchMark2</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-2 control-label">
			<label for="boardid">板号</label>
		</div>
		<div class="col-sm-10">
			<!--input type="password" class="form-control" id="exampleInputPassword1"-->
			<!--label class="checkbox-inline">	
			  <input type="checkbox" id="boardid1" name="number1" value="1"> 1
			</label>
			
			<label class="checkbox-inline">
			  <fieldset disabled>
			  <input type="checkbox" id="boardid2" name="number2" value="2"> 2
			  </fieldset>
			</label>
			<label class="checkbox-inline">
			  <input type="checkbox" id="boardid3" name="number3" value="3"> 3
			</label>		
			<label class="checkbox-inline">	
			  <input type="checkbox" id="boardid4" name="number4" value="4"> 4
			</label>
			<label class="checkbox-inline">
			  <input type="checkbox" id="boardid5" name="number5" value="5"> 5
			</label>
			<label class="checkbox-inline">
			  <input type="checkbox" id="boardid6" name="number6" value="6"> 6
			</label-->
			<input type="hidden" name="Rate" id="Rate" value= {{$usable_board_num}}>
			@foreach($usable_board as $key=>$value)
				<label class="checkbox-inline">
				<input type="checkbox" id="{{$key}}" name="{{$key}}" value={{$value->macAddr}}> {{$key+1}}
				</label>
			@endforeach
		</div>
	</div>

	<!--div>设置圈数属性</div-->
	<!--div class="form-group">
		<div class="col-sm-2 control-label">
			<label for="circle">circle</label>
		</div>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="circle" name="circle" placeholder="输入需要跑的圈数">
		</div>
	</div-->
 
 
	<div class="form-group">
		<div class="col-sm-2 control-label">
			<label for="name">Name</label>
		</div>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="name" name="name" placeholder="Jane Doe">
		</div>
	</div>
	  <!--div class="form-group">
		<label for="exampleInputEmail2">Email</label>
		<input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
	  </div>
	  <button type="submit" class="btn btn-default">Send invitation</button  exampleInputFile-->
  
	<!--div class="checkbox">
    <label>
      <input type="checkbox"> Check me out
    </label>
	</div-->
	
	<div class="col-sm-6 control-label">
		<button type="submit" class="btn btn-default">提交</button>
	</div>
</form>