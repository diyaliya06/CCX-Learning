<?php
session_start(); 
include '../connect.php'; // Ensure DB connection file is included

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../main_copy.php"); 
    exit;
}

$user_id = $_SESSION['user_id'];
$subject = "PP";

// Fetch total watched videos for the user and course
$query = "SELECT COUNT(*) AS total_videos FROM video_watch_log WHERE user_id = $user_id AND course = '$subject'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$total_watched = $row['total_videos'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python Programming - Video Lectures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .video-card {
            margin-bottom: 20px;
        }
        .badge-message {
            font-size: 1.2rem;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>

    <!-- Include Header -->
    <//?php include '../header.php'; ?>

    <div class="container">
        <h1 class="mb-4 text-center">Python Programming - Video Lectures</h1>

        <div class="row">
            <!-- Video 1 -->
            <div class="col-md-6 video-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Introduction to Python</h5>
                        <iframe id="video1" width="100%" height="315" 
                            src="https://www.youtube.com/embed/kqtD5dpn9C8?enablejsapi=1" 
                            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            <!-- Video 2 -->
            <div class="col-md-6 video-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Python Data Types</h5>
                        <iframe id="video2" width="100%" height="315" 
                            src="https://www.youtube.com/embed/kqtD5dpn9C8?enablejsapi=1" 
                            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            <!-- Video 3 -->
            <div class="col-md-6 video-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Control Structures in Python</h5>
                        <iframe id="video3" width="100%" height="315" 
                            src="https://www.youtube.com/embed/Z1Yd7upQsXY?enablejsapi=1" 
                            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            <!-- Video 4 -->
            <div class="col-md-6 video-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Functions in Python</h5>
                        <iframe id="video4" width="100%" height="315" 
                            src="https://www.youtube.com/embed/NSbOtYzIQI0?enablejsapi=1" 
                            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Badge Message -->
        <div class="text-center mt-4">
            <p id="badgeMessage" class="badge-message"></p>
        </div>
    </div>

    <!-- YouTube Iframe API -->
    <script>
        let player1, player2, player3, player4;

        // Load YouTube Iframe API
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // Initialize players
        function onYouTubeIframeAPIReady() {
            player1 = new YT.Player('video1', { events: { 'onStateChange': onPlayerStateChange } });
            player2 = new YT.Player('video2', { events: { 'onStateChange': onPlayerStateChange } });
            player3 = new YT.Player('video3', { events: { 'onStateChange': onPlayerStateChange } });
            player4 = new YT.Player('video4', { events: { 'onStateChange': onPlayerStateChange } });
        }

        // Detect when a video ends
        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.ENDED) {
                let videoId = event.target.a.id;
                trackWatch("PP", videoId);
            }
        }

        // Track watch progress
        function trackWatch(course, videoId) {
            $.ajax({
                url: "track_watch.php",
                type: "POST",
                data: { course: course, video_id: videoId },
                success: function (response) {
                    console.log("Server Response: " + response);
                    if (response.includes("success")) {
                        console.log("✅ Watch logged!");
                        checkBadge(course);
                    } else {
                        console.log("⚠️ " + response);
                    }
                },
                error: function () {
                    console.log("⚠️ Error connecting to server.");
                }
            });
        }

        // Check and display badges
        function checkBadge(course) {
            $.ajax({
                url: "check_badge.php",
                type: "POST",
                data: { course: course },
                success: function (badge) {
                    if (badge) {
                        $("#badgeMessage").text(`🎉 ${badge} Badge Earned!`);
                    }
                },
                error: function () {
                    console.log("⚠️ Error fetching badge.");
                }
            });
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../footer.php'; ?>
</body>
</html>
