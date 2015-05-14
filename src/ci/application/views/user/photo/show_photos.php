<div class="row">
   <?php foreach ($photos as $photo): ?>
       <div class="col-md-3 col-sm-4 col-xs-6 photo-item">
           <image src="<?php echo base_url().'ci/'.$photo['path'].$photo['name']; ?>" class="img-responsive" style="width: 200px;height: 200px;"></image>
       </div>
   <?php endforeach; ?>
</div>
