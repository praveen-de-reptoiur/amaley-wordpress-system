(function(){
  'use strict';

  if (window.location && (window.location.search.indexOf('elementor-preview') !== -1 || window.location.search.indexOf('action=elementor') !== -1)) { return; }

  function closest(el, selector){
    while (el && el.nodeType === 1){
      if (el.matches(selector)) return el;
      el = el.parentElement;
    }
    return null;
  }

  function getSettings(section){
    try { return section.dataset.ammsSettings ? JSON.parse(section.dataset.ammsSettings) : {}; }
    catch(e){ return {}; }
  }

  function setLoading(section, loading){
    section.classList.toggle('amms-products-loading', !!loading);
    section.querySelectorAll('.amms-pagination a').forEach(function(link){
      if (loading) link.setAttribute('aria-disabled','true');
      else link.removeAttribute('aria-disabled');
    });
  }

  document.addEventListener('click', function(event){
    var link = closest(event.target, '.amms-products-pagination a[data-amms-page]');
    if (!link) return;

    var section = closest(link, '[data-amms-products-section="1"]');
    if (!section) return;

    var results = section.querySelector('[data-amms-products-results="1"]');
    var ajaxUrl = section.dataset.ammsAjaxUrl;
    var nonce = section.dataset.ammsNonce;
    var memberId = section.dataset.ammsMemberId;
    var page = link.dataset.ammsPage;

    if (!results || !ajaxUrl || !nonce || !memberId || !page) return;

    event.preventDefault();
    if (section.classList.contains('amms-products-loading')) return;

    var form = new FormData();
    form.append('action', 'amaley_member_single_products_pagination');
    form.append('nonce', nonce);
    form.append('member_id', memberId);
    form.append('page', page);
    form.append('settings', JSON.stringify(getSettings(section)));

    setLoading(section, true);

    fetch(ajaxUrl, { method:'POST', credentials:'same-origin', body: form })
      .then(function(response){
        if (!response.ok) throw new Error('Pagination request failed');
        return response.json();
      })
      .then(function(payload){
        if (!payload || !payload.success || !payload.data || typeof payload.data.html !== 'string') {
          throw new Error('Invalid pagination response');
        }
        results.innerHTML = payload.data.html;
        section.scrollIntoView({behavior:'smooth', block:'start'});
      })
      .catch(function(){
        window.location.href = link.href;
      })
      .finally(function(){
        setLoading(section, false);
      });
  });
})();
