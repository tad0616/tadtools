/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

/**
 * @fileOverview Rich code snippets for CKEditor.
 */

'use strict';

(function () {
  // Create a new plugin which registers a custom code highlighter
  // based on Prism.js in order to replace the one that comes
  // with the Code Snippet plugin.
  CKEDITOR.plugins.add('prism', {
    requires: 'codesnippet',

    init: function (editor) {
      var path = this.path;

      // Loading the prism.js style file.
      // Idea taken from codesnippet/plugin.js code.
      // Method is available only if wysiwygarea exists and
      // CKEditor is at least version 4.4.
      if (editor.addContentsCss) {
        editor.addContentsCss(path + 'lib/prism/prism_patched.min.css');
      }

      // Create a new instance of the highlighter.
      var prismHighlighter = new CKEDITOR.plugins.codesnippet.highlighter({
        init: function (ready) {
          // Load the Prism.js library asynchronously.
          CKEDITOR.scriptLoader.load(path + 'lib/prism/prism_patched.min.js', function () {
            // Notify the handler that the library has been loaded.
            ready();
          });
        },

        // Specify the supported languages.
					languages: {
					  markup: 'Markup',
					  css: 'CSS',
					  // clike: 'C-like',
					  javascript: 'JavaScript',
					  // abap: 'ABAP',
					  // actionscript: 'ActionScript',
					  // ada: 'Ada',
					  // apacheconf: 'ApacheConfiguration',
					  // apl: 'APL',
					  // applescript: 'AppleScript',
					  // arduino: 'Arduino',
					  // arff: 'ARFF',
					  // asciidoc: 'AsciiDoc',
					  // asm6502: '6502Assembly',
					  // aspnet: 'ASP.NET(C#)',
					  // autohotkey: 'AutoHotkey',
					  // autoit: 'AutoIt',
					  bash: 'Bash',
					  // basic: 'BASIC',
					  // batch: 'Batch',
					  // bison: 'Bison',
					  // brainfuck: 'Brainfuck',
					  // bro: 'Bro',
					  c: 'C',
					  csharp: 'C#',
					  cpp: 'C++',
					  // coffeescript: 'CoffeeScript',
					  // clojure: 'Clojure',
					  // crystal: 'Crystal',
					  // csp: 'Content-Security-Policy',
					  // 'css-extras': 'CSSExtras',
					  // d: 'D',
					  dart: 'Dart',
					  // diff: 'Diff',
					  // django: 'Django/Jinja2',
					  // docker: 'Docker',
					  // eiffel: 'Eiffel',
					  // elixir: 'Elixir',
					  // elm: 'Elm',
					  // erb: 'ERB',
					  // erlang: 'Erlang',
					  // fsharp: 'F#',
					  // flow: 'Flow',
					  // fortran: 'Fortran',
					  // gedcom: 'GEDCOM',
					  // gherkin: 'Gherkin',
					  // git: 'Git',
					  // glsl: 'GLSL',
					  go: 'Go',
					  // graphql: 'GraphQL',
					  // groovy: 'Groovy',
					  // haml: 'Haml',
					  // handlebars: 'Handlebars',
					  // haskell: 'Haskell',
					  // haxe: 'Haxe',
					  // http: 'HTTP',
					  // hpkp: 'HTTPPublic-Key-Pins',
					  // hsts: 'HTTPStrict-Transport-Security',
					  // ichigojam: 'IchigoJam',
					  // icon: 'Icon',
					  // inform7: 'Inform7',
					  ini: 'Ini',
					  // io: 'Io',
					  // j: 'J',
					  java: 'Java',
					  // jolie: 'Jolie',
					  // json: 'JSON',
					  // julia: 'Julia',
					  // keyman: 'Keyman',
					  // kotlin: 'Kotlin',
					  // latex: 'LaTeX',
					  // less: 'Less',
					  // liquid: 'Liquid',
					  // lisp: 'Lisp',
					  // livescript: 'LiveScript',
					  // lolcode: 'LOLCODE',
					  // lua: 'Lua',
					  // makefile: 'Makefile',
					  markdown: 'Markdown',
					  // 'markup-templating': 'Markuptemplating',
					  matlab: 'MATLAB',
					  // mel: 'MEL',
					  // mizar: 'Mizar',
					  // monkey: 'Monkey',
					  // n4js: 'N4JS',
					  // nasm: 'NASM',
					  // nginx: 'nginx',
					  // nim: 'Nim',
					  // nix: 'Nix',
					  // nsis: 'NSIS',
					  // objectivec: 'Objective-C',
					  // ocaml: 'OCaml',
					  // opencl: 'OpenCL',
					  // oz: 'Oz',
					  // parigp: 'PARI/GP',
					  // parser: 'Parser',
					  // pascal: 'Pascal',
					  perl: 'Perl',
					  php: 'PHP',
					  // 'php-extras': 'PHPExtras',
					  // plsql: 'PL/SQL',
					  // powershell: 'PowerShell',
					  // processing: 'Processing',
					  // prolog: 'Prolog',
					  // properties: '.properties',
					  // protobuf: 'ProtocolBuffers',
					  // pug: 'Pug',
					  // puppet: 'Puppet',
					  // pure: 'Pure',
					  python: 'Python',
					  // q: 'Q(kdb+database)',
					  // qore: 'Qore',
					  r: 'R',
					  jsx: 'ReactJSX',
					  tsx: 'ReactTSX',
					  // renpy: 'Ren\'py',
					  // reason: 'Reason',
					  // rest: 'reST(reStructuredText)',
					  // rip: 'Rip',
					  // roboconf: 'Roboconf',
					  ruby: 'Ruby',
					  // rust: 'Rust',
					  sas: 'SAS',
					  sass: 'Sass(Sass)',
					  scss: 'Sass(Scss)',
					  // scala: 'Scala',
					  // scheme: 'Scheme',
					  // smalltalk: 'Smalltalk',
					  smarty: 'Smarty',
					  sql: 'SQL',
					  // soy: 'Soy(ClosureTemplate)',
					  // stylus: 'Stylus',
					  swift: 'Swift',
					  // tap: 'TAP',
					  // tcl: 'Tcl',
					  textile: 'Textile',
					  // tt2: 'TemplateToolkit2',
					  // twig: 'Twig',
					  // typescript: 'TypeScript',
					  vbnet: 'VB.Net',
					  // velocity: 'Velocity',
					  // verilog: 'Verilog',
					  // vhdl: 'VHDL',
					  // vim: 'vim',
					  // 'visual-basic': 'VisualBasic',
					  // wasm: 'WebAssembly',
					  // wiki: 'Wikimarkup',
					  // xeora: 'Xeora',
					  // xojo: 'Xojo(REALbasic)',
					  // xquery: 'XQuery',
					  yaml: 'YAML'
					},

        highlighter: function (code, language, callback) {
          // _self.Prism is a global namespace/object created by Prism.js.
          var _prism = _self.Prism;

          // Let the Prism.js highlight the code.
          var highlightedCode = _prism.highlight(code, _prism.languages[language], language);

          // The clever idea below is taken from the 'Line Numbers' plugin
          // of Prism. Basically, we want to count the number of newlines (\n)
          // in the highlighted code, then create the same number
          // of SPAN elements, append them to the highlighted code
          // and finally number/label them using prism.css.
          var match = highlightedCode.match(/\n(?!$)/g);
          var linesNum = match ? match.length + 1 : 1;

          var lines = new Array(linesNum + 1);
          lines = lines.join('<span></span>');

          // Create the SPAN root/wrapper, insert its child SPAN lines,
          // then append them to the highlighted code.
          var lineNumbersWrapper = '<span class="line-numbers-rows">';
          lineNumbersWrapper += lines;
          lineNumbersWrapper += '</span>';
          highlightedCode += lineNumbersWrapper;

          // Return highlighted code.
          callback(highlightedCode);
        }
      });

      // From now on, prismHighlighter will be used as a Code Snippet
      // highlighter, overwriting the default engine.
      editor.plugins.codesnippet.setHighlighter(prismHighlighter);
    }
  });
})();
