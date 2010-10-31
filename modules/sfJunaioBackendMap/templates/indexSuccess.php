<div id="map_canvas"></div>
<div id="primaryNavigationOuter">
    <div id="primaryNavigationInner">
        <div class="left"></div>
        <div id="primaryNavigation">
            <ul>
                <li><a class="search" href="#">Search</a></li>
                <li><a class="add" href="#">New POI</a></li>
                <li><a class="list" href="#">Show List</a></li>
                <li><a class="refresh" href="#">Refresh Map</a></li>
                <?php if (sfConfig::get('app_navigation_link_target') != "") : ?>
                <li><a class="opt_link" target="_new" href="<?php echo sfConfig::get('app_navigation_link_target'); ?>"><?php echo sfConfig::get('app_navigation_link_title'); ?></a></li>
                <?php endif; ?>
                <li><a class="about" href="#">About</a></li>
                <li><a class="logout" href="/logout">Logout</a></li>
            </ul>
        </div>
        <div class="right"></div>
    </div>
</div>
<div id="dialogsearch" title="Search Location">
   <p>
      <span class="field">
         <input type="input" id="address" name="address" tabindex="1" class="titleinside idle" title="Address" value="Address" autocomplete="off">
      </span>
   </p>
</div>
<div id="dialogabout" title="About">
    <?php echo $sf_data->getRaw('about'); ?>
</div>
<script type="text/javascript">
$(document).ready(function() {
   var latitude  = <?php echo $latitude; ?>;
   var longitude = <?php echo $longitude; ?>;
   var zoom      = <?php echo $zoom; ?>;
   initialize(latitude, longitude, zoom);
});
</script>
