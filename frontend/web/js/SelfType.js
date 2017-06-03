'use strict';

class SelfType {
  constructor (options) {
    options = options || {};
    
    this.setNodeReferences(options);
    // Sets up the config.
    this.loadOptions(options);
    
    // Set the initial colour.
    this.options.currentColor = this.options.color;
    
    this.playAnimation();
    return this.returnPublicMethods();
  }
  
  adjustCount () {
    this.count = (this.options.repeat) ? 1 : (this.count + 1);
  }
  
  // Have we waited for long enough to move on with the animation?
  canPerformNextStep () {
    var canPerform;
    
    // There is no active delay.
    if (!this.timestamp) {
      return true;
    }
    
    canPerform = this.timestamp + this.timeout <= Date.now();
    
    if (canPerform) {
      this.resetTimeout();
      // Remove the delay.
      this.timestamp = undefined;
    }
    
    return canPerform;
  }
  
  canPrintNextWord () {
    if (this.options.repeat) {
      return true;
    }
    // If we cannot repeat words, check if
    // we have not run out of words yet.
    return this.count < this.options.words.length;
  }
  
  clearTextNode () {
    this.text.innerHTML = '';
    this.charIndex = -1;
  }
  
  defaultOptions () {
    return {
      appendText: '',
      backgroundColor: 'transparent',
      backspace: false,
      backspaceHighlight: true,
      color: '#212121',
      colors: {}, // Maybe provide default colours later on?
      currentColor: '#212121',
      diacriticalSigns: ['.', ',', '!', '?'],
      highlightColor: '#289BCC',
      highlightHideCursor: true,
      ignoreDiacriticalSigns: false,
      keepWords: true,
      lightColor: '#efefef',
      max_speed: 10,
      min_speed: 1,
      newLine: true,
      pause: 1000,
      plainText: false,
      // Optional - pauseStart,
      // Optionsl - pauseEnd,
      repeat: false,
      randomize: false,
      randomizeAllowRepeat: false,
      searchDOM: true,
      speed: 5,
      words: ['Hello! Looks like you have not set up any words. If you are not sure how to do that, check out the guide at https://github.com/lmenus/SelfType.js'],
    };
  }
  
  deleteAllText () {
    var timeout = 0,
      self = this,
      pause;
    
    if (this.options.backspaceHighlight) {
      pause = (this.options.pauseEnd !== undefined) ? this.options.pauseEnd : this.options.pause;
      timeout = pause / 1.5;
      this.highlightText();
    }
    
    this.pause(timeout);
    setTimeout(function () {
      self.clearTextNode();
      self.resetStyles();
      self.pause();
    }, timeout);
  }
  
  deleteLastChar () {
    var text;
    
    if (this.options.plainText) {
      text = this.text.innerHTML;
      this.text.innerHTML = text.substr(0, text.length - 1);
    }
    else {
      this.text.removeChild(this.text.lastChild);
    }
    
    this.charIndex -= 1;
    
    if (!this.text.innerHTML) {
      this.pause();
    }
  }
  
  dirtyHack () {
    this.text.innerHTML += '<br/>';
    this.text.innerHTML = this.text.innerHTML.substr(0, this.text.innerHTML.length - 4);
  }
  
  errors () {
    return {
      cursor: 'The optional cursor element was not found. To include one, provide a reference to the node in the configuration object. { nodes: { cursor: <nodeReference> } }',
      text: 'The parent node for text was not found! Please provide a reference to the node in the configuration object. { nodes: { text: <nodeReference> } }',
      words: ['Incorrect parameter set for words.'],
    };
  }
  
  extendOptions (options) {
    if (typeof options !== 'object') {
      return;
    }
      
    for (var prop in options) {
      if (prop === 'speed') {
        this.options[prop] = this.parseSpeed(options[prop]);
      }
      else if (prop === 'words') {
        if (this.hasEnoughWords(options[prop])) {
          this.options[prop] = options[prop];
        }
      }
      else {
        this.options[prop] = options[prop];
      }
    }
  }
  
