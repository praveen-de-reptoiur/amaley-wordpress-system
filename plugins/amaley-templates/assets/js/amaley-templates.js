/* =========================================================
AMALEY TEMPLATES — FRONTEND JS v1.0.0
Scope: only .amaley-tpl-* widgets.
Purpose: tabs + buy-now helper only.
========================================================= */
(function(){
  'use strict';

  document.addEventListener('click', function(event){
    var tabButton = event.target.closest('.amaley-tpl-info-tabs__nav button[data-amaley-tab]');
    if(tabButton){
      var tabs = tabButton.closest('.amaley-tpl-info-tabs');
      if(!tabs){ return; }
      var target = tabButton.getAttribute('data-amaley-tab');
      tabs.querySelectorAll('.amaley-tpl-info-tabs__nav button').forEach(function(button){
        button.classList.remove('is-active');
      });
      tabs.querySelectorAll('.amaley-tpl-info-tabs__panel').forEach(function(panel){
        panel.classList.remove('is-active');
      });
      tabButton.classList.add('is-active');
      var panel = tabs.querySelector('.amaley-tpl-info-tabs__panel[data-amaley-panel="' + target + '"]');
      if(panel){ panel.classList.add('is-active'); }
      return;
    }

    var buyNowButton = event.target.closest('.amaley-tpl-buy-now-button');
    if(buyNowButton){
      var widget = buyNowButton.closest('.amaley-tpl-product-hero');
      if(!widget){ return; }
      var form = widget.querySelector('form.cart');
      if(!form){ return; }
      var existing = form.querySelector('input[name="amaley_buy_now"]');
      if(!existing){
        existing = document.createElement('input');
        existing.type = 'hidden';
        existing.name = 'amaley_buy_now';
        form.appendChild(existing);
      }
      existing.value = '1';
      var addButton = form.querySelector('.single_add_to_cart_button');
      if(addButton){
        addButton.click();
      } else {
        form.submit();
      }
    }
  });
})();
