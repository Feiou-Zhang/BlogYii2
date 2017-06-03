var selftype;

function addListeners () {
    var inputs = document.getElementsByTagName('input');
    for (var i = 0, length = inputs.length; i < length; i++) {
        inputs[i].addEventListener('click', function (event) {
            toggleStyle(event.srcElement.defaultValue, event.srcElement.checked);
        });
    }
}

function toggleStyle (style, checked) {
    if (selftype === undefined) {
        return;
    }
    
    var radios = ['default', 'noBack', 'noHigh'],
        key;
    
    if (radios.indexOf(style) > -1) {
        if (style === 'default') {
            selftype.options.backspace = true;
            return;
        }

        selftype.options.backspace = false;

        if (style === 'noBack') {
            selftype.options.backspaceHighlight = true;
        }
        else if (style === 'noHigh') {
            selftype.options.backspaceHighlight = false;
        }
    }
    else if (style !== 'play') {
        switch (style) {
            case 'keepWords':
                key = 'keepWords';
                break;
            case 'newLine':
                key = 'newLine';
                break;
            case 'random':
                key = 'randomize';
                break;
            case 'repeat':
                key = 'repeat';
                break;
        }
        
        selftype.options[key] = checked;
    }
    else {
        checked ? selftype.play() : selftype.pause();
    }
}

window.addEventListener('load', function () {
    addListeners();
    selftype = new SelfType({
        nodes: {
            cursor: document.getElementById('st-cursor'),
            text: document.getElementById('st-text'),
        },
    });
});

window.addEventListener('beforeunload', function () {
    if (selftype) {
        selftype.pause();
    }
});