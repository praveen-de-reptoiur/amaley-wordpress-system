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
    try { return section.dataset.amssSettings ? JSON.parse(section.dataset.amssSettings) : {}; }
    catch(e){ return {}; }
  }

  function setLoading(section, loading){
    section.classList.toggle('amss-related-loading', !!loading);
    section.querySelectorAll('.amss-pagination a').forEach(function(link){
      if (loading) link.setAttribute('aria-disabled','true');
      else link.removeAttribute('aria-disabled');
    });
  }

  document.addEventListener('click', function(event){
    var link = closest(event.target, '.amss-pagination a[data-amss-page]');
    if (!link) return;

    var section = closest(link, '[data-amss-related-section="1"]');
    if (!section) return;

    var results = section.querySelector('[data-amss-results="1"]');
    var ajaxUrl = section.dataset.amssAjaxUrl;
    var nonce = section.dataset.amssNonce;
    var type = section.dataset.amssType;
    var shgId = section.dataset.amssShgId;
    var page = link.dataset.amssPage;

    if (!results || !ajaxUrl || !nonce || !type || !shgId || !page) return;

    event.preventDefault();
    if (section.classList.contains('amss-related-loading')) return;

    var form = new FormData();
    form.append('action', 'amaley_shg_single_pagination');
    form.append('nonce', nonce);
    form.append('type', type);
    form.append('shg_id', shgId);
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
