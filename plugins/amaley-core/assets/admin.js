(function ($) {
  'use strict';

  function normaliseLines(value) {
    return String(value || '')
      .split(/[\r\n,]+/)
      .map(function (item) { return item.trim(); })
      .filter(function (item, index, arr) { return item && arr.indexOf(item) === index; });
  }

  function renderPreview($field) {
    var urls = normaliseLines($field.find('.amaley-core-gallery-value').val());
    var $preview = $field.find('.amaley-core-gallery-preview');
    $preview.empty();

    urls.forEach(function (url) {
      var $fig = $('<figure />');
      $('<img />', { src: url, alt: '', loading: 'lazy' }).appendTo($fig);
      $('<button />', {
        type: 'button',
        class: 'button-link-delete amaley-core-gallery-remove',
        text: '×',
        'aria-label': 'Remove image'
      }).appendTo($fig);
      $preview.append($fig);
    });
  }

  function setUrls($field, urls) {
    $field.find('.amaley-core-gallery-value').val(normaliseLines(urls.join('\n')).join('\n'));
    renderPreview($field);
  }

  $(document).on('click', '.amaley-core-gallery-select', function (e) {
    e.preventDefault();

    var $field = $(this).closest('.amaley-core-gallery-field');
    var frame = wp.media({
      title: 'Select Amaley gallery images',
      button: { text: 'Use selected images' },
      multiple: true,
      library: { type: 'image' }
    });

    frame.on('select', function () {
      var existing = normaliseLines($field.find('.amaley-core-gallery-value').val());
      frame.state().get('selection').each(function (attachment) {
        var item = attachment.toJSON();
        if (item && item.url) {
          existing.push(item.url);
        }
      });
      setUrls($field, existing);
    });

    frame.open();
  });

  $(document).on('click', '.amaley-core-gallery-clear', function (e) {
    e.preventDefault();
    setUrls($(this).closest('.amaley-core-gallery-field'), []);
  });

  $(document).on('click', '.amaley-core-gallery-remove', function (e) {
    e.preventDefault();
    var $field = $(this).closest('.amaley-core-gallery-field');
    var index = $(this).closest('figure').index();
    var urls = normaliseLines($field.find('.amaley-core-gallery-value').val());
    urls.splice(index, 1);
    setUrls($field, urls);
  });

  // Gutenberg/classic metabox screens sometimes do not sync TinyMCE content before submit.
  // This keeps Amaley rich text fields reliable without changing frontend output.
  $(document).on('submit', 'form#post', function () {
    if (window.tinyMCE && typeof window.tinyMCE.triggerSave === 'function') {
      window.tinyMCE.triggerSave();
    }
  });

  $(function () {
    $('.amaley-core-gallery-field').each(function () { renderPreview($(this)); });
  });
})(jQuery);
