CKEDITOR.plugins.add( 'summary',
{
	init : function( editor )
	{
	editor.addCommand( 'summary',
	{
		exec : function( editor )
		{
			editor.insertHtml( '--summary--' );
		}
	});
	
	editor.ui.addButton( 'summary',
		{
			//label : editor.lang.link.toolbar,
			label : "insert summary",
			icon: this.path + 'summary.gif',
			command : 'summary'
		} );
	}
} );