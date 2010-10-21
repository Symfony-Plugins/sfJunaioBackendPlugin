
function unmarkNav() {
   var all = $('#primaryNavigation ul li');
   for (var i=0; i<all.length; i++) {
      $(all[i]).removeClass('current');
   }
}

function markMainNav() {
   unmarkNav();
   $('#mainNav').addClass('current');
}

$(document).ready(function() {
   $('#dialogsearch').dialog({
      autoOpen: false,
      width: 470,
      height: 150,
      resizable: false,
      buttons: {
         "Search": function() {
            var mydialog = this;
            var address = document.getElementById("address").value;
            geocoder.geocode( { 'address': address }, function(results, status) {
               if (status == google.maps.GeocoderStatus.OK) {
                  map.setCenter(results[0].geometry.location);
                  $(mydialog).dialog("close");
                  markMainNav();
               } else {
                  alert("Geocode was not successful for the following reason: " + status);
               }
            });
         },
         "Close": function() {
            $(this).dialog("close");
            markMainNav();
         }
      }
   });

   $('#dialogabout').dialog({
      autoOpen: false,
      width: 300,
      height: 300,
      resizable: false,
      buttons: {
         "Close": function() {
            $(this).dialog("close");
            markMainNav();
         }
      }
   });

   $('#primaryNavigation ul li').click(
      function () {
         unmarkNav();
         var self = $(this);
         self = $(self[0]);
         switch (this.firstChild.className) {
            case "map" :
            break;
            case "search" :
               $('#dialogsearch').dialog('open');
            break;
            case "add" :
               addPoi();
            break;
            case "list" :
               var template = $('<div id="dialoglist" title="List POIs"><iframe frameBorder="0" src="/sfJunaioBackendBase/index"></iframe></div>');
               $(document.body).append(template);

               $('#dialoglist').dialog({
                  autoOpen: true,
                  width: 800,
                  height: 380,
                  modal: true,
                  buttons: {
                     "Reload": function() {
                        $('#dialoglist iframe').attr("src", "/sfJunaioBackendBase/index");
                     },
                     "Close": function() {
                        updateMarker();
                        $('#dialoglist').dialog("close");
                        $('#dialoglist').dialog("destroy");
                        $('#dialoglist').remove();
                        markMainNav();
                     }
                  }
               });
            break;
            case "refresh" :
               collectMarker();
            break;
            case "about" :
               $('#dialogabout').dialog('open');
            break;
            default :
               return true;
            break;
         }
         self.addClass('current');
         return false;
      }
   );

   $("input, textarea").addClass("idle");
   $("input, textarea").focus(function()
   {
      $(this).addClass("activeField").removeClass("idle");
   }).blur(function() {
      $(this).removeClass("activeField").addClass("idle");
   });
});



