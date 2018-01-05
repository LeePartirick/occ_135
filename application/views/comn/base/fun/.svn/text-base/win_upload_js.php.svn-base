<script>

//载入上传控件
var stream<?=$op_id?>;
var file_num<?=$op_id?>=0;
//初始化
$(document).ready(function(){

	fun_load_stream_upload_<?=$op_id?>()
});

function fun_load_stream_upload_<?=$op_id?>()
{
	var config = {
			enabled: true, /** 是否启用文件选择，默认是true */
			customered: true,/** 是否自定义UI */	
			multipleFiles: <?=$conf['multipleFiles']?>, /** 是否允许同时选择多个文件，默认是false */	
			autoRemoveCompleted: false, /** 是否自动移除已经上传完毕的文件，非自定义UI有效(customered:false)，默认是false */
			autoUploading: <?=$conf['autoUploading']?>, /** 当选择完文件是否自动上传，默认是true */
			fileFieldName: "FileData", /** 相当于指定<input type="file" name="FileData">，默认是FileData */
			maxSize: <?=$conf['maxSize']?>, /** 当_t.bStreaming = false 时（也就是Flash上传时），2G就是最大的文件上传大小！所以一般需要 */
			simLimit: <?=$conf['simLimit']?>, /** 允许同时选择文件上传的个数（包含已经上传过的） */
			browseFileId : "btn_upload_<?=$op_id?>", /** 文件选择的Dom Id，如果不指定，默认是i_select_files */
			dragAndDropArea: "<?=$conf['dragAndDropArea']?>",
			dragAndDropTips:'&nbsp;',
			tokenURL : "<?=$url?>/action/tk", /** 根据文件名、大小等信息获取Token的URI（用于生成断点续传、跨域的令牌） */
			frmUploadURL : "<?=$url?>/action/fd;", /** Flash上传的URI */
			uploadURL : "<?=$url?>/action/up", /** HTML5上传的URI */
			postVarsPerFile:{},
			extFilters:[<?=$conf['extFilters']?>],
			onSelect: function(files) {
				<?=$conf['onSelect']?>
			},
			onMaxSizeExceed: function(file) {
				$.messager.show({
						title:'警告',
						msg:'文件大小不可超出'+$.filesize(<?=$conf['maxSize']?>)+'!',
						timeout:1500,
						showType:'show',
				    	border:'thin',
		                style:{
		                    right:'',
		                    bottom:'',
		                }
					});
			},
			onRepeatedFile: function(file) {
				$.messager.show({
					title:'通知',
					msg:'文件'+file.name+'('+$.filesize(file.size)+')已存在于队列中！',
					timeout:2000,
					showType:'show',
			    	border:'thin',
	                style:{
	                    right:'',
	                    bottom:'',
	                }
				});
			},
			onFileCountExceed : function(selected, limit) {
				$.messager.show({
					title:'警告',
					msg:'最多上传'+limit+'个文件,已选择'+selected+'个！',
					timeout:2000,
					showType:'show',
			    	border:'thin',
	                style:{
	                    right:'',
	                    bottom:'',
	                }
				});
			},
			onExtNameMismatch: function(info) {
				$.messager.show({
						title:'警告',
						msg:'<?=$conf['onExtNameMismatch']?>',
						timeout:2000,
						showType:'show',
				    	border:'thin',
		                style:{
		                    right:'',
		                    bottom:'',
		                }
					});
			},
			onAddTask: function(file) {
				file_num<?=$op_id?>++;
				<?=$conf['onAddTask']?>
			},
			onUploadProgress: function(file) {
				<?=$conf['onUploadProgress']?>
			},
			onStop: function() {
			},
			onCancel: function(file) {
				file_num<?=$op_id?>--;
				<?=$conf['onCancel']?>
			},
			onCancelAll: function(numbers) {
				file_num<?=$op_id?> = 0;
			},
			onComplete: function(file) {
				file_num<?=$op_id?>--;
				<?=$conf['onComplete']?>

				if(file.msg)
				{
					var json = JSON.parse(file.msg);
					json = json.json;

					if(json)
					{
						if(json.msg)
						{
							var msg = base64_decode(json.msg);
							$.messager.show({
								title:'通知',
								msg: msg,
								timeout:4500,
								showType:'show',
								border:'thin',
								style:{
									right:'',
									bottom:'',
								}
							});
						}
					}
				}
			},
			onQueueComplete: function(msg) {
				file_num<?=$op_id?> = 0;
			},
			onUploadError: function(status, msg) {
			}
		};
		stream<?=$op_id?>= new Stream(config);
}

function fun_disable_<?=$op_id?>()
{
	stream<?=$op_id?>.config.simLimit='0';
}

function get_file_num<?=$op_id?>()
{
	return file_num<?=$op_id?>;
}

function cancel_file<?=$op_id?>(file_id)
{
	stream<?=$op_id?>.cancelOne(file_id);
}

</script>
	 
