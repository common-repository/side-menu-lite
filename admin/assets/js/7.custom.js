'use strict';

(function($) {

  const editorStyleSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};

  editorStyleSettings.codemirror = _.extend(
      {},
      editorStyleSettings.codemirror,
      {
        'indentUnit': 2,
        'indentWithTabs': true,
        'inputStyle': 'contenteditable',
        'lineNumbers': true,
        'lineWrapping': true,
        'styleActiveLine': true,
        'continueComments': true,
        'extraKeys': {
          'Ctrl-Space': 'autocomplete',
          'Ctrl-\/': 'toggleComment',
          'Cmd-\/': 'toggleComment',
          'Alt-F': 'findPersistent',
          'Ctrl-F': 'findPersistent',
          'Cmd-F': 'findPersistent',
        },
        'direction': 'ltr',
        'gutters': ['CodeMirror-lint-markers'],
        'lint': true,
        'autoCloseBrackets': true,
        'autoCloseTags': true,
        'matchTags': {
          'bothTags': true,
        },
        'tabSize': 2,
        'mode': 'css',
      },
  );

  const css = $('[data-field="style"]');

  var editorStyle = wp.codeEditor.initialize(css, editorStyleSettings);

  $('.menu-class').on('click', function() {
    const val = $(this).data('value');

    const editor = document.querySelector('#wrapper-style .CodeMirror').CodeMirror;
    const doc = editor.getDoc();
    const cursor = doc.getCursor();
    doc.replaceRange(val, cursor);
    editor.focus();
    editor.setCursor(editor.lineCount());

  });

})(jQuery);