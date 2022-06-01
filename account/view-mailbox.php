
<!-- add borders here instead -->
<main>
    <div class="container-fluid padding m-3">
        <div class="row welcome text-center">
            <div class="col-12">
                <h1 class="display-4">Mailbox</h2>
            </div>
        </div>
    </div>

    <div class="row jumbotron">
        <div class="col-6 text-dark border-right border-dark">
            <div>
                <h1>Inbox</h1>
            </div>
			<hr class="dark">

            <div class="accordion">
                <?php
                // turn this into an accordion instead
                require "includes/dbh.inc.php";

                $username = $_SESSION["username"];

                $sql = "SELECT * FROM messages WHERE user_to=? AND reply_to IS NULL";
                $stmt = mysqli_stmt_init($connection);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "Unable to display inbox...:(";
                    return;
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                }
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result) == 0){
                    echo "You have no new replies...";
                    echo "Wow! Such empty:)";
                }
                $messageCounter = 0;

                while($message = mysqli_fetch_assoc($result)){
                    if($message["recepient_delete"] == 1){
                        continue;
                    }

                    $title = $message["subject"];
                    $sender = $message["user_from"];
                    $date = date("d/m/Y", $message["date"]);
                    $id = $message["id"];
                    $text = $message["message"];
                    $senderDelete = $message["sender_delete"];

                    $messageId = "message-inbox-".$messageCounter;
                    $replyFieldId = "message-inbox-reply-".$messageCounter;
                    require "inbox-template.php";

                    // style the inbox divs to look like accordions

                    $messageCounter++;
                }
                // add a thing for replies
                ?>
            </div>
            

        </div>

        <div class="col-6 text-dark border-left border-dark">
            <div>
                <h1>Outbox</h1>
            </div>
            
			<hr class="dark">

            <?php
            require "includes/dbh.inc.php";

            $username = $_SESSION["username"];

            $sql = "SELECT * FROM messages WHERE user_from=? AND reply_to IS NULL";
            $stmt = mysqli_stmt_init($connection);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo "Unable to display outbox:(";
                return;
            } else {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
            }
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 0){
                echo "You have sent no new messages...";
                echo "Wow! Such empty:)";
            }
            $messageCounter = 0;
            while($message = mysqli_fetch_assoc($result)){
                if($message["sender_delete"] == 1){
                    continue;
                }

                $title = $message["subject"];
                $sender = $message["user_to"];
                $date = date("d/m/Y", $message["date"]);
                $id = $message["id"];
                $text = $message["message"];
                $recepientDelete = $message["recepient_delete"];

                $messageId = "message-outbox-".$messageCounter;
                $replyFieldId = "message-outbox-reply-".$messageCounter;

                // this is 1
                require "outbox-template.php";

                ?>

                    <form method="POST" action="includes/delete-message.inc.php">
                        <input name="id" value="<?php echo $id; ?>" type="hidden">
                        <input name="subject" value="<?php echo $title ?>" type="hidden">
                        <input name="user" value="<?php echo $username ?>" type="hidden">

                        <button type="submit" name="submit" type="hidden">X</button>
                    </form>

                <?php

                $messageCounter++;
            }
            ?>
        </div>
    </div>

</main>

