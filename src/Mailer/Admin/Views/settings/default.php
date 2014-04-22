<div class="well">

<form id="settings-form" role="form" method="post" class="form-horizontal clearfix">

    <div class="clearfix">
        <button type="submit" class="btn btn-primary pull-right">Save Changes</button>
    </div>

    <hr />

    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4">
            <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="#tab-general" data-toggle="tab"> General Settings </a>
                </li>
                <li>
                    <a href="#tab-smtp" data-toggle="tab"> SMTP Settings </a>
                </li>                
                <li>
                    <a href="#tab-mandrill" data-toggle="tab"> Mandrill Settings </a>
                </li>                
            </ul>
        </div>

        <div class="col-lg-10 col-md-9 col-sm-8">

            <div class="tab-content stacked-content">

                <div class="tab-pane fade in active" id="tab-general">
                    <h4>General Settings</h4>
                    
                    <hr />
                    
                    <div class="form-group">
                        <label>Default Sender</label>
                        <select name="general[sender]" class="form-control">
                            <option value="\Mailer\Senders\Mail" <?php if ($flash->old('general.sender') == '\Mailer\Senders\Mail') { echo "selected='selected'"; } ?>>PHP Mail</option>
                            <option value="\Mailer\Senders\Smtp" <?php if ($flash->old('general.sender') == '\Mailer\Senders\Smtp') { echo "selected='selected'"; } ?>>SMTP</option>
                            <option value="\Mailer\Senders\Sendmail" <?php if ($flash->old('general.sender') == '\Mailer\Senders\Sendmail') { echo "selected='selected'"; } ?>>Sendmail</option>
                            <option value="\Mailer\Senders\Mandrill" <?php if ($flash->old('general.sender') == '\Mailer\Senders\Mandrill') { echo "selected='selected'"; } ?>>Mandrill</option>
                        </select>                        
                    </div>
                    <!-- /.form-group -->                    
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>"From" Name</label>
                                <input name="general[from_name]" placeholder="Usually your site's name" value="<?php echo $flash->old('general.from_name'); ?>" class="form-control" type="text" />
                            </div>
                            <div class="col-md-6">
                                <label>"From" Email Address</label>
                                <input name="general[from_email]" placeholder="The email address that the system will send from by default" value="<?php echo $flash->old('general.from_email'); ?>" class="form-control" type="text" />
                            </div>                            
                        </div>
                    </div>
                    <!-- /.form-group -->                    

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Asynchronous Sending?</label>
                                <select name="general[async]" class="form-control">
                                    <option value="0" <?php if ($flash->old('general.async') == '0') { echo "selected='selected'"; } ?>>No</option>
                                    <option value="1" <?php if ($flash->old('general.async') == '1') { echo "selected='selected'"; } ?>>Yes</option>
                                </select>
                                <p class="help-block">Select 'No' to have emails send immediately.</p>
                            </div>
                            <div class="col-md-9">
                                <div class="alert alert-warning">
                                    <b>Important:</b> You must add a cron job for asynchronous sending to work.  If you enable this and do not have a cron job, emails will not be sent.
                                    <div>/path/to/cron/job.php</div>
                                </div>
                                
                            </div>                            
                        </div>
                    </div>
                    <!-- /.form-group -->
                </div>
                
                <div class="tab-pane fade" id="tab-smtp">
                    <h4>SMTP Settings</h4>
                    
                    <hr />
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5">
                                <label>SMTP Host</label>
                                <input name="smtp[smtp_host]" placeholder="mail.example.com" value="<?php echo $flash->old('smtp.smtp_host'); ?>" class="form-control" type="text" />
                            </div>
                            <div class="col-md-2">
                                <label>SMTP Port</label>
                                <input name="smtp[smtp_port]" placeholder="Usually 25, 465, or 587" value="<?php echo $flash->old('smtp.smtp_port'); ?>" class="form-control" type="text" />
                            </div>
                            <div class="col-md-5">
                                <label>SMTP Username</label>
                                <input name="smtp[smtp_username]" placeholder="SMTP Username" value="<?php echo $flash->old('smtp.smtp_username'); ?>" class="form-control" type="text" />
                            </div>
                        </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>SMTP Password</label>
                                <input name="smtp[smtp_password]" placeholder="SMTP Password" value="<?php echo $flash->old('smtp.smtp_password'); ?>" class="form-control" type="text" />                              
                            </div>
                            <div class="col-md-9">
                                                                
                            </div>
                        </div>                        
                    </div>
                    <!-- /.form-group -->                    
                </div>
                
                <div class="tab-pane fade" id="tab-mandrill">
                    <h4>Mandrill Settings</h4>
                    
                    <hr />
                    
                    <div class="alert alert-info"><p>If you only want to enable Mandrill's API-based sending, do not provide SMTP credentials below.  Only enter an API Key.  If you provide both an API Key and SMTP credentials, only the API Key will be used.</p></div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>API Key</label>
                                <input name="mandrill[api_key]" placeholder="API Key" value="<?php echo $flash->old('mandrill.api_key'); ?>" class="form-control" type="text" />
                                <p class="help-block">
                                    Login to <a href="http://mandrillapp.com" target="_blank">http://mandrillapp.com</a> to create or retrieve your API Key. 
                                </p>                                
                            </div>
                            <div class="col-md-9">
                                
                            </div>                            
                        </div>
                    </div>
                    <!-- /.form-group -->
                    
                    <div class="alert alert-info"><p>If you only want to enable SMTP sending via Mandrill, do not enter an API Key above. Only provide SMTP credentials below.</p></div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5">
                                <label>SMTP Host</label>
                                <input name="mandrill[smtp_host]" placeholder="Usually smtp.mandrillapp.com" value="<?php echo $flash->old('mandrill.smtp_host'); ?>" class="form-control" type="text" />
                            </div>
                            <div class="col-md-2">
                                <label>SMTP Port</label>
                                <input name="mandrill[smtp_port]" placeholder="Usually 587" value="<?php echo $flash->old('mandrill.smtp_port'); ?>" class="form-control" type="text" />
                            </div>
                            <div class="col-md-5">
                                <label>SMTP Username</label>
                                <input name="mandrill[smtp_username]" placeholder="SMTP Username" value="<?php echo $flash->old('mandrill.smtp_username'); ?>" class="form-control" type="text" />
                            </div>
                        </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>SMTP Password</label>
                                <input name="mandrill[smtp_password]" placeholder="SMTP Password" value="<?php echo $flash->old('mandrill.smtp_password'); ?>" class="form-control" type="text" />
                                <p class="help-block">
                                    Login to <a href="http://mandrillapp.com" target="_blank">http://mandrillapp.com</a> to create or retrieve your SMTP Password, which is just any valid API Key. 
                                </p>                                
                            </div>
                            <div class="col-md-9">
                                                                
                            </div>
                        </div>                        
                    </div>
                    <!-- /.form-group -->                    
                    
                </div>                
                
            </div>

        </div>
    </div>

</form>

</div>