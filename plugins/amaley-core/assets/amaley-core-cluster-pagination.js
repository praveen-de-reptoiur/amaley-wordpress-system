(function(){
  'use strict';

  function closest(el, selector){
    while (el && el.nodeType === 1){
      if (el.matches(selector)) return el;
      el = el.parentElement;
    }
    return null;
  }

  function getSettings(section){
    try {
      return section.dataset.amcssSettings ? JSON.parse(section.dataset.amcssSettings) : {};
    } catch(e){
      return {};
    }
  }

  function setLoading(section, isLoading){
    section.classList.toggle('amcss-related-loading', !!isLoading);
    var links = section.querySelectorAll('.amcss-pagination a');
    links.forEach(function(link){
      if (isLoading) {
        link.setAttribute('aria-disabled', 'true');
      } else {
        link.removeAttribute('aria-disabled');
      }
    });
  }

  document.addEventListener('click', function(event){
    var link = closest(event.target, '.amcss-pagination a[data-amcss-page]');
    if (!link) return;

    var section = closest(link, '[data-amcss-related-section="1"]');
    if (!section) return;

    var results = section.querySelector('[data-amcss-results="1"]');
    var ajaxUrl = section.dataset.amcssAjaxUrl;
    var nonce = section.dataset.amcssNonce;
    var type = section.dataset.amcssType;
    var clusterId = section.dataset.amcssClusterId;
    var page = link.dataset.amcssPage;

    if (!results || !ajaxUrl || !nonce || !type || !clusterId || !page) {
      return;
    }

    event.preventDefault();

    if (section.classList.contains('amcss-related-loading')) {
      return;
    }

    var form = new FormData();
    form.append('action', 'amaley_cluster_related_pagination');
    form.append('nonce', nonce);
    form.append('type', type);
    form.append('cluster_id', clusterId);
    form.append('page', page);
    form.append('settings', JSON.stringify(getSettings(section)));

    setLoading(section, true);

    fetch(ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form
    })
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
