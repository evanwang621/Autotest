<form class="form-horizontal" action="{{ action('TestrecordController@findlog')}}"  method="post">
<div class="bs-example" data-example-id="striped-table">
{{ csrf_field() }}
    <!--table class="table table-striped"-->
		<!--thead>
			<tr>
			  <th>#</th>
			  <th>BoardID</th>
			  <th>Task</th>
			  <th>Status</th>
			  <th>applicant</th>
			</tr>
		</thead-->
		<!--tbody>
		</tbody-->
		<tbody>
		<div class="form-group">
			<!--div>获取记录中的主板</div-->
			<label for="boardid" class="col-sm-1 control-label">主板号</label>
			<div class="col-sm-2">
				<select class="form-control" name="boardid">
					@for($i = 0;$i < $boardnum;$i++)
						<option>{{$board_id[$i]->macAddr}}</option>
					@endfor
				</select>
			</div>
			<!--div>所有可查的任务</div-->
			<label for="tasktype" class="col-sm-1 control-label">测试类型</label>
			<div class="col-sm-2">
				<select class="form-control" name="tasktype">
					<option>reboot</option>
					<option>copycompare</option>
					<option>passmark</option>
					<option>acpi</option>
					<option>3D-mark</option>
                    <option>FreeBenchMark2</option>
				</select>
			</div>
			<!--div>log存储的时间</div-->
			<!--div class="col-sm-1 control-label">
				<label for="date">测试日期</label>
			</div>
			<div class="col-sm-2">
				<input type="text" class="form-control" id="date" name="date" placeholder="20171219">
			</div-->
			<div class="col-sm-1 control-label">
				<button type="submit">查询</button>
			</div>
		</div>

    <!--/table-->
 </div><!-- /example -->
</form>