<div class="row">
   
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
    
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" placeholder="Title" value="<?php echo $flash->old('title'); ?>" class="form-control" required />
            <p class="help-block">Admin Only</p>
        </div>
        <!-- /.form-group -->
                 
        <div class="form-group">
            <label>Description</label>
            <input type="text" name="copy" placeholder="Description for Admins Only" value="<?php echo $flash->old('copy'); ?>" class="form-control" />
            <p class="help-block">Optional.  Admin Only.</p>
        </div>
        <!-- /.form-group -->
            
        <?php if (!empty($item)) { ?>
            <?php 
            $event = $item->event();
            if (!empty($event->id)) {
                ?>
                <div class="form-group">
                    <label>Event</label>
                    <div class="panel panel-default panel-sm">
                        <div class="panel-body clearfix">
                            <?php if (!empty($item->id)) { ?>
                            <a class="btn btn-default pull-right" href="./admin/mailer/template/create/<?php echo $event->id; ?>">Create a New Template for this Event</a>
                            <?php } ?>
                            <p><?php echo $event->title; ?></p>
                            <?php if ($event->copy) { ?>
                            <p class="help-block"><?php echo $event->copy; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- /.form-group -->
                <?php
            }
            ?>
        <?php } ?>
        
        <hr/>
        
        <div class="form-group">
            <label>Email Subject</label>
            <input type="text" required name="event_subject" placeholder="Email Subject" value="<?php echo $flash->old('event_subject'); ?>" class="form-control" />
        </div>
        
         <div class="form-group">
            <label>Email Body - HTML Version</label>
            <textarea required name="event_html" class="form-control " rows="20"><?php echo $flash->old('event_html'); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Email Body - Text Version</label>
            <p class="help-block">Text-only alternatives should always be provided.</p>
            <textarea required name="event_text" class="form-control" rows="10"><?php echo $flash->old('event_text'); ?></textarea>
        </div>
        <!-- /.form-group -->
        
    </div>
    
    <!-- /.col-md-10 -->

    <div class="col-md-2">
        
        <h3>Blocks</h3>
      	<ul class="list-group">
        <?php foreach ((new \Mailer\Models\Blocks)->find() as $doc) :?>
        <li class="list-group-item">{{@<?php echo $doc['key']; ?>}}</li>
        <?php endforeach;?>
        </ul>
        
                
    </div>
    
</div>
<!-- /.row -->

<hr />



