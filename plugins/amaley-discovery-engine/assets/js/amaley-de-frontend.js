(function () {
  'use strict';

  function qs(root, selector) { return root.querySelector(selector); }
  function qsa(root, selector) { return Array.prototype.slice.call(root.querySelectorAll(selector)); }

  function formToData(form) { return new FormData(form); }

  function updateUrlFromForm(form) {
    if (!window.history || !window.history.replaceState) return;
    var params = new URLSearchParams(window.location.search);
    var data = new FormData(form);
    var managedKeys = ['ade_search', 'ade_category', 'ade_tag', 'ade_stock', 'ade_min_price', 'ade_max_price', 'ade_sort', 'ade_page', 'ade_attr_cluster', 'ade_attr_collection_type', 'ade_attr_core_ingredient', 'ade_attr_producer_maker', 'ade_attr_region_cluster', 'ade_attr_shg', 'ade_attr_use_case', 'ade_attr_village_source_location'];
    managedKeys.forEach(function (key) {
      var value = data.get(key);
      if (value) { params.set(key, value); } else { params.delete(key); }
    });
    var newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '') + window.location.hash;
    window.history.replaceState({}, '', newUrl);
  }

  function anyDrawerOpen() {
    return !!document.querySelector('[data-ade-root].is-filter-open');
  }

  function setFilterOpen(root, isOpen) {
    root.classList.toggle('is-filter-open', !!isOpen);
    document.documentElement.classList.toggle('amaley-de-filter-open', anyDrawerOpen());
  }

  function syncQuickPills(root, value) {
    qsa(root, '[data-ade-quick-category]').forEach(function (pill) {
      if ((pill.getAttribute('data-ade-quick-category') || '') === (value || '')) { pill.classList.add('is-active'); }
      else { pill.classList.remove('is-active'); }
    });
  }

  function syncMobileSort(root, value) {
    var mobileSort = qs(root, '[data-ade-mobile-sort]');
    if (mobileSort && value) mobileSort.value = value;
  }

  function updateMobileBar(root) {
    var resultCount = qs(root, '[data-ade-count]');
    var mobileCount = qs(root, '[data-ade-mobile-count]');
    if (resultCount && mobileCount) { mobileCount.textContent = resultCount.textContent; }
    var chips = qs(root, '[data-ade-results-wrap] .amaley-discovery-engine-v1__chips');
    var mobileChips = qs(root, '[data-ade-mobile-chips]');
    if (mobileChips) { mobileChips.innerHTML = chips ? chips.outerHTML : ''; }
  }

  function runAjax(root, form) {
    var settings = root.getAttribute('data-ade-settings') || '{}';
    var data = formToData(form);
    data.append('action', 'amaley_de_filter');
    data.append('nonce', (window.amaleyDiscoveryEngine && window.amaleyDiscoveryEngine.nonce) || '');
    data.append('settings', settings);
    root.classList.add('is-loading');
    fetch((window.amaleyDiscoveryEngine && window.amaleyDiscoveryEngine.ajaxUrl) || '', {
      method: 'POST', credentials: 'same-origin', body: data
    }).then(function (res) { return res.json(); }).then(function (json) {
      if (!json || !json.success || !json.data || !json.data.html) { form.submit(); return; }
      var wrap = qs(root, '[data-ade-results-wrap]');
      if (wrap) wrap.innerHTML = json.data.html;
      updateMobileBar(root);
      updateUrlFromForm(form);
      setFilterOpen(root, false);
    }).catch(function () { form.submit(); }).finally(function () { root.classList.remove('is-loading'); });
  }

  function initRoot(root) {
    if (!root || root.__amaleyDiscoveryReady) return;
    root.__amaleyDiscoveryReady = true;
    var form = qs(root, '[data-ade-form]');
    if (!form) return;

    form.addEventListener('submit', function (event) {
      event.preventDefault();
      var pageField = qs(form, '[data-ade-page-field]');
      if (pageField && !pageField.value) pageField.value = '1';
      var catField = qs(form, '[name="ade_category"]');
      if (catField) syncQuickPills(root, catField.value || '');
      var sortField = qs(form, '[name="ade_sort"]');
      if (sortField) syncMobileSort(root, sortField.value || 'latest');
      runAjax(root, form);
    });

    root.addEventListener('change', function (event) {
      var mobileSort = event.target.closest('[data-ade-mobile-sort]');
      if (mobileSort && root.contains(mobileSort)) {
        var sortField = qs(form, '[name="ade_sort"]');
        if (sortField) sortField.value = mobileSort.value || 'latest';
        var sortPageField = qs(form, '[data-ade-page-field]');
        if (sortPageField) sortPageField.value = '1';
        runAjax(root, form);
      }
    });

    root.addEventListener('click', function (event) {
      var pageLink = event.target.closest('[data-ade-page]');
      if (pageLink && root.contains(pageLink)) {
        event.preventDefault();
        var pageField = qs(form, '[data-ade-page-field]');
        if (pageField) pageField.value = pageLink.getAttribute('data-ade-page') || '1';
        runAjax(root, form); return;
      }
      var quickCategory = event.target.closest('[data-ade-quick-category]');
      if (quickCategory && root.contains(quickCategory)) {
        event.preventDefault();
        var categoryField = qs(form, '[name="ade_category"]');
        var quickValue = quickCategory.getAttribute('data-ade-quick-category') || '';
        if (categoryField) categoryField.value = quickValue;
        var quickPageField = qs(form, '[data-ade-page-field]');
        if (quickPageField) quickPageField.value = '1';
        syncQuickPills(root, quickValue); runAjax(root, form); return;
      }
      var reset = event.target.closest('[data-ade-reset]');
      if (reset && root.contains(reset)) {
        event.preventDefault(); form.reset();
        var resetPage = qs(form, '[data-ade-page-field]');
        if (resetPage) resetPage.value = '1';
        syncQuickPills(root, ''); syncMobileSort(root, 'latest'); runAjax(root, form); return;
      }
      var open = event.target.closest('[data-ade-open-filter]');
      if (open && root.contains(open)) { event.preventDefault(); setFilterOpen(root, true); return; }
      var close = event.target.closest('[data-ade-close-filter], [data-ade-backdrop]');
      if (close && root.contains(close)) { event.preventDefault(); setFilterOpen(root, false); }
    });

    updateMobileBar(root);
  }

  function init(scope) {
    var rootScope = scope && scope.querySelectorAll ? scope : document;
    qsa(rootScope, '[data-ade-root]').forEach(initRoot);
    if (rootScope.getAttribute && rootScope.getAttribute('data-ade-root') !== null) { initRoot(rootScope); }
  }

  function observeDynamicRoots() {
    if (!window.MutationObserver || !document.documentElement) return;
    var observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        Array.prototype.slice.call(mutation.addedNodes || []).forEach(function (node) {
          if (!node || node.nodeType !== 1) return;
          if (node.getAttribute && node.getAttribute('data-ade-root') !== null) initRoot(node);
          init(node);
        });
      });
    });
    observer.observe(document.documentElement, { childList: true, subtree: true });
  }

  function bindElementorPreview() {
    if (!window.elementorFrontend || !window.elementorFrontend.hooks) return;
    window.elementorFrontend.hooks.addAction('frontend/element_ready/amaley-collection-product-filter.default', function ($scope) {
      var scope = $scope && $scope[0] ? $scope[0] : null;
      init(scope || document);
    });
    window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
      var scope = $scope && $scope[0] ? $scope[0] : null;
      if (scope && scope.querySelector && scope.querySelector('[data-ade-root]')) init(scope);
    });
  }



  function initContactMailtoForms() {
    if (document.__amaleyContactFormReady) return;
    document.__amaleyContactFormReady = true;
    document.addEventListener('submit', function (event) {
      var form = event.target && event.target.closest ? event.target.closest('.amaley-de-contact-form-cta__form--mailto') : null;
      if (!form) return;
      event.preventDefault();
      var recipient = form.getAttribute('data-recipient') || '';
      var status = form.querySelector('.amaley-de-contact-form-cta__status');
      if (!recipient) {
        if (status) status.textContent = 'Please add a recipient email in widget settings.';
        return;
      }
      var get = function (name) { var field = form.querySelector('[name="' + name + '"]'); return field ? (field.value || '').trim() : ''; };
      var subject = get('amaley_contact_subject') || 'Amaley enquiry';
      var lines = [];
      var name = get('amaley_contact_name');
      var email = get('amaley_contact_email');
      var phone = get('amaley_contact_phone');
      var message = get('amaley_contact_message');
      if (name) lines.push('Name: ' + name);
      if (email) lines.push('Email: ' + email);
      if (phone) lines.push('Phone / WhatsApp: ' + phone);
      if (message) lines.push('', 'Message:', message);
      var mailto = 'mailto:' + encodeURIComponent(recipient) + '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(lines.join('\n'));
      window.location.href = mailto;
      if (status) status.textContent = form.getAttribute('data-success') || 'Your email app should open with the enquiry details.';
    });
  }

  document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') return;
    qsa(document, '[data-ade-root].is-filter-open').forEach(function (root) { setFilterOpen(root, false); });
  });

  if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', function () { init(); initContactMailtoForms(); bindElementorPreview(); observeDynamicRoots(); }); }
  else { init(); initContactMailtoForms(); bindElementorPreview(); observeDynamicRoots(); }
})();
