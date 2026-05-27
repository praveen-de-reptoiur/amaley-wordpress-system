(function(){
  'use strict';

  function ready(fn){
    if(document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  ready(function(){
    var buttons = document.querySelectorAll('.amaley-shell-mobile-toggle');
    var drawer = document.getElementById('amaley-shell-mobile-drawer');
    var closers = document.querySelectorAll('[data-amaley-shell-mobile-close]');

    if(!drawer || !buttons.length){ return; }

    function openDrawer(){
      document.documentElement.classList.add('amaley-shell-drawer-open');
      document.body.classList.add('amaley-shell-drawer-open');
      drawer.setAttribute('aria-hidden','false');
      buttons.forEach(function(btn){ btn.setAttribute('aria-expanded','true'); });
      closers.forEach(function(el){ if(el.hasAttribute('hidden')) el.removeAttribute('hidden'); });
    }

    function closeDrawer(){
      document.documentElement.classList.remove('amaley-shell-drawer-open');
      document.body.classList.remove('amaley-shell-drawer-open');
      drawer.setAttribute('aria-hidden','true');
      buttons.forEach(function(btn){ btn.setAttribute('aria-expanded','false'); });
      closers.forEach(function(el){ if(el.classList.contains('amaley-shell-mobile-overlay')) el.setAttribute('hidden','hidden'); });
    }

    buttons.forEach(function(btn){
      btn.addEventListener('click', function(){
        var isOpen = btn.getAttribute('aria-expanded') === 'true';
        if(isOpen) closeDrawer();
        else openDrawer();
      });
    });

    closers.forEach(function(el){ el.addEventListener('click', closeDrawer); });

    document.addEventListener('keydown', function(event){
      if(event.key === 'Escape') closeDrawer();
    });
  });
})();
