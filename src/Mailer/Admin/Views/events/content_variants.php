<div class="row">
    <div class="col-md-2">
        
        <h3>Versions</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
    
    <?php $variants = (new \Mailer\Models\ContentVariants)->setCondition('event_id', new \MongoId((string) $flash->old('_id')))->getList(); ?>
    
    <a class="btn btn-info" href="/admin/mailer/contentvariants/quickadd/<?php echo $flash->old('_id'); ?>">Create New Email Variant</a>
        <table>
        <thead>
	        <td>Title</td>
	        <td></td>
	        <td></td>
        </thead>
        <?php if(count($variants)) : ?>
       <?php foreach ($variants as $variant) : ?>
       <tr>
       <td><a href="/admin/mailer/contentvariant/edit/<?php echo  $variant->id?>"><?php echo  $variant->title?></a></td>
       <td></td>
       <td></td>
       </tr>
       <?php endforeach?>
       
        <?php endif; ?>
        
        </table>
        
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<hr />



