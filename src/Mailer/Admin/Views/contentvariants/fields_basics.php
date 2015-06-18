<div class="row">
   
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
    
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" placeholder="Title" value="<?php echo $flash->old('title'); ?>" class="form-control" />
        </div>
        <!-- /.form-group -->
                 
        <div class="form-group">
            <label>Description - Information about difference from other variants</label>
            <input type="text" name="copy" placeholder="Title" value="<?php echo $flash->old('copy'); ?>" class="form-control" />
           
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            <label>Email Subject</label>
            <input type="text" name="event_title" placeholder="Title" value="<?php echo $flash->old('event_title'); ?>" class="form-control" />
           
        </div>
         <div class="form-group">
            <label>Email Body HTML</label>
            <textarea name="event_html" class="form-control wysiwyg"><?php echo $flash->old('event_html'); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Email Body TEXT</label>
            <textarea name="event_text" class="form-control "><?php echo $flash->old('event_text'); ?></textarea>
        </div>
        <!-- /.form-group -->
        
    </div>
    
    <!-- /.col-md-10 -->

    <div class="col-md-2">
        
        <h3>Blocks</h3>
      	<ul class="list-group">
        <?php foreach ((new \Mailer\Models\Blocks)->find() as $doc) :?>
        <li class="list-group-item">{{ @<?php echo $doc['key']; ?> }}</li>
        <?php endforeach;?>
        </ul>
        
                
    </div>
    
</div>
<!-- /.row -->

<hr />



