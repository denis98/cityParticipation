import{M as s,T as d,O as m,V as u,f as w,I as f,a as l,b as h,S as k,$ as t,F as v,P as y,t as L,c as r}from"./Map.0742d1b3.js";const o=new s({target:"map",layers:[new d({source:new m})],view:new u({center:w([11.57549,48.13743]),zoom:14})});var n=new f({anchor:[.5,1],src:"http://hackatum.test/marker.png",scale:.07});n.load();var i=new l({source:new h,style:new k({image:n})});o.addLayer(i);function S(e){var a=new v(new y(c(e.coordinates)));i.getSource().addFeature(a)}function c(e){return L(e,new r({code:"EPSG:4326"}),new r({code:"EPSG:3857"}))}t(document).ready(function(){ideaMarkers.forEach((e,a)=>{S(e)}),t(".idea").on("click",function(){t(".idea").removeClass("active"),t(this).addClass("active"),t(".idea.active").on("click",function(){let a=t(this).attr("data-idea-id");document.location.href=`idea/${a}`});let e=t(this).attr("data-idea-id");ideaMarkers.forEach((a,g)=>{a.id==e&&o.getView().setCenter(c(a.coordinates))})})});