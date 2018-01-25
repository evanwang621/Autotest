<!--!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>菜鸟教程(runoob.com)</title>
</head>
<body>

<video width="320" height="240" controls autoplay>

    <source src="http://169.254.136.1:8010/source/video/nwn.mp4" type="video/mp4">

</video>

</body>
</html-->


<!DOCTYPE html PUBLIC"-//W3C//DTDXHTML1.0Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"xml:lang="en"lang="en">
<head>
    <meta http-equiv="content-type"content="text/html;charset=utf-8"/>
    <title>live-player</title>
    <style type="text/css"></style>
</head>
<body>
    <script type='text/javascript'src='../../assets/js/jwplayer.js'></script>
        <b>RTMP直播系统</b>
        <div id='mediaspace'>Thistextwillbereplaced</div>
        <script type='text/javascript'>
            varserver=window.location.hostname;
            //mylive对应nginx.conf配置项application的名字
            // live_stream对应AdobeFlashStreamMediaLiveEncoder配置的stream名称
            var live_url='rtmp://'+server+'/live'+'/live_stream';
            jwplayer('mediaspace').setup({
                'flashplayer':'../../assets/js/jwplayer.flash.swf',
                'file':live_url,
                'controlbar':'bottom',
                'width':'760',
                'height':'428',
                //autostart:true,//如果打开此标志，在打开网页时会自动播放直播流
             });
        </script>
</body>
</html>