  // Construct the options configuration object
  // from the attributes set on the text parent
  // node.
  getAttrsDOMNode () {
    var options = {},
      tag   = 'data-',
      attrs = this.text.attributes,
      words = this.getDOMWords();

    for (var i = 0, length = attrs.length; i < length; i++) {
      // Attempt to convert any number into integer, otherwise assign the string.
      if (attrs[i].nodeName.indexOf(tag) !== -1) {
        var value = attrs[i].nodeValue,
          parsed  = parseInt(value),
          prop    = attrs[i].nodeName.substr(tag.length);
        
        options[prop] = (isNaN(parsed)) ? value : parsed;
      }
    }
    
    if (words.length) {
      options.words = words;
    }
    
    return options;
  }
  
  // Get the words array from the children nodes
  // of the text parent node.
  getDOMWords () {
    var words  = [],
      children = this.text.childNodes,
      child;

    for (var i = 0, length = children.length; i < length; i++) {
      child = children[i];
      
      if (child.innerHTML) {
        child = child.innerHTML;
      }
      else if (child.textContent) {
        child = child.textContent;

        if (child.match(/\n/g)) {
          child = this.getWordsFromTextContent(child);
        }
      }
      
      if (typeof child === 'string') {
        child = child.replace(/[\n]/g, '');
      }
      
      if (child) {
        if (typeof child === 'string') {
          words.push(child);
        }
        else if (typeof child === 'object' && child.length) {
          child.forEach(function (word) {
            words.push(word);
          });
        }
      }
    }
    
    this.clearTextNode();
    return words;
  }
  
  getNextWord () {
    var def_opt   = this.defaultOptions(),
      wordOptions = [],
      vDOM = document.createElement('div'),
      word = '',
      childrenLength;
    
    // Reset the color for the word.
    this.options.color = def_opt.color;
    
    if (this.canPrintNextWord()) {
      word = this.options.randomize ? this.getRandomWord() : this.getNextWordInArray();
    }

    if (word) {
      this.adjustCount();
      
      word += this.options.appendText;

      // Add a newline, but only if we have already written
      // at least one word, to prevent the initial newline.
      if (this.options.newLine && this.text.innerHTML) {
        this.text.innerHTML += '<br/>';
      }
    }
    
    vDOM.innerHTML = word;
    childrenLength = vDOM.children.length;
    
    // If there is one nested node, we accept the whole content
    // as nested nodes, and remove anything that is not wrapped.
    if (childrenLength) {
      word = '';
      
      for (var i = 0; i < childrenLength; i++) {
        var child = vDOM.children[i],
          childOptions = {},
          childTextContent = '';
        
        if (child.nodeType === 1) {
          childTextContent = child.innerText;
          
          if (child.getAttribute('data-color')) {
            childOptions.color = child.getAttribute('data-color');
          }
          
          if (child.getAttribute('data-wait')) {
            childOptions.wait = parseInt(child.getAttribute('data-wait'), 10);
          }
          
          if (Object.keys(childOptions).length > 0) {
            childOptions.index = word.length;
            wordOptions.push(childOptions);
          }
        }
        
        word += childTextContent;
      }
    }
    
    this.charIndex = -1;
    this.wordOptions = wordOptions;
    this.word = word;
  }
  
  getNextWordInArray () {
    var word = this.options.words[this.pointerPosition];
    this.movePointer();
    return word;
  }
  
  getRandomWord () {
    var random = Math.floor(Math.random() * this.options.words.length),
      word = this.options.words[random];
    
    // If we have selected the same word as last time.
    if (this.pointerPosition === random) {
      // If the user does not permit repeating the same word,
      // generate a new one. The second part is there to
      // prevent getting stuck in an infinite loop.
      if (!this.options.randomizeAllowRepeat && this.options.words.length > 1) {
        word = this.getRandomWord();
      }
    }
    else {
      this.movePointer(random);
    }
    
    return word;
  }
  
  getTimeout () {
    if (this.timeoutOffset > 0) {
      this.timeoutOffset--;
      return 0;
    }
    return this.timeout;
  }

