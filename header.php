<!-- header.php -->
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
                <li class="nav-item"><a class="nav-link" href="main_copy.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#courses">Courses</a></li>
                <li class="nav-item"><a class="nav-link" href="#playground">Playground</a></li>
                <li class="nav-item"><a class="nav-link" href="#badges">Badges</a></li>
                <li class="nav-item">
                    <?php session_start(); ?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a class="nav-link" href="#">Welcome, <?php echo $_SESSION['full_name']; ?></a>
                        <a class="nav-link btn btn-outline-light ms-2" href="backend.php?logout=true">Logout</a>
                    <?php else: ?>
                        <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="/gdg_hack25/css/bootstrap.min.css">
<script src="/gdg_hack25/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="/gdg_hack25/css/style.css">

