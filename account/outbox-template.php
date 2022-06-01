
<div>
    <div>
        <p>You Messaged: <?php echo $sender." - ".$date ?></p>
    </div>
    
    <div>
        <button onclick="document.getElementById('<?php echo $messageId; ?>').style.display = 'block'; this.style.display = 'none';">View Message</button>
    </div>


    <div id="<?php echo $messageId; ?>" style="display: none;">
        <div>
            <p><?php echo $title ?></p>
        </div>
        <div>
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
            
            // this doesn't work ^^^ VVVV
            while($reply = mysqli_fetch_assoc($replies)){
                $title = $reply["subject"];
                $sender = $reply["user_to"];
                $date = date("d/m/Y", $reply["date"]);
                $id = $reply["id"];
                $text = $reply["message"];
            
                $replyId = "reply-outbox-".$replyCounter;
            
                // work on this
                require "reply-template.php";
            
                $replyCounter++;
            }
            $id = $message["id"];
        ?>

        <?php
            if($recepientDelete == 1){
                ?>
                    <p>The recepient has delete their message from their inbox. You can no longer reply to this message.</p>
                <?php
            } else {
                ?>
                    <div>
                        <button onclick="document.getElementById('<?php echo $replyFieldId; ?>').style.display = 'block'; this.style.display = 'none';">Reply</button>
                    </div>
            
                    <div id="<?php echo $replyFieldId ?>" style="display: none;">
                        <h3>Reply to this user's Message</h3>
                        <form method="POST" action="includes/send-reply.inc.php">
                            <input name="recepient" value="<?php echo $sender; ?>" type="hidden">
                            <input name="sender" value="<?php echo $_SESSION["username"] ?>" type="hidden">
                            <input name="subject" value="<?php echo $title; ?>" type="hidden">
                            <input name="reply-to" value="<?php echo $id ?>" type="hidden">
            
                            <textarea name="message" rows="7" cols="55" maxlength="500"></textarea>
                            <button type="submit" name="submit">Reply</button>
                        </form>
                    </div>
                <?php
            }
        ?>
    </div>
</div>
