import{$ as a,M as c,T as w,O as m,V as d,f as i,I as u,a as S,b as f,S as l,F as p,P as y,t as L,c as r}from"./Map.0742d1b3.js";window.$=a;const t=new c({target:"map",layers:[new w({source:new m})],view:new d({center:i([11.5,48.1]),zoom:16})});var n=new u({anchor:[.5,1],src:"http://hackatum.test/marker.png",scale:.07});n.load();var o=new S({source:new f,style:new l({image:n})});t.addLayer(o);function g(e){return L(e,new r({code:"EPSG:4326"}),new r({code:"EPSG:3857"}))}a(document).ready(function(){a.ajaxSetup({headers:{"X-CSRF-TOKEN":a('meta[name="csrf-token"]').attr("content")}});let e=g(idea.coordinates);var s=new p(new y(e));o.getSource().addFeature(s),t.getView().setCenter(e)});