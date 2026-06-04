(function(){
  function ready(fn){
    if(document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }
  ready(function(){
    document.querySelectorAll('[data-ahfs2-toggle]').forEach(function(btn){
      btn.addEventListener('click', function(){
        var target = document.querySelector(btn.getAttribute('data-ahfs2-toggle'));
        if(target) target.hidden = !target.hidden;
      });
    });
    document.querySelectorAll('[data-ahfs2-close]').forEach(function(btn){
      btn.addEventListener('click', function(){
        var target = btn.closest('.ahfs2-mobile-drawer');
        if(target) target.hidden = true;
      });
    });
  });
})();
