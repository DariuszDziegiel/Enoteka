var APP_MAP  = {
    map: null,
    initMap: function () {
        var mapCenter   = new google.maps.LatLng(50.058039, 19.937939);
        var mapOptions = {
            zoom: 15,
            center: mapCenter,
            //draggable: false,
            zoomControl: true,
            scrollwheel: false
        }
        this.map = new google.maps.Map(document.getElementById('google-map'), mapOptions);
        this.addMarkers();
    },

    addMarkers: function () {
        var homeLatLng  = new google.maps.LatLng(50.058039, 19.937939);

        var homeHotelMarker = new MarkerWithLabel({
            position: homeLatLng,
            draggable: false,
            raiseOnDrag: false,
            map: APP_MAP.map,
            labelContent: "Enoteka Pergamin",
            labelAnchor: new google.maps.Point(22, 0),
            labelClass: "map-label", // the CSS class for the label
            labelStyle: {opacity: 0.85}
        });
    }



}


$(document).ready(function() {
    APP_MAP.initMap();
})