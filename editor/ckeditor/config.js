CKEDITOR.editorConfig = function( config ) 
{
	config.skin = 'bootstrapck';
    config.language = 'vi';
	config.allowedContent = true;
	config.entities = false;
	config.extraPlugins = 'video,lineheight,skype';
	config.youtube_width = '640';
	config.youtube_height = '480';
	config.youtube_related = false;
	config.youtube_older = true;
	config.youtube_privacy = false;
	config.youtube_autoplay = false;
	config.codeSnippet_theme = 'github';
	// Default setting.
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	    { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
	    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
	    { name: 'forms' },
	    { name: 'links' },
	    { name: 'insert' },
		{ name: 'others'},
	    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	    { name: 'colors' },
	    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
	    { name: 'styles' },
		{ name: 'tools' }
	];  
	config.filebrowserBrowseUrl = '/editor/elFinder/elfinder.html';
	config.filebrowserBrowseUrl = '/editor/ckfinder/ckfinder.html'; 
	config.filebrowserImageBrowseUrl = '/editor/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = '/editor/ckfinder/ckfinder.html?type=Flash'; 
	config.filebrowserUploadUrl = '/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'; 
	config.filebrowserImageUploadUrl = '/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'; 
	config.filebrowserFlashUploadUrl = '/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

};