  getWordsFromTextContent (string) {
    var regex = new RegExp(/\n/),
      match   = string.match(regex),
      words   = [],
      word;

    while (string && match !== null) {
      word = '';
      
      if (string[0] === '\n') {
        string = string.substr(1);
      }

      while (string && (string[0] !== '\n' || !word)) {
        if ((string[0] !== '\n' && string[0] !== ' ') || (string[0] === ' ' && word)) {
          word += string[0];
        }
        string = string.substr(1);
      }
      
      if (word) {
        words.push(word);
      }

      match = string.match(regex);
    }

    return words;
  }
  
  // Words must be an array with at least one entry.
  hasEnoughWords (words) {
    return words && typeof words === 'object' && words !== null && words.length >= 1;
  }
  
  highlightText () {
    var children;
    
    if (this.options.highlightHideCursor && this.cursor) {
      this.cursor.style.display = 'none';
    }
    
    this.text.style.backgroundColor = this.options.highlightColor;
    if (this.isDarkColor(this.options.highlightColor)) {
      if (this.options.plainText) {
        this.text.style.currentColor = this.options.lightColor;
      }
      else {
        children = this.text.childNodes;
        for (var i = 0; i < children.length; i++) {
          children[i].style.currentColor = this.options.lightColor;
        }
      }
    }
  }
  
  isDarkColor (color) {
    if (color.indexOf('#') === -1) {
      return false;
    }
    
    var rgb = parseInt(color.substring(1), 16), // Strip the hash sign from the colour.
      r = (rgb >> 16) & 0xff,
      g = (rgb >>  8) & 0xff,
      b = (rgb >>  0) & 0xff,
      med = Math.floor((r + g + b) / 3);

    return med > 255 / 2;
  }
  
  isInArray (needle, haystack) {
    for (var i = 0; i < haystack.length; i++) {
      if (haystack[i] === needle) {
        return haystack[i];
      }
    }
    return false;
  }
  
  isInWord (haystack, offset) {
    offset = offset || 0;
    for (var i = 0, length = haystack.length; i < length; i++) {
      if (this.word.substr(offset, haystack[i].length) === haystack[i]) {
        return haystack[i];
      }
    }
    return false;
  }
  
  isValidEntity () {
    return this.isInWord(['&nbsp;']);
  }

  // Create the options configuration object.
  loadOptions (options) {
    this.options = this.defaultOptions();
    this.extendOptions(options);
    
    if (this.options.searchDOM) {
      this.extendOptions(this.getAttrsDOMNode());
    }
    
    // Private variables.
    this.count = 0;
    this.charIndex = -1;
    this.pointerPosition = 0;
    this.timeout = 0;
    this.timeoutOffset = 0;
    this.timestamp = 0;
    this.wordOptions = [];
  }
  
  movePointer (position) {
    if (position !== undefined) {
      this.pointerPosition = position;
      return;
    }
    
    // Move the pointer as long as there is next character.
    if (this.pointerPosition < this.options.words.length - 1) {
      this.pointerPosition++;
    }
    else {
      this.resetPointer();
    }
  }
  
  parseSpeed (speed) {
    if (typeof speed === 'number') {
      if (speed > this.options.max_speed) {
        speed = this.options.max_speed;
      }
      
      if (speed < this.options.min_speed) {
        speed = this.options.min_speed;
      }
    }
    else if (typeof speed === 'string') {
      switch (speed) {
        case 'slow':
          speed = 1;
          break;

        case 'fast':
          speed = 7;
          break;

        // Tiny special case.
        case 'sonic':
          speed = 15;
          break;

        case 'normal':
        default:
          speed = this.options.speed;
          break;
      }
    }
    
    return speed;
  }
  
  // Temporarily disables the animation.
  pause (time, offset) {
    var timeout = 0,
      prop = 'pause',
      route;
    
    offset = offset || 0;
    
    if (time !== undefined && !isNaN(time)) {
      timeout = time;
    }
    else {
      route = (!this.text.innerHTML) ? 'pauseStart' : 'pauseEnd';
      if (this.options[route] !== undefined) {
        prop = route;
      }
      timeout = this.options[prop];
    }
            
    this.timeout = timeout;
    this.timeoutOffset = offset;
    this.timestamp = Date.now() + timeout;
  }
  
  // Disables animation completely.
  pauseAnimation () {
    if (this.interval) {
      window.clearInterval(this.interval);
    }
  }
  
