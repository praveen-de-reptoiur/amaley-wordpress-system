(function(){
  function closeAll(){document.querySelectorAll('.ahfs2-mobile-drawer').forEach(function(d){d.hidden=true;});}
  document.addEventListener('click',function(e){
    var toggle=e.target.closest('.ahfs2-menu-toggle');
    if(toggle){var wrap=toggle.closest('.ahfs2-header-widget');var drawer=wrap?wrap.querySelector('.ahfs2-mobile-drawer'):null;if(drawer){drawer.hidden=false;}return;}
    if(e.target.closest('.ahfs2-drawer-close')){closeAll();}
  });
  document.addEventListener('keydown',function(e){if(e.key==='Escape'){closeAll();}});
})();
