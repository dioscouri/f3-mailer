<script src="./ckeditor/ckeditor.js"></script>
<script>
jQuery(document).ready(function(){
    CKEDITOR.replaceAll( 'wysiwyg' );    
});
</script>

<div class="well">

<form id="detail-form" class="form" method="post">

    <div class="row">
    
        <div class="col-md-12">
        
            <div class="clearfix">

                <div class="pull-right">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <input id="primarySubmit" type="hidden" value="save_edit" name="submitType" />
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a onclick="document.getElementById('primarySubmit').value='save_new'; document.getElementById('detail-form').submit();" href="javascript:void(0);">Save & Create Another</a>
                            </li>
                            <li>
                                <a onclick="document.getElementById('primarySubmit').value='save_close'; document.getElementById('detail-form').submit();" href="javascript:void(0);">Save & Close</a>
                            </li>
                        </ul>
                    </div>                          
                    &nbsp;
                    <a class="btn btn-default" href="./admin/mailer/blocks">Cancel</a>
                </div>

            </div>
            <!-- /.form-actions -->        
            
            <hr />    
    
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab-basics" data-toggle="tab">Block</a>
                </li>
              
            </ul>
            
            <div class="tab-content">

                <div class="tab-pane active" id="tab-basics">
                
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
				        <div class="form-group">
				            <label>Description - Information about when this email sends</label>
				             <input type="text" name="copy" placeholder="" value="<?php echo $flash->old('copy'); ?>" class="form-control" />
				        </div>
				        
				        <div class="form-group">
				            <label>Key</label>
				            <input type="text" name="key" placeholder="" value="<?php echo $flash->old('key'); ?>" class="form-control" />
				            <p class="help-block"> This is the key that goes in the email in brackets</p>
				        </div>
				        <!-- /.form-group -->
				                 
				        <div class="form-group">
				            <label>BLOCK HTML</label>
				            <textarea name="content" class="form-control wysiwyg"><?php echo $flash->old('content'); ?></textarea>
				        </div>
				        <!-- /.form-group -->
				        
				    </div>
				    <!-- /.col-md-10 -->
				    
				</div>
				<!-- /.row -->
				
				<hr />
                
                </div>
                <!-- /.tab-pane -->
               
              
                
            </div>
            
        </div>

    </div>
</form>

</div>
