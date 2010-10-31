<?php use_helper('Text') ?>
<div class="SimplePOIListOuter">
    <table class="SimplePOIList" cellspacing="0" cellpadding="2">
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Updated at</th>
          <th>Latitude</th>
          <th>Longitude</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pois as $poi): ?>
        <tr class="row edit_<?php echo $poi->getId() ?>">
          <td class="edit"><?php echo $poi->getName() ?></td>
          <td class="edit"><?php echo truncate_text($poi->getDescription(), 50, '...') ?></td>
          <td class="edit"><?php echo $poi->getUpdatedAt() ?></td>
          <td class="edit"><?php echo $poi->getLatitude() ?></td>
          <td class="edit"><?php echo $poi->getLongitude() ?></td>
          <td><a href="#" onClick="parent.centerPOI(<?php echo $poi->getLatitude() ?>, <?php echo $poi->getLongitude() ?>);">Center</a></td>
          <td><?php echo link_to('Delete', 'sfJunaioBackendBase/listdelete?id='.$poi->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</div>
<script type="text/javascript">
parent.collectMarker();

$(document).ready(function() {
   $('.edit').click(function() {
      var par = $(this).parent().first();
      var cls = par[0].className.split("edit_");
      id = cls[1];
      var firstchild = $(par).children().first();
      var name = $(firstchild).html();
      parent.editPOI('list', id, name);
   });
});
</script>