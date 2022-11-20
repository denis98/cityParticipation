import './bootstrap';
import $ from 'jquery';
window.$ = $;

import OSM from 'ol/source/OSM';
import TileLayer from 'ol/layer/Tile';
import Vector from 'ol/layer/Vector';
import {Map, View} from 'ol';
import {fromLonLat} from 'ol/proj';
import Feature from 'ol/Feature';
import Point from 'ol/geom/Point';
import VectorLayer from 'ol/layer/Vector';
import VectorSource from 'ol/source/Vector';
import Icon from 'ol/style/Icon';
import Style from 'ol/style/Style';
import Projection from 'ol/proj/Projection';
import * as olSize from 'ol/size';
import {transform} from 'ol/proj';

const map = new Map({
  target: 'map',
  layers: [
    new TileLayer({
      source: new OSM(),
    }),
  ],
  view: new View({
    center: fromLonLat([11.5, 48.1]),
    zoom: 16,
  }),
});

var icon = new Icon({
	anchor: [0.5, 1],
	src: 'http://hackatum.test/marker.png',
	scale: 0.07,
});
icon.load();

var markers = new VectorLayer({
		source: new VectorSource(),
		style: new Style({
			image: icon,
		}),
});
map.addLayer(markers);


function fromLongLat(coordinates) {
	return transform(coordinates, new Projection({code: 'EPSG:4326'}), new Projection({code: 'EPSG:3857'}));
}

$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	let coord = fromLongLat(idea.coordinates);
	var m = new Feature(new Point(coord));
	markers.getSource().addFeature(m);
	map.getView().setCenter(coord);
});
