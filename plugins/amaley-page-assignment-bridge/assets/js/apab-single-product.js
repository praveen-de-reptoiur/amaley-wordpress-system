(function(){
  function closest(el, sel){ while(el && el.nodeType===1){ if(el.matches(sel)) return el; el=el.parentElement; } return null; }
  document.addEventListener('click', function(e){
    var tab = e.target.closest ? e.target.closest('[data-apab-tab]') : closest(e.target, '[data-apab-tab]');
    if(tab){
      var wrap = closest(tab, '.apab-info-tabs');
      if(!wrap) return;
      var key = tab.getAttribute('data-apab-tab');
      wrap.querySelectorAll('[data-apab-tab]').forEach(function(btn){ btn.classList.toggle('is-active', btn === tab); });
      wrap.querySelectorAll('[data-apab-panel]').forEach(function(panel){ panel.classList.toggle('is-active', panel.getAttribute('data-apab-panel') === key); });
      e.preventDefault();
      return;
    }
    var thumb = e.target.closest ? e.target.closest('.apab-product-hero__thumb') : closest(e.target, '.apab-product-hero__thumb');
    if(thumb){
      var gallery = closest(thumb, '.apab-product-hero__gallery');
      if(!gallery) return;
      var img = thumb.querySelector('img');
      var main = gallery.querySelector('.apab-product-hero__main-image img');
      if(img && main){
        var src = img.getAttribute('src');
        var srcset = img.getAttribute('srcset');
        if(src) main.setAttribute('src', src);
        if(srcset) main.setAttribute('srcset', srcset);
        gallery.querySelectorAll('.apab-product-hero__thumb').forEach(function(t){ t.classList.toggle('is-active', t === thumb); });
      }
      e.preventDefault();
    }
  });
})();
