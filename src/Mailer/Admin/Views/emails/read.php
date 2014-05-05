<div class="well">

<form id="detail-form" class="form" method="post">

    <div class="clearfix">

        <div class="pull-right">
            <a class="btn btn-default" href="/admin/mailer/emails">Cancel</a>
        </div>

    </div>
    
    <hr />
    <!-- /.form-actions -->
    
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#tab-basics" data-toggle="tab"> Basics </a>
        </li>
        <?php if (!empty($this->event)) { foreach ((array) $this->event->getArgument('tabs') as $key => $title ) { ?>
        <li>
            <a href="#tab-<?php echo $key; ?>" data-toggle="tab"> <?php echo $title; ?> </a>
        </li>
        <?php } } ?>                
    </ul>
    
    <div class="tab-content padding-10">
    
        <div class="tab-pane active" id="tab-basics">
        
            <?php //echo $this->renderLayout('Mailer/Admin/Views::emails/fields_basics.php'); ?>
            
            <?php echo \Dsc\Debug::dump( $item ); ?>
        
        </div>
        <!-- /.tab-pane -->
        
        <?php if (!empty($this->event)) { foreach ((array) $this->event->getArgument('content') as $key => $content ) { ?>
        <div class="tab-pane" id="tab-<?php echo $key; ?>">
            <?php echo $content; ?>
        </div>
        <?php } } ?>
        <!-- /.tab-pane -->
    
    </div>
</form>

</div>