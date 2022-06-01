<?php
// create a div of comments here
// this is gonna take some time to do

require "includes/dbh.inc.php";

$sql = "SELECT * FROM comments WHERE parent=?";
$stmt = mysqli_stmt_init($connection);

if(!mysqli_stmt_prepare($stmt, $sql)){
    echo "unable to display comments";
    return;
} else {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

$comments = mysqli_stmt_get_result($stmt);
$commentCounter = 0;


// figure out why it only prints one comment
// for each comment, display all its replies
while($comment = mysqli_fetch_assoc($comments)){
    $commentId = $comment["id"];
    $owner = $comment["owner"];
    $text = $comment["text"];
    $date = $comment["date"];

    $profilePic = "images/profile-pic.png";

    $sql = "SELECT * FROM accounts WHERE username=?";
    $stmt = mysqli_stmt_init($connection);
    
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

    $replyIdName = "reply-".$commentCounter;
    // continue styling these
    // then style replies
    ?>
    <div class="w-75">
        <div class="ml-2">
            <div>
                <img src="<?php echo $profilePic; ?>" width="60" class="rounded-circle m-2" style="vertical-align: middle;"><?php echo $owner; ?> Commented: 
                <span class="ml-5">Date Posted: <?php echo date("d/m/Y", $date); ?></span>
            </div>
            
            <p class="m-3"><?php echo $text; ?></p>
            
        </div>
        
        <!-- move view replies button to view-replies page and make it so that if there are no replies, don't show the reply button -->

        <?php 
            require "listing/view-replies.php";
        ?>
        <hr class="dark">
    </div>
    <?php
    $commentCounter++;
}
// change php code to display everything instead
// use javascript buttons to show/hide elements to make it look nicer in the long run
// it's ugly as fuck


// ok so i should work on a mailbox system
// create a database 
// create an inbox page to see all the messages
// add feature that allows user to reply to emails again and again
// delete message feature
// view chat thread
// this should take a week or two to figure out
// add mesage me button on view-listings page with a form that shows/hides

?>