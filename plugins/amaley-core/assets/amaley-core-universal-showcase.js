/*
 * Amaley Core Universal Showcase
 * Scoped vanilla JS. Supports multiple widget instances on the same page.
 */
(function () {
    'use strict';

    function qsa(root, selector) {
        return Array.prototype.slice.call(root.querySelectorAll(selector));
    }

    function getItemWidth(track) {
        var item = track.querySelector('.amaley-usw__item');
        if (!item) {
            return 0;
        }
        var rect = item.getBoundingClientRect();
        var styles = window.getComputedStyle(track);
        var gap = parseFloat(styles.columnGap || styles.gap || 0) || 0;
        return rect.width + gap;
    }

    function currentIndex(track) {
        var width = getItemWidth(track);
        if (!width) {
            return 0;
        }
        return Math.round(track.scrollLeft / width);
    }

    function updateShowcase(section) {
        var track = section.querySelector('[data-amaley-usw-track]');
        if (!track) {
            return;
        }

        var items = qsa(track, '.amaley-usw__item');
        var index = Math.max(0, Math.min(items.length - 1, currentIndex(track)));
        var counter = section.querySelector('[data-amaley-usw-counter]');
        var dots = qsa(section, '.amaley-usw__dot');
        var prev = section.querySelector('[data-amaley-usw-prev]');
        var next = section.querySelector('[data-amaley-usw-next]');

        if (counter) {
            counter.textContent = (index + 1) + ' / ' + items.length;
        }

        dots.forEach(function (dot, dotIndex) {
            dot.classList.toggle('is-active', dotIndex === index);
        });

        if (prev) {
            prev.disabled = index <= 0;
        }
        if (next) {
            next.disabled = index >= items.length - 1;
        }
    }

    function initShowcase(section) {
        if (!section || section.dataset.uswReady === '1') {
            return;
        }
        section.dataset.uswReady = '1';

        var track = section.querySelector('[data-amaley-usw-track]');
        if (!track) {
            return;
        }

        var mobileCardsView = section.getAttribute('data-mobile-cards-view') || '1.12';
        section.style.setProperty('--amaley-usw-mobile-cards-view', mobileCardsView);

        var items = qsa(track, '.amaley-usw__item');
        var dotsWrap = section.querySelector('[data-amaley-usw-dots]');

        if (dotsWrap) {
            dotsWrap.innerHTML = '';
            items.forEach(function (_, index) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'amaley-usw__dot';
                dot.setAttribute('aria-label', 'Go to item ' + (index + 1));
                dot.addEventListener('click', function () {
                    var width = getItemWidth(track);
                    track.scrollTo({ left: width * index, behavior: 'smooth' });
                });
                dotsWrap.appendChild(dot);
            });
        }

        var prev = section.querySelector('[data-amaley-usw-prev]');
        var next = section.querySelector('[data-amaley-usw-next]');

        if (prev) {
            prev.addEventListener('click', function () {
                var width = getItemWidth(track);
                track.scrollBy({ left: -width, behavior: 'smooth' });
            });
        }
        if (next) {
            next.addEventListener('click', function () {
                var width = getItemWidth(track);
                track.scrollBy({ left: width, behavior: 'smooth' });
            });
        }

        track.addEventListener('scroll', function () {
            window.requestAnimationFrame(function () {
                updateShowcase(section);
            });
        }, { passive: true });

        window.addEventListener('resize', function () {
            updateShowcase(section);
        });

        updateShowcase(section);
    }

    function initAll() {
        qsa(document, '[data-amaley-usw="1"]').forEach(initShowcase);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }

    window.addEventListener('elementor/frontend/init', function () {
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            window.elementorFrontend.hooks.addAction('frontend/element_ready/amaley_core_universal_showcase.default', initAll);
        }
    });
}());
