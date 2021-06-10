
<?php

// display replies regularly
$sql = "SELECT * FROM replies WHERE parent=?";
$stmt = mysqli_stmt_init($connection);

if(!mysqli_stmt_prepare($stmt, $sql)){
    echo "could not display replies";
} else {    
    mysqli_stmt_bind_param($stmt, "i", $commentId);
    mysqli_stmt_execute($stmt);
}

$replies = mysqli_stmt_get_result($stmt);
$replyRequestId = "reply-request-".$commentCounter;
    // style this below
?>

<!-- it works -->
<?php 
if(isset($_SESSION["username"])){
    ?>
        <div class="d-flex">
            <button 
                onclick="document.getElementById('<?php echo $replyRequestId ?>').style.display = 'block'; this.style.display = 'none'" 
                class="btn btn-outline-dark btn-m m-2"
            >
            Reply
            </button>
            <?php 
                if(mysqli_num_rows($replies) > 0){
                    $repliesViewId = "replies-view-".$commentCounter;
                    ?>  
                        <div class="text-right">
                            <button 
                                onclick="document.getElementById('<?php echo $repliesViewId; ?>').style.display = 'block'; this.style.display = 'none'" 
                                class="btn btn-secondary btn-m m-2"
                            >
                            View Replies
                            </button>
                        </div>
                    <?php
                }
            ?>
        </div>

        <div id="<?php echo $replyRequestId; ?>" style="display: none;"> 
            <form method="POST" action="includes/create-reply.inc.php">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="hidden" name="title" value="<?php echo $title ?>">

                <input type="hidden" name="username" value="<?php echo $_SESSION["username"] ?>">
                <input type="hidden" name="comment-id" value="<?php echo $commentId ?>">
                <input type="hidden" name="title" value="<?php echo $title ?>">

                <img src="<?php echo $profilePic ?>" width="60" alt="Profile Picture" class="rounded-circle m-1">
                <textarea name="reply" rows="2" cols="55" maxlength="500" placeholder="Say Something..." style="vertical-align: middle;"></textarea>
                <button type="submit" class="btn btn-outline-dark btn-m">Reply</button>
            </form>
        </div>
    <?php
}
if(mysqli_num_rows($replies) == 0){
    return;
}
// fix the reply boxes
?> 
    <div id="<?php echo $repliesViewId; ?>" class="replies w-50 ml-5" style="display: none;">
<?php

while($reply = mysqli_fetch_assoc($replies)){
    $owner = $reply["owner"];
    $text = $reply["text"];
    $date = $reply["date"];

    $profilePic = "images/profile-pic.png";

    $sql = "SELECT * FROM accounts WHERE username=?";
    $stmt = mysqli_stmt_init($connection);
    
    // the problem is with this if statement
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $owner);
        mysqli_stmt_execute($stmt);
        $userResult = mysqli_stmt_get_result($stmt);

        if($user = mysqli_fetch_assoc($userResult)){
            $image = $user["profile_picture"];
            if(!empty($image)){
                $profilePic = "uploads/profile-pictures/".$image;
            }
        }
    } 
    // style this as well
    ?>
    <div>
        <div class="reply">
            <hr class="dark">
            <div>
                <img src="<?php echo $profilePic; ?>" width="60" class="rounded-circle m-2" style="vertical-align: middle;"><?php echo $owner; ?> Replied: 
                <span class="ml-5">Date Posted: <?php echo date("d/m/Y", $date); ?></span>
            </div>
            <p class="m-3"><?php echo $text; ?></p>
        </div>
    </div>
    <?php
}

// start working on mailbox system
?> 
    </div>
<?php

