/* Amaley Home Hero V6 counter. Scoped. No jQuery. */
(function(){
  function runAmaleyHeroV6Counter(){
    var heroes = document.querySelectorAll('[data-amaley-home-hero-v6]');
    if(!heroes.length) return;
    var counterDuration = 3500;
    function animateCounter(counter){
      if(!counter) return;
      counter.removeAttribute('data-ahh6-done');
      if(counter.getAttribute('data-ahh6-running') === 'true') return;
      counter.setAttribute('data-ahh6-running','true');
      var target = parseInt(counter.getAttribute('data-count') || '0', 10);
      var suffix = counter.getAttribute('data-suffix') || '';
      var startTime = null;
      counter.textContent = '0' + suffix;
      counter.classList.add('ahh6-counting');
      function step(timestamp){
        if(!startTime) startTime = timestamp;
        var progress = Math.min((timestamp - startTime) / counterDuration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        var value = Math.floor(eased * target);
        counter.textContent = value + suffix;
        if(progress < 1){
          window.requestAnimationFrame(step);
        }else{
          counter.textContent = target + suffix;
          counter.setAttribute('data-ahh6-done','true');
          counter.removeAttribute('data-ahh6-running');
          setTimeout(function(){counter.classList.remove('ahh6-counting');}, 300);
        }
      }
      window.requestAnimationFrame(step);
    }
    heroes.forEach(function(hero){
      var counters = hero.querySelectorAll('[data-ahh6-counter]');
      counters.forEach(function(counter){ animateCounter(counter); });
    });
  }
  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', runAmaleyHeroV6Counter);
  }else{
    runAmaleyHeroV6Counter();
  }
  window.addEventListener('load', runAmaleyHeroV6Counter);
  setTimeout(runAmaleyHeroV6Counter, 600);
})();