  pauseDiacriticalSign (char) {
    var log  = Math.round(Math.log(this.options.speed + 1) * 10),
        base = (char === '.') ? 6000 : 3200; // Full stop waits longer.
    this.pause(Math.round(base/(log - 6)), 1);
  }
  
  playAnimation () {
    var self = this;
    
    // Cancel the previous interval. This is to prevent
    // having multiple instances running at the same time.
    this.pauseAnimation();
    
    this.interval = setInterval(function () {
      if (!self.canPerformNextStep()) {
        return;
      }

      // We are animating a word being written.
      if (self.word) {
        self.printNextChar();
      }
      // We are at the end of the word, should we remove anything at all?
      else if (self.text.innerHTML && !self.options.keepWords) {
        self.options.backspace ? self.deleteLastChar() : self.deleteAllText();
      }
      // Get next word.
      else {
        self.getNextWord();
      }
    }, Math.round(250 / this.options.speed));
  }
  
  printNextChar () {
    var self = this,
      char   = this.word.substr(0, 1),
      wordOptions = this.wordOptions,
      expression;
    
    this.charIndex += 1;
    
    // Check if there is any change in the word options on this character.
    if (wordOptions.length && wordOptions[0].index === this.charIndex) {
      if (wordOptions[0].wait && !isNaN(parseInt(wordOptions[0].wait))) {
        this.pause(parseInt(wordOptions[0].wait));
      }
      
      if (wordOptions[0].color && this.options.colors[wordOptions[0].color]) {
        this.options.currentColor = this.options.colors[wordOptions[0].color];
      }
      
      // Remove this setting.
      this.wordOptions.splice(0, 1);
    }
    
    // HTML entities.
    if (char === '&') {
      expression = this.isValidEntity();
      if (expression) {
        char = expression;
        this.word = this.word.substr(expression.length - 1);
      }
    }
    
    // Check if the current character is a diacritical sign.
    if (!this.options.ignoreDiacriticalSigns && this.isInArray(char, this.options.diacriticalSigns)) {
      // Set a delay before printing the next character.
      this.pauseDiacriticalSign(char);
    }
    
    // Used to newline the text properly.
    this.dirtyHack();
    
    setTimeout(function () {
      if (self.options.plainText) {
        self.text.innerHTML += char;
      }
      else {
        self.text.appendChild(self.wrapChar(char));
      }

      // Remove the character.
      self.word = self.word.substr(1);
      
      // Move the scroll if the text is getting too big.
      self.scrollToBottom();
      
      // Reset any timeout.
      self.resetTimeout();
      
      if (!self.word) {
        self.pause();
      }
    }, this.getTimeout());
  }
  
  // Counts on which character of the word we currently are.
  resetPointer () {
    this.pointerPosition = 0;
  }
  
  resetStyles () {
    if (this.options.highlightHideCursor && this.cursor) {
      this.cursor.style.display = '';
    }
    
    this.text.style.backgroundColor = this.defaultOptions().backgroundColor;
    this.text.style.currentColor = this.options.color;
  }
  
  resetTimeout () {
    this.timeout = 0;
  }
  
  returnPublicMethods () {
    return {
      options: this.options,
      pause: this.pauseAnimation.bind(this),
      play: this.playAnimation.bind(this),
    };
  }
  
  scrollToBottom () {
    this.text.parentNode.scrollTop = this.text.parentNode.scrollHeight;
  }
  
  // Set up the nodes for cursor and text.
  setNodeReferences (options) {
    options.nodes = options.nodes || {};
    
    var cursor = options.nodes.cursor || {},
      text   = options.nodes.text || {},
      errors = this.errors();
    
    if (!text.nodeType) {
      throw new ReferenceError(errors.text);
    }
    
    this.text = text;
    
    if (!cursor.nodeType) {
      console.warn(errors.cursor);
      return;
    }
    
    this.cursor = cursor;
  }
  
  // Wrap the element in <i> tag and apply styles.
  wrapChar (char) {
    var node = document.createElement('i');
    node.style.color = this.options.currentColor;
    node.innerHTML = char;
    return node;
  }
}