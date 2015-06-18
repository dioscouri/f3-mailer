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
                    <a class="btn btn-default" href="./admin/mailer/events">Cancel</a>
                </div>

            </div>
            <!-- /.form-actions -->        
            
            <hr />    
    
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab-basics" data-toggle="tab"> Basics </a>
                </li>
                <li>
                    <a href="#tab-pricinginventory" data-toggle="tab"> Settings </a>
                </li>
                <li>
                    <a href="#tab-variants" data-toggle="tab">Content Variants </a>
                </li>
            </ul>
            
            <div class="tab-content">

                <div class="tab-pane active" id="tab-basics">
                
                    <?php echo $this->renderLayout('Mailer/Admin/Views::events/fields_basics.php'); ?>
                
                </div>
                <!-- /.tab-pane -->
                
                <div class="tab-pane" id="tab-pricinginventory">

                    <?php echo $this->renderLayout('Mailer/Admin/Views::events/fields_settings.php'); ?>
                                        
                </div>
                <!-- /.tab-pane -->
                
                <div class="tab-pane" id="tab-variants">

                    <?php echo $this->renderLayout('Mailer/Admin/Views::events/content_variants.php'); ?>
                                        
                </div>
              
                
            </div>
            
        </div>

    </div>
</form>

</div>
