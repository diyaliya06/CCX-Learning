<?php
session_start();
include '../connect.php';

if (isset($_SESSION['user_id']) && isset($_POST['course']) && isset($_POST['video_id'])) {
    $user_id = $_SESSION['user_id'];
    $course = $_POST['course'];
    $video_id = $_POST['video_id'];

    // Check if user has already watched this video
    $checkQuery = "SELECT * FROM video_watch_log WHERE user_id='$user_id' AND course='$course' AND video_id='$video_id'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        // Insert new watch record
        $insertQuery = "INSERT INTO video_watch_log (user_id, course, video_id) VALUES ('$user_id', '$course', '$video_id')";
        if (mysqli_query($con, $insertQuery)) {
            // Check total videos watched
            $countQuery = "SELECT COUNT(*) as total FROM video_watch_log WHERE user_id='$user_id' AND course='$course'";
            $countResult = mysqli_query($con, $countQuery);
            $countRow = mysqli_fetch_assoc($countResult);
            $totalVideos = $countRow['total'];

            // Determine Badge
            $badge = "";
            if ($totalVideos == 1) $badge = "Beginner";
            else if ($totalVideos == 5) $badge = "Expert";
            else if ($totalVideos == 10) $badge = "Mastery";

            if ($badge !== "") {
                // Insert or Update Badge
                $badgeQuery = "INSERT INTO badges (user_id, course, badge) VALUES ('$user_id', '$course', '$badge') ON DUPLICATE KEY UPDATE badge='$badge'";
                if (mysqli_query($con, $badgeQuery)) {
                    echo "success";
                } else {
                    echo "Error inserting badge: " . mysqli_error($con);
                }
            } else {
                echo "success";
            }
        } else {
            echo "Error inserting watch log: " . mysqli_error($con);
        }
    } else {
        echo "Already watched";
    }
} else {
    echo "Missing parameters or user not logged in";
}
?>
