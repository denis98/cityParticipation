import './bootstrap';
import $ from 'jquery';

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
    center: fromLonLat([11.57549, 48.13743]),
    zoom: 14,
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



var selectedPosition = null;
var marker = null;
map.on("click", function(event) {
	selectedPosition = event.coordinate;
	console.log(selectedPosition);
	var longlatCoordinates = transform(selectedPosition, new Projection({code: 'EPSG:3857'}), new Projection({code: 'EPSG:4326'}));

	if( marker == null ) {
		marker = new Feature(new Point(selectedPosition));
		markers.getSource().addFeature(marker);
	} else {
		marker.setGeometry(new Point(selectedPosition));
	}

	var lat = longlatCoordinates[1];
	var long = longlatCoordinates[0];

	$.ajax({
		url: `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${long}&zoom=18&format=json`,
		data: {},
		success: function(res) {
			console.log(res.address);
			let quarter = res.address.quarter;
			let road = res.address.road ;
			let houseNumber = res.address.house_number;
			let suburb = res.address.suburb;
			let city = res.address.city ?? res.address.town ?? res.address.village;
			let district = res.address.city_district;

			var info1;
			if( quarter !== undefined ) {
				info1 = quarter;
			} else if( suburb !== undefined ) {
				info1 = suburb;
			} else if( district !== undefined ) {
				info1 = district;
			} else {
				info1 = city;
			}

			$("#info").html(`${info1}, ${road} ${houseNumber}`);
			$("#h-location").val(JSON.stringify(res.address));
			$("#h-coordinates").val(JSON.stringify(longlatCoordinates));
			$("#location-needed").hide();
		}
	});
});
