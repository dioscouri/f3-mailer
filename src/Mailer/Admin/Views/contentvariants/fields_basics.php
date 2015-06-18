<div class="row">
    <div class="col-md-2">
        
        <h3>Basics</h3>
                
    </div>
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
            <label>Email Body</label>
            <textarea name="email_body" class="form-control wysiwyg"><?php echo $flash->old('email_body'); ?></textarea>
        </div>
        <!-- /.form-group -->
        
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<hr />



