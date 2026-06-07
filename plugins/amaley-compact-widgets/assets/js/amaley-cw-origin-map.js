(function(){
  'use strict';
  function lon2tile(lon,z){return Math.floor((lon+180)/360*Math.pow(2,z));}
  function lat2tile(lat,z){var r=lat*Math.PI/180;return Math.floor((1-Math.log(Math.tan(r)+1/Math.cos(r))/Math.PI)/2*Math.pow(2,z));}
  function project(lat,lng,z){var n=Math.pow(2,z)*256;var x=(parseFloat(lng)+180)/360*n;var latRad=parseFloat(lat)*Math.PI/180;var y=(1-Math.log(Math.tan(latRad)+1/Math.cos(latRad))/Math.PI)/2*n;return{x:x,y:y};}
  function initMap(root){
    if(!root||root.dataset.acwMapReady==='1')return;root.dataset.acwMapReady='1';
    var layer=root.querySelector('[data-acw-tile-layer]'), markerLayer=root.querySelector('[data-acw-marker-layer]'), svg=root.querySelector('[data-acw-route-svg]'), line=root.querySelector('[data-acw-route-line]');
    if(!layer||!markerLayer)return;
    var state={lat:parseFloat(root.dataset.centerLat||'34.185'),lng:parseFloat(root.dataset.centerLng||'77.43'),zoom:parseInt(root.dataset.zoom||'10',10),drag:false,sx:0,sy:0,ox:0,oy:0};
    var tileUrl=root.dataset.tileUrl||'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
    function render(){
      var w=root.clientWidth||600,h=root.clientHeight||360,z=Math.max(3,Math.min(17,state.zoom));
      var center=project(state.lat,state.lng,z);layer.innerHTML='';
      var startX=Math.floor((center.x-w/2)/256)-1,endX=Math.floor((center.x+w/2)/256)+1,startY=Math.floor((center.y-h/2)/256)-1,endY=Math.floor((center.y+h/2)/256)+1,max=Math.pow(2,z);
      for(var x=startX;x<=endX;x++){for(var y=startY;y<=endY;y++){if(y<0||y>=max)continue;var xx=((x%max)+max)%max;var img=document.createElement('img');img.className='amaley-cw4-origin-map-path-tile';img.alt='';img.draggable=false;img.src=tileUrl.replace('{z}',z).replace('{x}',xx).replace('{y}',y);img.style.left=(x*256-center.x+w/2)+'px';img.style.top=(y*256-center.y+h/2)+'px';layer.appendChild(img);}}
      var pts=[];
      markerLayer.querySelectorAll('[data-acw-map-point],[data-acw-map-label]').forEach(function(el){var p=project(el.dataset.lat,el.dataset.lng,z);var left=p.x-center.x+w/2,top=p.y-center.y+h/2;el.style.left=left+'px';el.style.top=top+'px';if(el.hasAttribute('data-acw-map-point'))pts.push(left+','+top);});
      if(svg){svg.setAttribute('viewBox','0 0 '+w+' '+h);} if(line){line.setAttribute('points',pts.join(' '));}
    }
    function moveBy(dx,dy){var z=state.zoom;var c=project(state.lat,state.lng,z);var n=Math.pow(2,z)*256;c.x-=dx;c.y-=dy;state.lng=c.x/n*360-180;var y=2*c.y/n-1;state.lat=Math.atan(Math.sinh(-y*Math.PI))*180/Math.PI;render();}
    root.addEventListener('pointerdown',function(e){state.drag=true;state.sx=e.clientX;state.sy=e.clientY;root.setPointerCapture&&root.setPointerCapture(e.pointerId);});
    root.addEventListener('pointermove',function(e){if(!state.drag)return;var dx=e.clientX-state.sx,dy=e.clientY-state.sy;state.sx=e.clientX;state.sy=e.clientY;moveBy(dx,dy);});
    root.addEventListener('pointerup',function(){state.drag=false;});
    root.addEventListener('wheel',function(e){e.preventDefault();state.zoom+=e.deltaY<0?1:-1;state.zoom=Math.max(4,Math.min(15,state.zoom));render();},{passive:false});
    root.querySelectorAll('[data-acw-map-control]').forEach(function(btn){btn.addEventListener('click',function(){var c=btn.dataset.acwMapControl;if(c==='zoom-in')state.zoom=Math.min(15,state.zoom+1);if(c==='zoom-out')state.zoom=Math.max(4,state.zoom-1);if(c==='reset'){state.lat=parseFloat(root.dataset.centerLat||'34.185');state.lng=parseFloat(root.dataset.centerLng||'77.43');state.zoom=parseInt(root.dataset.zoom||'10',10);}render();});});
    window.addEventListener('resize',render);render();
  }
  function init(){document.querySelectorAll('[data-acw-origin-map]').forEach(initMap);} if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',init);}else{init();}
})();
