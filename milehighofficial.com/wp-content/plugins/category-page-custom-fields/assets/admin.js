// Admin JS
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.ccf-code-editor').forEach(function (el) {
        CodeMirror.fromTextArea(el, {
            mode: 'application/json',
            theme: 'default',
            lineNumbers: true,
            tabSize: 2,
            indentWithTabs: false,
            lineWrapping: true,
        });
    });
});
