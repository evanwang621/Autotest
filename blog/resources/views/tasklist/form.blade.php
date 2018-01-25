<div class="bs-example" data-example-id="striped-table">
{{ csrf_field() }}
    <table class="table table-striped">
		<thead>
			<tr>
			  <th>#</th>
			  <th>BoardID</th>
			  <th>Task</th>
			  <th>Status</th>
			  <th>applicant</th>
			</tr>
		</thead>
		<tbody>
			@foreach($taskStatus as $key=>$value)
				<tr>
				<th scope="row">{{$key+1}}</th>
				<td>{{$value->boardID}}</td>
				<td>{{$value->taskType}}</td>
				<td>{{$value->status}}</td>
				</tr>
			@endforeach
		</tbody>
		<!--tbody>
			@for($i = 1;$i <= $tasknum;$i++)
			{
				<tr>
				<th scope="row">{{$i}}</th>
				<td>{{$taskStatus[$i-1]->boardID}}</td>
				<td>{{$taskStatus[$i-1]->taskType}}</td>
				<td>{{$taskStatus[$i-1]->status}}</td>
				</tr>
			}
			@endfor
		</tbody-->
    </table>
 </div><!-- /example -->