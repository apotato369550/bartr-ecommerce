<div class="card">
    <div class="row p-2 pl-4">   
        <p><?php echo $sender." - ".$date ?> Replied</p>
        <button class="btn btn-secondary ml-4" type="button" data-toggle="collapse" data-target="#<?php echo $replyId ?>" aria-expanded="false" aria-controls="<?php echo $replyId ?>">
            View Reply
        </button>
    </div>


    <!-- I am very happy with this:))) style the outbox-->


    <div class="collapse" id="<?php echo $replyId ?>">
        <div class="card card-body">
            <p><?php echo $text; ?></p>
        </div>
    </div>
</div>
