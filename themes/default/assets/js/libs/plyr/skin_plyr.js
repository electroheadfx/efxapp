(function() {
      [
          '/assets/img/sprite.svg'
      ]
      .forEach(function(u) {
          var x = new XMLHttpRequest(),
              b = document.body;

          // Check for CORS support
          // If you're loading from same domain, you can remove the whole if/else statement
          // XHR for Chrome/Firefox/Opera/Safari/IE10+
          if ('withCredentials' in x) {
              x.open('GET', u, true);
          }
          // XDomainRequest for IE8 & IE9
          else if (typeof XDomainRequest == 'function') {
              x = new XDomainRequest();
              x.open('GET', u);
          }
          else { return; }

          // Inject hidden div with sprite on load
          x.onload = function() {
              var c = document.createElement('div');
              c.setAttribute('hidden', '');
              c.innerHTML = x.responseText;
              b.insertBefore(c, b.childNodes[0]);
          }

          // Timeout for IE9
      setTimeout(function () {
        x.send();
      }, 0);
          });
})();