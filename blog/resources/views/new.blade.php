<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <!--form method="post" action="{{action('TeststatusController@dataProcess')}}" enctype="multipart/form-data">

	<input name="_method" type="hidden" value="PUT">
		<input name="_token" type="hidden" value="{{ csrf_token() }}">
		<input type="file" name="myfile" id="file">
		<input type="submit" value="保存" name="submit">
	</form-->
	<form method="post" action="{{action('TeststatusController@dataProcess')}}"  enctype="multipart/form-data" >
		<input type="file" name="myfile">
		<button type="submit"> 提交 </button>
	</form>
    <!--?php
    $file=fopen("D:/APPser/1.txt","r");
    ?-->
</body>
</html>