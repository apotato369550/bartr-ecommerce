<div>
    <div>   
        <p><?php echo $sender." - ".$date ?> Replied</p>
    </div>
    
    <!-- style this button -->
    <div>
        <button onclick="document.getElementById('<?php echo $replyId; ?>').style.display = 'block'; this.style.display = 'none';">View Reply</button>
    </div>

    <div id="<?php echo $replyId; ?>" style="display: none;">
        <div>
            <p><?php echo $text; ?></p>
        </div>
    </div>

    <!-- test if this collapse works 

    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="<?php $replyId ?>" aria-expanded="false" aria-controls="collapseExample">
        View Reply
    </button>

    <div class="collapse" id="<?php echo $replyId ?>">
        <div class="card card-body">
            <p><?php echo $text; ?></p>
        </div>
    </div>
    -->
</div>
