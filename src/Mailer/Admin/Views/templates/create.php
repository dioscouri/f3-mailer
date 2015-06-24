<script>
jQuery(document).ready(function(){
    CKEDITOR.replaceAll( 'wysiwyg' );    
});
</script>

<div class="well">

<form id="detail-form" class="form" method="post">

    <div class="clearfix">

        <div class="pull-right">
            <a class="btn btn-default" href="./admin/mailer/templates">Cancel</a>
        </div>

    </div>
    
    <hr />
    <!-- /.form-actions -->

    <h2>Select an Email Event</h2>
    <p class="help-block">We'll create the default template for you, then you can customize it.</p>
    
    <?php
    foreach (\Mailer\Models\Events::find() as $event) {
        ?>
        <hr/>
        
        <div class="form-group">
            <div class="clearfix">
                <a class="btn btn-default pull-right" href="./admin/mailer/template/create/<?php echo $event->id; ?>">Create a New Template for this Event</a>
                <p><?php echo $event->title; ?></p>
                <?php if ($event->copy) { ?>
                <p class="help-block"><?php echo $event->copy; ?></p>
                <?php } ?>
            </div>            
        </div>
        
        <?php
    } 
    ?>                    			


</form>

</div>