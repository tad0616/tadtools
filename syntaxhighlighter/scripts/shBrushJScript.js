/**
 * SyntaxHighlighter
 * http://alexgorbatchev.com/SyntaxHighlighter
 *
 * SyntaxHighlighter is donationware. If you are using it, please donate.
 * http://alexgorbatchev.com/SyntaxHighlighter/donate.html
 *
 * @version
 * 3.0.83 (July 02 2010)
 * 
 * @copyright
 * Copyright (C) 2004-2010 Alex Gorbatchev.
 *
 * @license
 * Dual licensed under the MIT and GPL licenses.
 */
;(function()
{
	// CommonJS
	typeof(require) != 'undefined' ? SyntaxHighlighter = require('shCore').SyntaxHighlighter : null;

	function Brush()
	{
		var keywords =	'document break case catch continue ' +
						'default delete do else false  ' +
						'for function if in instanceof ' +
						'new null return super switch ' +
						'this throw true try typeof var while with ' +
						'';
						
		var dom 	= 	'getElementById getElementByTagName getElementByClassName ' + 
						'appendChild removeChild replaceChild insertBefore createAttribute createElement createTextNode ' + 
						'getAttribute setAttribute style ' +
						'';
						
		var methods = 	'addEventListener addEvent removeEvent removeEventListener ';
		var properties = 	'ascent azimuth backgroundAttachment backgroundColor backgroundImage backgroundPosition ' +
							'backgroundRepeat background baseline bbox borderCollapse borderColor borderSpacing borderStyle borderTop ' +
							'borderRight borderBottom borderLeft borderTopColor borderRightColor borderBottomColor borderLeftColor ' +
							'borderTopStyle borderRightStyle borderBottomStyle borderLeftStyle borderTopWidth borderRightWidth ' +
							'borderBottomWidth borderLeftWidth borderWidth border bottom capHeight captionSide centerline clear clip color ' +
							'content counterIncrement counterReset cueAfter cueBefore cue cursor definitionSrc descent direction display ' +
							'elevation emptyCells float fontSizeAdjust fontFamily fontSize fontStretch fontStyle fontVariant fontWeight font ' +
							'height left letterSpacing lineHeight listStyleImage listStylePosition listStyleType listStyle ' +
							'marginTop marginRight marginBottom marginLeft margin markerOffset marks mathline maxHeight maxWidth minHeight minWidth orphans ' +
							'outlineColor outlineStyle outlineWidth outline overflow paddingTop paddingRight paddingBottom paddingLeft padding page ' +
							'pageBreakAfter pageBreakBefore pageBreakInside pause pauseAfter pauseBefore pitch pitchRange playDuring position ' +
							'quotes right richness size slope src speakHeader speakNumeral speakPunctuation speak speechRate stemh stemv stress ' +
							'tableLayout textAlign top textDecoration textIndent textShadow textTransform unicodeBidi unicodeRange unitsPerEm ' +
							'verticalAlign visibility voiceFamily volume whiteSpace widows width widths wordSpacing xHeight zIndex';

		var r = SyntaxHighlighter.regexLib;
		
		this.regexList = [
			{ regex: r.multiLineDoubleQuotedString,					css: 'string' },			// double quoted strings
			{ regex: r.multiLineSingleQuotedString,					css: 'string' },			// single quoted strings
			{ regex: r.singleLineCComments,							css: 'comments' },			// one line comments
			{ regex: r.multiLineCComments,							css: 'comments' },			// multiline comments
			{ regex: /\s*#.*/gm,									css: 'preprocessor' },		// preprocessor tags like #region and #endregion
			{ regex: new RegExp(this.getKeywords(dom), 'gm'),		css: 'dom' },				// dom
			{ regex: new RegExp(this.getKeywords(methods), 'gm'),	css: 'methods' },				// methods
			{ regex: new RegExp(this.getKeywords(properties), 'gm'),css: 'prop' },				// properties
			{ regex: new RegExp(this.getKeywords(keywords), 'gm'),	css: 'keyword' }			// keywords
			];
	
		this.forHtmlScript(r.scriptScriptTags);
	};

	Brush.prototype	= new SyntaxHighlighter.Highlighter();
	Brush.aliases	= ['js', 'jscript', 'javascript'];

	SyntaxHighlighter.brushes.JScript = Brush;

	// CommonJS
	typeof(exports) != 'undefined' ? exports.Brush = Brush : null;
})();
