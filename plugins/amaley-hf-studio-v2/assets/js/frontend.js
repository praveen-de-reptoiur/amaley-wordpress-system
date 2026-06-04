(function(){
  function ready(fn){ if(document.readyState !== 'loading'){ fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }
  function closeDrawer(drawer){
    if(!drawer) return;
    drawer.hidden = true;
    drawer.classList.remove('is-open');
    var wrap = drawer.closest('.ahfs2-header-widget');
    var overlay = wrap ? wrap.querySelector('.ahfs2-mobile-overlay') : document.querySelector('.ahfs2-mobile-overlay');
    if(overlay){ overlay.hidden = true; overlay.classList.remove('is-open'); }
  }
  ready(function(){
    var fallback = document.querySelector('.ahfs2-zone-header--fallback');
    if(fallback && document.body && document.body.firstChild !== fallback){
      document.body.insertBefore(fallback, document.body.firstChild);
      document.documentElement.classList.add('ahfs2-header-fallback-used');
    }
  });
  document.addEventListener('click', function(e){
    var toggle = e.target.closest('.ahfs2-menu-toggle,[data-ahfs2-toggle]');
    if(toggle){
      e.preventDefault();
      var wrap = toggle.closest('.ahfs2-header-widget');
      var drawer = wrap ? wrap.querySelector('.ahfs2-mobile-drawer') : document.querySelector('.ahfs2-mobile-drawer');
      if(drawer){
        drawer.hidden = false;
        drawer.classList.add('is-open');
        var overlay = wrap ? wrap.querySelector('.ahfs2-mobile-overlay') : document.querySelector('.ahfs2-mobile-overlay');
        if(overlay){ overlay.hidden = false; overlay.classList.add('is-open'); }
      }
      return false;
    }
    var close = e.target.closest('[data-ahfs2-close],.ahfs2-drawer-close,.ahfs2-mobile-overlay');
    if(close){
      e.preventDefault();
      closeDrawer(close.closest('.ahfs2-mobile-drawer') || document.querySelector('.ahfs2-mobile-drawer'));
      return false;
    }
  }, true);
  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape'){ document.querySelectorAll('.ahfs2-mobile-drawer').forEach(closeDrawer); }
  });
})();
