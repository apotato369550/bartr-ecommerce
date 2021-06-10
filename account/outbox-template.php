<div class="card pl-4 pr-2 pt-2 pb-2">
    <!-- work on this-->


    <div class="row p-1">
        <div>
            <p>You Messaged: <?php echo $sender." - ".$date ?></p>
        </div>
        <button class="btn btn-secondary ml-5" type="button" data-toggle="collapse" data-target="#<?php echo $messageId ?>" aria-expanded="false" aria-controls="<?php echo $messageId ?>">
            View Message
        </button>
        <form method="POST" action="includes/delete-message.inc.php">
            <input name="id" value="<?php echo $id; ?>" type="hidden">
            <input name="subject" value="<?php echo $title ?>" type="hidden">
            <input name="user" value="<?php echo $username ?>" type="hidden">

            <button class="btn btn-secondary ml-2" type="submit" name="submit" type="hidden">X</button>
        </form>
    </div>



    <div class="collapse mt-3" id="<?php echo $messageId; ?>">
        <div class="card card-body">
            <div>
                <h2><?php echo $title ?></p>
                <p><?php echo $text; ?></p>
            </div>
            <?php 
                // test if the "can't reply" thing can be seen
                require "includes/dbh.inc.php";

                $sql = "SELECT * FROM message_replies WHERE reply_to=? AND subject=?";
                $stmt = mysqli_stmt_init($connection);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "could not get replies";
                    return;
                } else {
                    mysqli_stmt_bind_param($stmt, "is", $id, $title);
                    mysqli_stmt_execute($stmt);
                }

                $replies = mysqli_stmt_get_result($stmt);


                if(mysqli_num_rows($replies) == 0){
                    echo "You have sent no new replies...";
                } 
                
                $replyCounter = 0;
                
                // work on replies
                while($reply = mysqli_fetch_assoc($replies)){
                    $title = $reply["subject"];
                    $sender = $reply["user_from"];
                    $date = date("d/m/Y", $reply["date"]);
                    $id = $reply["id"];
                    $text = $reply["message"];
                
                    $replyId = "reply-outbox-".$replyCounter;
                
                    // work on this
                    require "reply-template.php";
                
                    $replyCounter++;
                }
                $id = $message["id"];
                if($recepientDelete == 1){
                    ?>
                        <h4 class="m-2">The recepient has delete their message from their inbox. You can no longer reply to this message.</h4>
                    <?php
                } else {
                    // work on thisVVV
                    ?>
                        <button class="btn btn-secondary m-3" type="button" data-toggle="collapse" data-target="#<?php echo $replyFieldId ?>" aria-expanded="false" aria-controls="<?php echo $replyFieldId ?>">
                            Reply
                        </button>

                        <div class="collapse" id="<?php echo $replyFieldId ?>">
                            <div class="card card-body">
                                <form method="POST" action="includes/send-reply.inc.php">
                                    <input name="recepient" value="<?php echo $sender; ?>" type="hidden">
                                    <input name="sender" value="<?php echo $_SESSION["username"] ?>" type="hidden">
                                    <input name="subject" value="<?php echo $title; ?>" type="hidden">
                                    <input name="reply-to" value="<?php echo $id ?>" type="hidden">

                                    <div class="text-center">
                                        <h3>Reply to this user's Message</h3>
                                        <textarea name="message" rows="10" cols="75" maxlength="500"></textarea>
                                        <br>
                                        <button type="submit" name="submit" class="btn btn-dark">Reply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>

    </div>
</div>
