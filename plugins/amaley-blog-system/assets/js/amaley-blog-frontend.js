(function(){
  'use strict';

  function closeDrawer(drawer){
    if(!drawer){ return; }
    drawer.classList.remove('is-open');
    document.documentElement.classList.remove('amaley-blog-drawer-open');
  }

  function initDrawers(){
    document.addEventListener('click', function(e){
      var open = e.target.closest('[data-amaley-blog-drawer-open]');
      if(open){
        var root = open.closest('.amaley-blog-archive-layout') || document;
        var drawer = root.querySelector('[data-amaley-blog-drawer]');
        if(drawer){
          drawer.classList.add('is-open');
          document.documentElement.classList.add('amaley-blog-drawer-open');
        }
      }

      var close = e.target.closest('[data-amaley-blog-drawer-close]');
      if(close){ closeDrawer(close.closest('[data-amaley-blog-drawer]')); }

      var drawerEl = e.target.matches('[data-amaley-blog-drawer].is-open') ? e.target : null;
      if(drawerEl){ closeDrawer(drawerEl); }
    });

    document.addEventListener('keydown', function(e){
      if(e.key !== 'Escape'){ return; }
      document.querySelectorAll('[data-amaley-blog-drawer].is-open').forEach(closeDrawer);
    });
  }

  function initToc(){
    document.querySelectorAll('[data-amaley-blog-toc]').forEach(function(toc){
      var scope = toc.closest('.elementor, body') || document;
      var content = scope.querySelector('[data-amaley-blog-content]') || document.querySelector('[data-amaley-blog-content]');
      if(!toc || !content){ return; }
      var headings = content.querySelectorAll('h2, h3');
      if(!headings.length){ return; }
      toc.innerHTML = '';
      headings.forEach(function(heading, index){
        if(!heading.id){ heading.id = 'amaley-blog-section-' + (index + 1); }
        var link = document.createElement('a');
        link.href = '#' + heading.id;
        link.textContent = heading.textContent || ('Section ' + (index + 1));
        link.className = heading.tagName.toLowerCase() === 'h3' ? 'is-child' : '';
        toc.appendChild(link);
      });
    });
  }

  function text(el, attr){
    return (el.getAttribute(attr) || '').toString().toLowerCase();
  }

  function initArchive(archive){
    if(!archive || archive.dataset.amaleyBlogReady === '1'){ return; }
    archive.dataset.amaleyBlogReady = '1';

    var grid = archive.querySelector('.amaley-blog-grid');
    if(!grid){ return; }

    var allCards = Array.prototype.slice.call(grid.querySelectorAll('[data-amaley-blog-card]'));
    var perPage = parseInt(archive.getAttribute('data-posts-per-page') || '9', 10);
    if(!perPage || perPage < 1){ perPage = 9; }

    var state = {
      search: '',
      category: 'all',
      tag: 'all',
      sort: 'date_desc',
      view: 'grid',
      page: 1
    };

    var resultCount = archive.querySelector('.amaley-blog-result-count');
    var prefix = archive.getAttribute('data-result-prefix') || 'Showing';
    var pagination = archive.querySelector('[data-amaley-blog-pagination]');
    var resetButton = archive.querySelector('[data-amaley-blog-reset]');
    var empty = archive.querySelector('.amaley-blog-empty');

    function filteredCards(){
      var cards = allCards.filter(function(card){
        var ok = true;
        if(state.search){
          ok = text(card, 'data-search').indexOf(state.search) !== -1;
        }
        if(ok && state.category !== 'all'){
          ok = text(card, 'data-category') === state.category;
        }
        if(ok && state.tag !== 'all'){
          var tags = text(card, 'data-tags').split(/\s+/);
          ok = tags.indexOf(state.tag) !== -1;
        }
        return ok;
      });

      cards.sort(function(a,b){
        var at, bt;
        switch(state.sort){
          case 'date_asc':
            return (parseInt(a.getAttribute('data-date') || '0', 10) - parseInt(b.getAttribute('data-date') || '0', 10));
          case 'title_asc':
            at = text(a, 'data-title'); bt = text(b, 'data-title');
            return at.localeCompare(bt);
          case 'title_desc':
            at = text(a, 'data-title'); bt = text(b, 'data-title');
            return bt.localeCompare(at);
          case 'date_desc':
          default:
            return (parseInt(b.getAttribute('data-date') || '0', 10) - parseInt(a.getAttribute('data-date') || '0', 10));
        }
      });
      return cards;
    }

    function updateActiveButtons(){
      archive.querySelectorAll('[data-amaley-blog-category]').forEach(function(btn){
        btn.classList.toggle('is-active', (btn.getAttribute('data-amaley-blog-category') || 'all') === state.category);
      });
      archive.querySelectorAll('[data-amaley-blog-tag]').forEach(function(btn){
        btn.classList.toggle('is-active', (btn.getAttribute('data-amaley-blog-tag') || 'all') === state.tag);
      });
      archive.querySelectorAll('[data-amaley-blog-view]').forEach(function(btn){
        btn.classList.toggle('is-active', (btn.getAttribute('data-amaley-blog-view') || 'grid') === state.view);
      });
      archive.classList.toggle('amaley-blog-view-list', state.view === 'list');
      archive.classList.toggle('amaley-blog-view-grid', state.view !== 'list');
      if(resetButton){
        var active = !!(state.search || state.category !== 'all' || state.tag !== 'all' || state.sort !== 'date_desc' || state.view !== 'grid');
        resetButton.classList.toggle('is-hidden', !active);
      }
    }

    function renderPagination(total){
      if(!pagination){ return; }
      pagination.innerHTML = '';
      var totalPages = Math.ceil(total / perPage);
      if(totalPages <= 1){ return; }
      for(var i=1; i<=totalPages; i++){
        var b = document.createElement('button');
        b.type = 'button';
        b.className = 'page-numbers' + (i === state.page ? ' current' : '');
        b.textContent = i;
        b.setAttribute('data-amaley-blog-page', String(i));
        pagination.appendChild(b);
      }
      if(state.page < totalPages){
        var next = document.createElement('button');
        next.type = 'button';
        next.className = 'page-numbers next';
        next.textContent = '→';
        next.setAttribute('data-amaley-blog-page', String(state.page + 1));
        pagination.appendChild(next);
      }
    }

    function apply(){
      var cards = filteredCards();
      var total = cards.length;
      var totalPages = Math.max(1, Math.ceil(total / perPage));
      if(state.page > totalPages){ state.page = totalPages; }
      var start = (state.page - 1) * perPage;
      var end = Math.min(total, start + perPage);

      allCards.forEach(function(card){ card.classList.add('is-abs-hidden'); });
      cards.forEach(function(card){ grid.appendChild(card); });
      cards.slice(start, end).forEach(function(card){ card.classList.remove('is-abs-hidden'); });

      if(resultCount){
        resultCount.textContent = total ? (prefix + ' ' + (start + 1) + '–' + end + ' of ' + total + ' results') : (prefix + ' 0–0 of 0 results');
      }

      if(!empty){
        empty = document.createElement('div');
        empty.className = 'amaley-blog-empty is-abs-js-empty';
        empty.innerHTML = '<strong>No blog posts found.</strong><p>Try changing your search or filters.</p>';
        grid.appendChild(empty);
      }
      empty.classList.toggle('is-abs-hidden', total !== 0);

      updateActiveButtons();
      renderPagination(total);
    }

    archive.addEventListener('click', function(e){
      var cat = e.target.closest('[data-amaley-blog-category]');
      if(cat){
        e.preventDefault();
        state.category = cat.getAttribute('data-amaley-blog-category') || 'all';
        state.page = 1;
        apply();
        closeDrawer(archive.querySelector('[data-amaley-blog-drawer]'));
        return;
      }

      var tag = e.target.closest('[data-amaley-blog-tag]');
      if(tag){
        e.preventDefault();
        state.tag = tag.getAttribute('data-amaley-blog-tag') || 'all';
        state.page = 1;
        apply();
        closeDrawer(archive.querySelector('[data-amaley-blog-drawer]'));
        return;
      }

      var view = e.target.closest('[data-amaley-blog-view]');
      if(view){
        e.preventDefault();
        state.view = view.getAttribute('data-amaley-blog-view') || 'grid';
        apply();
        return;
      }

      var page = e.target.closest('[data-amaley-blog-page]');
      if(page){
        e.preventDefault();
        state.page = parseInt(page.getAttribute('data-amaley-blog-page') || '1', 10) || 1;
        apply();
        var top = archive.getBoundingClientRect().top + window.pageYOffset - 80;
        if(window.matchMedia('(prefers-reduced-motion: reduce)').matches){ window.scrollTo(0, top); }
        else { window.scrollTo({top: top, behavior: 'smooth'}); }
        return;
      }

      var reset = e.target.closest('[data-amaley-blog-reset]');
      if(reset){
        e.preventDefault();
        state.search = '';
        state.category = 'all';
        state.tag = 'all';
        state.sort = 'date_desc';
        state.view = 'grid';
        state.page = 1;
        var input = archive.querySelector('[data-amaley-blog-search]');
        var select = archive.querySelector('[data-amaley-blog-sort]');
        if(input){ input.value = ''; }
        if(select){ select.value = 'date_desc'; }
        apply();
      }
    });

    var search = archive.querySelector('[data-amaley-blog-search]');
    if(search){
      var timer = null;
      search.addEventListener('input', function(){
        clearTimeout(timer);
        timer = setTimeout(function(){
          state.search = (search.value || '').trim().toLowerCase();
          state.page = 1;
          apply();
        }, 120);
      });
      search.addEventListener('keydown', function(e){
        if(e.key === 'Enter'){
          e.preventDefault();
          state.search = (search.value || '').trim().toLowerCase();
          state.page = 1;
          apply();
        }
      });
    }

    var searchButton = archive.querySelector('[data-amaley-blog-search-button]');
    if(searchButton){
      searchButton.addEventListener('click', function(){
        if(search){ state.search = (search.value || '').trim().toLowerCase(); }
        state.page = 1;
        apply();
      });
    }

    var sort = archive.querySelector('[data-amaley-blog-sort]');
    if(sort){
      sort.addEventListener('change', function(){
        state.sort = sort.value || 'date_desc';
        state.page = 1;
        apply();
      });
    }

    apply();
  }

  function initArchives(context){
    (context || document).querySelectorAll('[data-amaley-blog-archive]').forEach(initArchive);
  }

  function boot(context){
    initArchives(context || document);
    initToc();
  }

  document.addEventListener('DOMContentLoaded', function(){
    initDrawers();
    boot(document);
  });

  if(window.elementorFrontend && window.elementorFrontend.hooks){
    window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function($scope){
      var node = $scope && $scope[0] ? $scope[0] : document;
      boot(node);
    });
  }
})();
