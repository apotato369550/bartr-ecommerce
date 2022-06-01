<div class="card">
    <!-- copypaste the ting
    paste the ting
    -->
    <div class="card">
        <div class="card-header" id="headingOne">
        <h2 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Collapsible Group Item #1
            </button>
        </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>

    <div>
        <p><?php echo $sender." - ".$date ?> Messaged</p>
    </div>
    <div class="row">
        <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            View Message
        </button>
        <form method="POST" action="includes/delete-message.inc.php">
            <input name="id" value="<?php echo $id; ?>" type="hidden">
            <input name="subject" value="<?php echo $title ?>" type="hidden">
            <input name="user" value="<?php echo $username ?>" type="hidden">

            <button class="btn btn-secondary" type="submit" name="submit" type="hidden">X</button>
        </form>
    </div>



    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <div>
                <p><?php echo $title ?></p>
            </div>
            <div>
                <p><?php echo $text; ?></p>
            </div>

            <?php 
                require "includes/dbh.inc.php";

                // instead of having it all in one database, we'll create a separate database for message replies called message_replies
                // files to edit: 
                // this file
                // includes/send-reply.inc.php

                // change this sql query
                // $sql = "SELECT * FROM message_replies WHERE reply_to=? AND reply_to IS NOT NULL";
                
                // test this motherfucker lmao
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

                // make replies collapseable
                while($reply = mysqli_fetch_assoc($replies)){
                    $title = $reply["subject"];
                    $sender = $reply["user_from"];
                    $date = date("d/m/Y", $reply["date"]);
                    // it's coz it gets re-assigned hereeeeeeee
                    /// brehhhh
                    $id = $reply["id"];
                    $text = $reply["message"];
                
                    $replyId = "reply-inbox-".$replyCounter;

                    // work on this
                    require "reply-template.php";
                
                    $replyCounter++;
                }
                $id = $message["id"];

                // re-assign the value of id outside the while loopVVV

            ?> 

            
            <!-- 
                add a delete message feature
                after clicking, the user who deleted the message has the message disappear from their mailbox
                the user that he was messaging will notified that the user has deleted the message and can no longer reply to the thred
                if both users click delete, the message and the replies will be deleted from the database

                fairly complex, might be difficult to implement, but I have faith

                if sender deleted it, mention it here and dont show the reply box

                test the below function if it works
                // bruh i accidentally deleted it
                // retest it again
                // apply the thing for the outbox as well
            -->
            <?php 
                if($senderDelete == 1){
                    ?>
                        <p>The sender has deleted this message from their outbox. You can no longer reply to this message.</p>
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
</div>

