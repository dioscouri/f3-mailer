<?php $settings = \Mailer\Models\Settings::fetch(); ?>

<div class="row">
    <div class="col-md-2">
        
        <h3>Settings</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
    
        <div class="form-group">
            <label>From Name</label>
            <input type="text" name="from_name" placeholder="e.g. MyDomain.com" value="<?php echo $flash->old('from_name'); ?>" class="form-control" />
            <p class="help-block">Leave blank to use the default, which is currently: <?php echo $settings->{'general.from_name'} ? $settings->{'general.from_name'} : 'n/a'; ?></p>
        </div>
        <!-- /.form-group -->
                 
        <div class="form-group">
            <label>From Email</label>
            <input type="text" name="from_email" placeholder="e.g. noreply@mydomain.com" value="<?php echo $flash->old('from_email'); ?>" class="form-control" />
            <p class="help-block">Leave blank to use the default, which is currently: <?php echo $settings->{'general.from_email'} ? $settings->{'general.from_email'} : 'n/a'; ?></p>
        </div>
        <!-- /.form-group -->
         <div class="form-group">
            <label>Carbon Copy (CC)</label>
            <input type="text" name="cc" placeholder="e.g. noreply@mydomain.com" value="<?php echo $flash->old('cc'); ?>" class="form-control" />
            <p class="help-block">If Used will CC an email address</p>
        </div>
        <!-- /.form-group -->
         <div class="form-group">
            <label>Blind Carbon Copy (BCC)</label>
            <input type="text" name="bcc" placeholder="e.g. noreply@mydomain.com" value="<?php echo $flash->old('bcc'); ?>" class="form-control" />
            <p class="help-block">if not empty will BCC email addresses</p>
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            <label>Reply To (Email)</label>
            <input type="text" name="replyto_email" placeholder="e.g. noreply@mydomain.com" value="<?php echo $flash->old('replyto_email'); ?>" class="form-control" />
            <p class="help-block">Sets reply too email</p>
        </div>
        <!-- /.form-group -->
          <div class="form-group">
            <label>Reply To (Name)</label>
            <input type="text" name="replyto_name" placeholder="e.g. noreply@mydomain.com" value="<?php echo $flash->old('replyto_name'); ?>" class="form-control" />
            <p class="help-block">Sets reply too name</p>
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<hr />



