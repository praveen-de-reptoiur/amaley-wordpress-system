(function () {
  'use strict';

  var TILE_SIZE = 256;
  var MIN_ZOOM = 4;
  var MAX_ZOOM = 15;

  function clamp(value, min, max) {
    return Math.max(min, Math.min(max, value));
  }

  function toNumber(value, fallback) {
    var number = parseFloat(value);
    return Number.isFinite(number) ? number : fallback;
  }

  function lngToX(lng, zoom) {
    return ((lng + 180) / 360) * TILE_SIZE * Math.pow(2, zoom);
  }

  function latToY(lat, zoom) {
    var safeLat = clamp(lat, -85.05112878, 85.05112878);
    var rad = safeLat * Math.PI / 180;
    return (1 - Math.log(Math.tan(rad) + 1 / Math.cos(rad)) / Math.PI) / 2 * TILE_SIZE * Math.pow(2, zoom);
  }

  function xToLng(x, zoom) {
    return x / (TILE_SIZE * Math.pow(2, zoom)) * 360 - 180;
  }

  function yToLat(y, zoom) {
    var n = Math.PI - 2 * Math.PI * y / (TILE_SIZE * Math.pow(2, zoom));
    return 180 / Math.PI * Math.atan(0.5 * (Math.exp(n) - Math.exp(-n)));
  }

  function tileUrl(template, z, x, y) {
    return template.replace('{z}', z).replace('{x}', x).replace('{y}', y);
  }

  function setupMap(map) {
    if (!map || map.dataset.acwRealMapReady === '1') return;
    map.dataset.acwRealMapReady = '1';

    var tileLayer = map.querySelector('[data-acw-tile-layer]');
    var routeLine = map.querySelector('[data-acw-route-line]');
    var points = Array.prototype.slice.call(map.querySelectorAll('[data-acw-map-point], [data-acw-map-label]'));
    var template = map.getAttribute('data-tile-url') || 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';

    var initial = {
      lat: toNumber(map.getAttribute('data-center-lat'), 34.185),
      lng: toNumber(map.getAttribute('data-center-lng'), 77.43),
      zoom: clamp(parseInt(map.getAttribute('data-zoom') || '10', 10), MIN_ZOOM, MAX_ZOOM)
    };

    var state = {
      lat: initial.lat,
      lng: initial.lng,
      zoom: initial.zoom,
      dragging: false,
      startX: 0,
      startY: 0,
      startCenterX: 0,
      startCenterY: 0
    };

    function size() {
      var rect = map.getBoundingClientRect();
      return { width: Math.max(1, rect.width), height: Math.max(1, rect.height) };
    }

    function centerPx() {
      return {
        x: lngToX(state.lng, state.zoom),
        y: latToY(state.lat, state.zoom)
      };
    }

    function project(lat, lng) {
      var s = size();
      var c = centerPx();
      return {
        x: lngToX(lng, state.zoom) - c.x + s.width / 2,
        y: latToY(lat, state.zoom) - c.y + s.height / 2
      };
    }

    function renderTiles() {
      if (!tileLayer) return;
      var s = size();
      var c = centerPx();
      var startX = c.x - s.width / 2;
      var startY = c.y - s.height / 2;
      var endX = c.x + s.width / 2;
      var endY = c.y + s.height / 2;
      var minTileX = Math.floor(startX / TILE_SIZE) - 1;
      var maxTileX = Math.floor(endX / TILE_SIZE) + 1;
      var minTileY = Math.floor(startY / TILE_SIZE) - 1;
      var maxTileY = Math.floor(endY / TILE_SIZE) + 1;
      var tileCount = Math.pow(2, state.zoom);
      var fragment = document.createDocumentFragment();

      tileLayer.innerHTML = '';
      for (var x = minTileX; x <= maxTileX; x++) {
        for (var y = minTileY; y <= maxTileY; y++) {
          if (y < 0 || y >= tileCount) continue;
          var wrappedX = ((x % tileCount) + tileCount) % tileCount;
          var img = document.createElement('img');
          img.className = 'amaley-cw4-origin-map-path-tile';
          img.alt = '';
          img.loading = 'lazy';
          img.draggable = false;
          img.referrerPolicy = 'no-referrer-when-downgrade';
          img.src = tileUrl(template, state.zoom, wrappedX, y);
          img.style.left = Math.round(x * TILE_SIZE - startX) + 'px';
          img.style.top = Math.round(y * TILE_SIZE - startY) + 'px';
          fragment.appendChild(img);
        }
      }
      tileLayer.appendChild(fragment);
    }

    function renderMarkers() {
      var linePoints = [];
      points.forEach(function (el) {
        var lat = toNumber(el.getAttribute('data-lat'), initial.lat);
        var lng = toNumber(el.getAttribute('data-lng'), initial.lng);
        var p = project(lat, lng);
        el.style.left = p.x + 'px';
        el.style.top = p.y + 'px';
        if (el.hasAttribute('data-acw-map-point')) {
          linePoints.push(p.x.toFixed(1) + ',' + p.y.toFixed(1));
        }
      });
      if (routeLine) {
        routeLine.setAttribute('points', linePoints.join(' '));
      }
    }

    function render() {
      renderTiles();
      renderMarkers();
      map.setAttribute('data-current-zoom', String(state.zoom));
    }

    function moveCenterBy(deltaX, deltaY) {
      var c = centerPx();
      state.lng = xToLng(c.x - deltaX, state.zoom);
      state.lat = yToLat(c.y - deltaY, state.zoom);
      render();
    }

    function zoomTo(nextZoom, originX, originY) {
      nextZoom = clamp(nextZoom, MIN_ZOOM, MAX_ZOOM);
      if (nextZoom === state.zoom) return;

      var s = size();
      originX = typeof originX === 'number' ? originX : s.width / 2;
      originY = typeof originY === 'number' ? originY : s.height / 2;

      var beforeCenter = centerPx();
      var beforeWorldX = beforeCenter.x + originX - s.width / 2;
      var beforeWorldY = beforeCenter.y + originY - s.height / 2;
      var beforeLng = xToLng(beforeWorldX, state.zoom);
      var beforeLat = yToLat(beforeWorldY, state.zoom);

      state.zoom = nextZoom;
      var afterWorldX = lngToX(beforeLng, state.zoom);
      var afterWorldY = latToY(beforeLat, state.zoom);
      var afterCenterX = afterWorldX - originX + s.width / 2;
      var afterCenterY = afterWorldY - originY + s.height / 2;
      state.lng = xToLng(afterCenterX, state.zoom);
      state.lat = yToLat(afterCenterY, state.zoom);
      render();
    }

    function reset() {
      state.lat = initial.lat;
      state.lng = initial.lng;
      state.zoom = initial.zoom;
      render();
    }

    map.addEventListener('click', function (event) {
      var button = event.target.closest('[data-acw-map-control]');
      if (!button || !map.contains(button)) return;
      event.preventDefault();
      event.stopPropagation();
      var action = button.getAttribute('data-acw-map-control');
      if (action === 'zoom-in') zoomTo(state.zoom + 1);
      if (action === 'zoom-out') zoomTo(state.zoom - 1);
      if (action === 'reset') reset();
    });

    map.addEventListener('wheel', function (event) {
      event.preventDefault();
      var rect = map.getBoundingClientRect();
      var nextZoom = event.deltaY < 0 ? state.zoom + 1 : state.zoom - 1;
      zoomTo(nextZoom, event.clientX - rect.left, event.clientY - rect.top);
    }, { passive: false });

    map.addEventListener('pointerdown', function (event) {
      if (event.target.closest('[data-acw-map-control]')) return;
      state.dragging = true;
      state.startX = event.clientX;
      state.startY = event.clientY;
      var c = centerPx();
      state.startCenterX = c.x;
      state.startCenterY = c.y;
      map.classList.add('is-dragging');
      if (map.setPointerCapture && event.pointerId !== undefined) map.setPointerCapture(event.pointerId);
    });

    map.addEventListener('pointermove', function (event) {
      if (!state.dragging) return;
      event.preventDefault();
      var dx = event.clientX - state.startX;
      var dy = event.clientY - state.startY;
      state.lng = xToLng(state.startCenterX - dx, state.zoom);
      state.lat = yToLat(state.startCenterY - dy, state.zoom);
      render();
    });

    function pointerEnd(event) {
      state.dragging = false;
      map.classList.remove('is-dragging');
      if (map.releasePointerCapture && event.pointerId !== undefined) {
        try { map.releasePointerCapture(event.pointerId); } catch (error) {}
      }
    }
    map.addEventListener('pointerup', pointerEnd);
    map.addEventListener('pointercancel', pointerEnd);
    map.addEventListener('pointerleave', pointerEnd);

    if (window.ResizeObserver) {
      var observer = new ResizeObserver(render);
      observer.observe(map);
    } else {
      window.addEventListener('resize', render);
    }

    render();
  }

  function init() {
    document.querySelectorAll('[data-acw-origin-map]').forEach(setupMap);
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();

  window.addEventListener('load', init);
  document.addEventListener('acwOriginMapRefresh', init);

  if (window.elementorFrontend && window.elementorFrontend.hooks) {
    window.elementorFrontend.hooks.addAction('frontend/element_ready/global', init);
  }
})();
