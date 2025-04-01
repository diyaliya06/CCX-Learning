<?php
include('connect.php');
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCX Learning Platform</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3ccde7;
        }

        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .ccx-navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .course-card {
            transition: transform 0.3s;
            border-radius: 15px;
        }

        .course-card:hover {
            transform: translateY(-5px);
        }

        #chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            z-index: 1000;
            display: none;
            /* Initially hidden */
        }

        .playground-editor {
            height: 400px;
            border: 2px solid var(--primary-color);
            border-radius: 8px;
        }

        .user-message {
            text-align: right;
            margin-bottom: 5px;
            padding: 8px;
            background-color: #e0f7fa;
            border-radius: 5px;
        }

        .chatbot-message {
            text-align: left;
            margin-bottom: 5px;
            padding: 8px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar ccx-navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="logo.jpg" alt="CCX Logo" width="120">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#courses">Courses</a></li>
                <li class="nav-item"><a class="nav-link" href="#playground">Playground</a></li>
                <li class="nav-item"><a class="nav-link" href="#badges">Badges</a></li>

                <?php session_start(); ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Show user name when logged in -->
                    <li class="nav-item">
                    Welcome, <?php echo isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Guest'; ?>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="backend.php?logout=true">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Show login button if not logged in -->
                    <li class="nav-item">
                        <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


    <!-- Home Section -->
    <section id="home" class="container my-5 text-center">
        <h1>Welcome to CCX Learning Platform</h1>
        <p>Your gateway to mastering skills and achieving your career goals.</p>
        <img src="home-banner.png" alt="Learning Banner" class="img-fluid rounded my-4">
        <a href="#courses" class="btn btn-primary btn-lg">Explore Courses</a>

    </section>


    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">CCX Learning Portal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                <form id="loginForm" method="POST" action="backend.php">
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="loginEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="login">Sign In</button>
                </form>


                    <div class="text-center mt-3">
                        <p>Don't have an account?
                            <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">         
    <div class="modal-dialog">             
        <div class="modal-content">                 
            <div class="modal-header">                     
                <h5 class="modal-title" id="registerModalLabel">Register for CCX</h5>                     
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                 
            </div>                 
            <div class="modal-body">                                  
                <form id="registerForm" method="POST" action="backend.php">                     
                    <div class="mb-3">                         
                        <label for="registerFullName" class="form-label">Full Name</label>                         
                        <input type="text" class="form-control" id="registerFullName" name="fullName" required>                     
                    </div>                     
                    <div class="mb-3">                         
                        <label for="registerEmail" class="form-label">Email</label>                         
                        <input type="email" class="form-control" id="registerEmail" name="email" required>                     
                    </div>                     
                    <div class="mb-3">                         
                        <label for="registerPassword" class="form-label">Password</label>                         
                        <input type="password" class="form-control" id="registerPassword" name="password" required>                     
                    </div>                     
                    <button type="submit" class="btn btn-success w-100" name="register">Register</button>                 
                </form>                       
                <div class="text-center mt-3">                         
                    <p>Already have an account?                             
                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>                         
                    </p>                     
                </div>                 
            </div>             
        </div>         
    </div>     
</div>
    <!-- Courses Section -->
<section id="courses" class="container my-5">
    <h2 class="text-center mb-4">Available Courses</h2>

    <div class="row g-4">
        <div class="col-md-4 col-lg-3">
            <div class="card course-card h-100">
                <div class="card-body">
                    <h5 class="card-title">Object-Oriented Programming using Java</h5>
                    <p class="card-text">Learn OOP concepts with Java, covering encapsulation, inheritance, and polymorphism.</p>
                    <a href="oopj" class="btn btn-primary enroll-btn">Enroll Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-3">
            <div class="card course-card h-100">
                <div class="card-body">
                    <h5 class="card-title">System Software</h5>
                    <p class="card-text">Understand system software, including compilers, assemblers, and linkers.</p>
                    <a href="ss" class="btn btn-primary enroll-btn">Enroll Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-3">
            <div class="card course-card h-100">
                <div class="card-body">
                    <h5 class="card-title">Database Management System</h5>
                    <p class="card-text">Explore database concepts, SQL, and relational database management systems.</p>
                    <a href="dbms" class="btn btn-primary enroll-btn">Enroll Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-3">
            <div class="card course-card h-100">
                <div class="card-body">
                    <h5 class="card-title">Computer Architecture</h5>
                    <p class="card-text">Understand the structure and design of computer hardware and systems.</p>
                    <a href="ca" class="btn btn-primary enroll-btn">Enroll Now</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-md-4 col-lg-3">
            <div class="card course-card h-100">
                <div class="card-body">
                    <h5 class="card-title">Python Programming</h5>
                    <p class="card-text">Master Python with real-world projects.</p>
                    <a href="pp" class="btn btn-primary enroll-btn">Enroll Now</a>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Playground Section -->
    <section id="playground" class="py-5">
        <div class="container">
            <h2 class="mb-4">CCX Python Playground</h2>
            <iframe src="https://trinket.io/embed/python3" class="w-100 playground-iframe"
                style="height: 500px; border: none;" allowfullscreen>
            </iframe>
        </div>
    </section>

    <!-- Chatbot Toggle Button -->
    <div class="d-flex justify-content-center p-3">
        <button id="chatbot-toggle" class="btn btn-warning">
            Ask CCX Chatbot
        </button>
    </div>
    <!-- Chatbot -->
    <div id="chatbot-container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                CCX Learning Assistant
                <button class="btn btn-sm btn-light float-end" id="close-chat">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="card-body">
                <div id="chat-messages" class="mb-3" style="height: 200px; overflow-y: auto"></div>
                <div class="input-group">
                    <input type="text" class="form-control" id="chat-input" placeholder="Ask me something...">
                    <button id="send-btn" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Badges Section -->
    <section id="badges" class="container my-5">
        <h2 class="text-center mb-4">Achievements & Badges</h2>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="card p-3">
                    <i class="fas fa-medal fa-3x text-warning"></i>
                    <h5 class="mt-3">Beginner Badge</h5>
                    <p>Earned for completing your first course.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <i class="fas fa-trophy fa-3x text-primary"></i>
                    <h5 class="mt-3">Expert Badge</h5>
                    <p>Earned for completing 5 advanced courses.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <i class="fas fa-award fa-3x text-success"></i>
                    <h5 class="mt-3">Mastery Badge</h5>
                    <p>Earned for mastering a specialization.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-auto">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <h5>CCX Learning Platform</h5>
                    <p>Empowering learners through quality education</p>
                    <p>Developed by Diya & Ananya</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>&copy; 2025 CCX. All rights reserved</p>
                    <div class="social-icons">
                        <a href="#" class="text-white mx-2"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="text-white mx-2"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Chatbot functionality
            $('#chatbot-toggle').click(function () {
        $('#chatbot-container').slideToggle();
    });

    $('#close-chat').click(function () {
        $('#chatbot-container').slideUp();
    });

    $('#send-btn').click(function () {
        var userMessage = $('#chat-input').val().toLowerCase().trim();
        $('#chat-messages').append('<div class="user-message">' + userMessage + '</div>');
        $('#chat-input').val('');

        // Get bot response based on user input
        var botResponse = getBotResponse(userMessage);
        $('#chat-messages').append('<div class="chatbot-message">' + botResponse + '</div>');

        // Scroll to bottom of chat messages
        $("#chat-messages").scrollTop($("#chat-messages")[0].scrollHeight);
    });

    function getBotResponse(userMessage) {
        // Define a set of responses for common inputs
        var responses = {
            "hello": "Hey there! How can I help you today?",
            "hi": "Hello! What can I do for you?",
            "hey": "Hi! How's it going?",
            "how are you": "I'm just a simple bot, but I'm doing well! Thanks for asking.",
            "what's your name": "My name is CCX Assistant. Nice to meet you!",
            "bye": "See you later! Have a great day!",
            "goodbye": "Goodbye! Take care!",
            "thank you": "You're welcome! If you have more questions, feel free to ask.",
            "help": "I'm here to help! What do you need assistance with?",
            "what are you doing": "I'm chatting with you!",
            "ccx":"CCX is an online learning platform made for cse students.",
            "courses":"We offer a variety of courses like Java, Python, Computer Architecure, System Software, DBMS etc.",
            "enroll":"To enroll in a course, click on 'Enroll Now' on the course page and follow the registration steps. Need further assistance? I'm here to help!"
            // Add more responses as needed
        };

        // Check if the user's message matches any of the keys in the responses object
        for (var key in responses) {
            if (userMessage.includes(key)) {
                return responses[key];
            }
        }

        // Default response if no match is found
        return "I'm just a simple chatbot. I cannot answer that yet.";
    }

            // Prevent modal from opening on page load
            $('#loginModal').on('shown.bs.modal', function (e) {
                // Remove focus from the triggering element
                $(e.relatedTarget).blur();
            });

            // Login form submission (example)
            $('#loginForm').submit(function (e) {
                //e.preventDefault();
                var email = $('#loginEmail').val();
                var password = $('#loginPassword').val();
                // Add your login logic here (e.g., AJAX request)
                //alert('Login successful');
                $('#loginModal').modal('hide'); // Hide the modal after submission
            });

            // Registration form submission (example)
            $('#registerForm').submit(function (e) {
                //e.preventDefault();
                var fullName = $('#registerFullName').val();
                var email = $('#registerEmail').val();
                var password = $('#registerPassword').val();
                // Add your registration logic here (e.g., AJAX request)
                //alert('Registration successful');
                $('#registerModal').modal('hide'); // Hide the modal after submission
            });

            // Ensure smooth scrolling for navigation links
            $('a[href^="#"]').on('click', function (event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top
                    }, 1000);
                }
            });
        });
    </script>

<script>
    document.querySelectorAll('.enroll-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
        if (!isLoggedIn) {
            event.preventDefault();
            alert('Please login to enroll this course');
        }
    });
});

</script>
</body>

</html>
