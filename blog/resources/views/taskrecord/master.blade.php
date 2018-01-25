<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta name="description" content="My world">
    <meta name="author" content="MacMa">
    <link rel="icon" href="favicon.ico">

    <title>Model</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
	
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ asset('css/reboot.css') }}" >

	<!--script src = "C:/Users/EvanW/Downloads/bootstrap-3.3.7/js/tests/vendor/jquery.min.js"></script-->
	<!--script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"-->
    
  </head>

  <body>

    @include('public.header')
	<div class="container-fluid">
      <div class="row">
		@include('taskrecord.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			@include('taskrecord.form')	
		</div>
	  </div>
	</div>
		  
		  


          <!--图片插入-->
          <!--div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="eg_chinarose.jpg" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="eg_chinarose.jpg" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="eg_chinarose.jpg" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="eg_chinarose.jpg" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
          </div-->
		
		

    <!-- Bootstrap core JavaScript
    ================================================== -->href="{{ asset('model/model.css') }}"
    <script>window.jQuery || document.write('<script src="{{ asset('model/jquery.js') }}"><\/script>')</script>
	<script src="{{ asset('model/dropdown.js') }}"></script>
    
  </body>
</html>