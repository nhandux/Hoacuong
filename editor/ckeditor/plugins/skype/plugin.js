CKEDITOR.plugins.add( 'skype',
{
	init: function( editor )
	{
		editor.addCommand( 'skypeDialog', new CKEDITOR.dialogCommand( 'skypeDialog' ) );
 
		editor.ui.addButton( 'Skype',
		{
			label: 'Skype & Yahoo',
			command: 'skypeDialog',
			icon: this.path + 'images/icon.png'
		} );
		var l=this.path;
	 
		var ht='<table class="tb_dnt_yahoo_skype" width="100" border="0" cellspacing="0" cellpadding="0">';
		ht+='<tr><td><div>Yahoo</div></td><td><div>Skype</div></td></tr>';
		ht+='<tr><td><div><input placeholder="Nick Yahoo" name="nick_dnt_yahoo_ck" id="nick_dnt_yahoo_ck" class="cke_dialog_ui_input_text" /></div></td><td><div><input placeholder="Nick Skype" name="nick_dnt_skype_ck" id="nick_dnt_skype_ck" class="cke_dialog_ui_input_text" /></div></td></tr>';
		ht+='<tr>';
		ht+='	<td><div><select onchange="$(\'#view_dnt_yahoo\').html(\'<img src=http://danangtech.vn/yahoo-\'+this.value+\'/\'+$(\'#nick_dnt_yahoo_ck\').val()+\'.dnt >\')" id="dnt_yahoo_ck" name="dnt_yahoo_ck" class="cke_dialog_ui_input_select"><option value="0">Chọn... </option><option value="1">Yahoo 1</option><option value="2">Yahoo 2</option><option value="3">Yahoo 3</option><option value="4">Yahoo 4</option><option value="5">Yahoo 5</option><option value="6">Yahoo 6</option><option value="7">Yahoo 7</option><option value="8">Yahoo 8</option><option value="9">Yahoo 9</option><option value="10">Yahoo 10</option><option value="11">Yahoo 11</option><option value="12">Yahoo 12</option><option value="13">Yahoo 13</option><option value="14">Yahoo 14</option><option value="15">Yahoo 15</option></select></div></td>';
		ht+='	<td><div><select onchange="$(\'#view_dnt_skype\').html(\'<img src=http://danangtech.vn/skype-\'+this.value+\'/\'+$(\'#nick_dnt_skype_ck\').val()+\'.dnt >\')"  id="dnt_skype_ck" name="dnt_skype_ck" class="cke_dialog_ui_input_select"><option value="0">Chọn... </option><option value="1">Skype 1</option> <option value="2">Skype 2</option><option value="3">Skype 3</option><option value="4">Skype 4</option></select></div></td>';
		ht+='</tr>';
		ht+='<tr><td><div id="view_dnt_yahoo"></div></td><td><div id="view_dnt_skype"></div></td></tr>';
		ht+='</table>';

	 
		CKEDITOR.dialog.add( 'skypeDialog', function( editor )
		{
			
			return {
				title : 'Trang thái Skype & Yahoo',
				minWidth : 400,
				minHeight : 100,
				contents :
				[
					{
						id : 'general',
						label : 'Settings',
						elements :
						[
							{
								type : 'html',
								html : 'Bạn chọn các mẫu dưới đây'
							},
							{
								type : 'html',
								html: ht
							}
						]
					}
				],
				onOk : function()
				{
					var dialog = this,
						data = {},
						write = editor.document.createElement( 'span' );
						this.commitContent(data);
						var show;
						var yahoo = parseInt($('#dnt_yahoo_ck').val());
						var yahoo_nick = $('#nick_dnt_yahoo_ck').val();
						var skype = parseInt($('#dnt_skype_ck').val());
						var skype_nick = $('#nick_dnt_skype_ck').val();
						
						if(yahoo!=0){
							if(yahoo_nick==''){ alert('Vui lòng nhập nick yahoo của bạn'); return false;}	
							show+='<a href="ymsgr:sendim?'+yahoo_nick+'" ><img src="http://danangtech.vn/yahoo-'+yahoo+'/'+yahoo_nick+'.dnt" alt=""></a>';
						}
						if(skype!=0){
							if(skype_nick==''){ alert('Vui lòng nhập nick skype của bạn'); return false;}	
							show+='<a href="skype:'+skype_nick+'?call" ><img src="http://danangtech.vn/skype-'+skype+'/'+skype_nick+'.dnt" alt=""></a>';
						}
						write.setHtml(show);
					editor.insertElement(write);
				}
			};
		});
	}
});