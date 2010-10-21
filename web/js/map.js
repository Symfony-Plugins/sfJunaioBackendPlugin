var map = null;
var geocoder;
var markers = [];
var tmpmarker = null;

function getInfoWindowContentPut(data) {
    return '<iframe frameBorder="0" id="newPoiFrame" src="/sfJunaioBackendBase/new?lat='+data.latitude+'&lng='+data.longitude+'&name='+data.name+'&description='+data.description+'"></iframe>';
}

function getInfoWindowContentPost(data) {
    return '<iframe frameBorder="0" src="/sfJunaioBackendBase/edit/'+data.id+'"></iframe>';
}

function addPoi() {
    closeAllInfoWindows()
    var latLng = map.getCenter();

    var data = {
        latitude: latLng.lat(),
        longitude: latLng.lng(),
        name: '',
        description: ''
    }

    tmpmarker = new google.maps.Marker({
        position: latLng,
        map: map,
        title: 'New POI',
        icon: '/sfJunaioBackendPlugin/images/numeric/white00.png'
    });

    tmpmarker.infowindow = new google.maps.InfoWindow({
        content: getInfoWindowContentPut(data)
    });
    tmpmarker.infowindow.open(map, tmpmarker);
    tmpmarker.setDraggable(true);

    google.maps.event.addListener(tmpmarker, 'dragstart', function() {
        data = {
            'name' : document.getElementById('newPoiFrame').contentDocument.forms[0].elements['poi_base[name]'].value,
            'description' : document.getElementById('newPoiFrame').contentDocument.forms[0].elements['poi_base[description]'].value
        }
        tmpmarker.infowindow.close();
    });

    google.maps.event.addListener(tmpmarker, 'click', function() {
        var Check = confirm("Are you sure to remove this POI?");
        if (Check)
            this.setMap(null);
    });

    google.maps.event.addListener(tmpmarker, 'dragend', function() {
        var latLng = this.getPosition();
        closeAllInfoWindows();
        data.latitude = latLng.lat();
        data.longitude = latLng.lng();
        this.infowindow.setContent(getInfoWindowContentPut(data));
        this.infowindow.open(map, this);
    });

    google.maps.event.addListener(tmpmarker.infowindow, 'closeclick', function() {
        tmpmarker.setMap(null);
        updateMarker();
        markMainNav();
    });
}

function collectMarker() {
    removeMarker();
    $.getJSON('/sfJunaioBackendBase/list', function(data) {
        for (var i=0; i<data.length; i++) {
            markers[i] = new google.maps.Marker({
                position: new google.maps.LatLng(data[i].latitude, data[i].longitude),
                map: map,
                elemid: data[i].id,
                title: data[i].name,
                icon: data[i].icon,
                content: getInfoWindowContentPost(data[i])
            });
            markers[i].setDraggable(true);
            
            google.maps.event.addListener(markers[i], 'click', function() {
                closeAllInfoWindows();
                this.infowindow = new google.maps.InfoWindow({
                    content: this.content
                });
                this.infowindow.open(map, this);
            });
            
            google.maps.event.addListener(markers[i], 'dblclick', function() {
                editPOI('map', this.elemid, this.title);
            });

            google.maps.event.addListener(markers[i], 'dragend', function() {
                var latLng = this.getPosition();
                var lat = latLng.lat();
                var lon = latLng.lng();

                var success =
                    function (res, textStatus, elem) {
                        if (textStatus == "success" && res.error == false) {
                        }
                        else if (textStatus == "success" && res.error == true) {
                            alert(res.message);
                        }
                        else if (textStatus != "success"){
                            alert(textStatus);
                        }
                    }

                $.ajax({
                    url:     '/sfJunaioBackendBase/post/' + this.elemid,
                    type:    'POST',
                    data:    {latitude : lat, longitude: lon},
                    success: success
                });
            });
        }
        markMainNav();
    });
}

function updateMarker() {
   //Todo: Update relevant Marker only
   collectMarker();
}

function closeAllInfoWindows() {
    for (var i=0; i<markers.length; i++) {
        if (markers[i].infowindow)
            markers[i].infowindow.close();
    }
}

function removeMarker() {
    closeAllInfoWindows();
    for (var i=0; i<markers.length; i++) {
        markers[i].setMap(null);
    }
    markers = [];
}

var sessdata = {};
var sess_update_timeout = null;

function updateSession() {
     var success =
        function (res, textStatus, elem) {
            if (textStatus != "success") {
                alert(textStatus);
            }
        }

    $.ajax({
        url:     '/sfJunaioBackendMap/updatesession',
        type:    'GET',
        data:    sessdata,
        success: success
    });
}

function collectSessdata() {
    var myLatlng = map.getCenter();
    sessdata = {
        latitude: myLatlng.lat(),
        longitude: myLatlng.lng(),
        zoom: map.getZoom()
    };
    if (sess_update_timeout != null) {
        window.clearTimeout(sess_update_timeout);
        sess_update_timeout = null;
    }
    sess_update_timeout = window.setTimeout(updateSession, 3000);
}

function initialize(Lat, Lng, Zoom) {
    if ($('#map_canvas').length < 1)
        return;

    $('#map_canvas').ajaxError(function(evt, req, opts, err) {
        console.dir([evt, req, opts, err]);
    });

    sessdata = {
        latitude: Lat,
        longitude: Lng,
        zoom: Zoom
    };

    geocoder = new google.maps.Geocoder();
    var myLatlng = new google.maps.LatLng(Lat, Lng);
    var myOptions = {
        zoom: Zoom,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    google.maps.event.addListener(map, 'zoom_changed', collectSessdata);
    google.maps.event.addListener(map, 'center_changed', collectSessdata);

    collectMarker();
}


function centerPOI(Lat, Lng) {
   var myLatlng = new google.maps.LatLng(Lat, Lng);
   map.setCenter(myLatlng);
   map.setZoom(16);
   $('#dialoglist').dialog("close");
   $('#dialoglist').dialog("destroy");
   $('#dialoglist').remove();
   markMainNav();
}

function editPOI(sender, id, title) {
   closeAllInfoWindows();

   var templateDetails = $('<div id="dialogdetails" title="'+title+'"><iframe frameBorder="0" id="PoiDetailsFrame" src=/sfJunaioBackendDetails/edit/id/'+id+'"></iframe></div>');
   $(document.body).append(templateDetails);

   var hasChanges = false;
   $('#dialogdetails').dialog({
      autoOpen: true,
      width: 935,
      height: 500,
      modal: true,
      buttons: {
         "Reload": function() {
            document.getElementById('PoiDetailsFrame').contentDocument.location.reload();
         },
         "Save": function() {
            document.getElementById('PoiDetailsFrame').contentDocument.forms[0].submit();
            hasChanges = true;
         },
         "Close": function() {
            if (hasChanges) {
               updateMarker();
               switch (sender) {
                  case "list" :
                     $('#dialoglist iframe').attr("src", "/sfJunaioBackendBase/index");
                  break;
               }
            }
            $('#dialogdetails').dialog("close");
            $('#dialogdetails').dialog("destroy");
            $('#dialogdetails').remove();
         }
      }
   });
}