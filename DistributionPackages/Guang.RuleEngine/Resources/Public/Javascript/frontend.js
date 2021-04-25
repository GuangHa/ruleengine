
$(document).ready(function() {
    var ruleHolder = document.getElementById('ruleHolder'),
        dataHolder = document.getElementById('dataHolder'),
        ruleset = document.getElementById('rulesets'),
        state = document.getElementById('status');

    if (typeof window.FileReader === 'undefined') {
        state.className = 'fail';
    } else {
        state.className = 'success';
        state.innerHTML = 'File API & FileReader available';
    }

    ruleHolder.ondragover = function() {
        this.className = 'hover form-control';
        return false;
    };
    dataHolder.ondragover = function() {
        this.className = 'hover form-control';
        return false;
    };
    ruleHolder.ondragend = function() {
        this.className = 'form-control';
        return false;
    };
    dataHolder.ondragend = function() {
        this.className = 'form-control';
        return false;
    };
    ruleHolder.ondrop = function(e) {
        this.className = 'form-control';
        e.preventDefault();

        var file = e.dataTransfer.files[0],
            reader = new FileReader();
        reader.onload = function(event) {
            console.log(event.target);
            ruleHolder.value = event.target.result;
        };
        console.log(file);
        reader.readAsText(file);

        return false;
    };
    dataHolder.ondrop = function(e) {
        this.className = 'form-control';
        e.preventDefault();

        var file = e.dataTransfer.files[0],
            reader = new FileReader();
        reader.onload = function(event) {
            console.log(event.target);
            dataHolder.value = event.target.result;
        };
        console.log(file);
        reader.readAsText(file);

        return false;
    };
    ruleset.onchange = function(e) {
        $.ajax({
            url: '/rules/rule?id='+$(this).val(),
            success: function(result) {
                ruleHolder.value = result;
            }
        });
    }
});
