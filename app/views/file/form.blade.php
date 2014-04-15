@extends('layouts.master') 
@section('title')  上传文件@stop
{{ HTML::script('static/js/file/swfupload/swfupload.js'); }}
{{ HTML::script('static/js/file/jquery.swfupload.js'); }}
{{ HTML::style('static/css/file/swfupload.css'); }}


@section('content')
	<h3>&raquo; Multiple File Upload With Progress Bar</h3>
	
	<div id="swfupload-control">
		<p>Upload upto 5 image files(jpg, png, gif), each having maximum size of 1MB</p>
		<input type="button" id="button" />
		<p id="queuestatus" ></p>
		<ol id="log"></ol>
	</div>
	<<script type="text/javascript">
		$(function(){
			$('#swfupload-control').swfupload({
				upload_url: "upload-file.php",
				file_post_name: 'uploadfile',
				file_size_limit : "1024",
				file_types : "*.jpg;*.png;*.gif",
				file_types_description : "Image files",
				file_upload_limit : 5,
				flash_url : "js/swfupload/swfupload.swf",
				button_image_url : 'js/swfupload/wdp_buttons_upload_114x29.png',
				button_width : 114,
				button_height : 29,
				button_placeholder : $('#button')[0],
				debug: false
			})
				.bind('fileQueued', function(event, file){
					var listitem='<li id="'+file.id+'" >'+
						'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
						'<div class="progressbar" ><div class="progress" ></div></div>'+
						'<p class="status" >Pending</p>'+
						'<span class="cancel" >&nbsp;</span>'+
						'</li>';
					$('#log').append(listitem);
					$('li#'+file.id+' .cancel').bind('click', function(){
						var swfu = $.swfupload.getInstance('#swfupload-control');
						swfu.cancelUpload(file.id);
						$('li#'+file.id).slideUp('fast');
					});
					// start the upload since it's queued
					$(this).swfupload('startUpload');
				})
				.bind('fileQueueError', function(event, file, errorCode, message){
					alert('Size of the file '+file.name+' is greater than limit');
				})
				.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
					$('#queuestatus').text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
				})
				.bind('uploadStart', function(event, file){
					$('#log li#'+file.id).find('p.status').text('Uploading...');
					$('#log li#'+file.id).find('span.progressvalue').text('0%');
					$('#log li#'+file.id).find('span.cancel').hide();
				})
				.bind('uploadProgress', function(event, file, bytesLoaded){
					//Show Progress
					var percentage=Math.round((bytesLoaded/file.size)*100);
					$('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
					$('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
				})
				.bind('uploadSuccess', function(event, file, serverData){
					var item=$('#log li#'+file.id);
					item.find('div.progress').css('width', '100%');
					item.find('span.progressvalue').text('100%');
					var pathtofile='<a href="uploads/'+file.name+'" target="_blank" >view &raquo;</a>';
					item.addClass('success').find('p.status').html('Done!!! | '+pathtofile);
				})
				.bind('uploadComplete', function(event, file){
					// upload has completed, try the next one in the queue
					$(this).swfupload('startUpload');
				})
			
		});	
	</script>

@stop