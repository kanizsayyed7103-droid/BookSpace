<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace | Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Cinzel+Decorative:wght@700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
    /* Define CSS Variables */
    :root {
        --color-deep-purple: #3a2d5c;
        --color-lavender: #a18cd1;
        --color-dusty-pink: #fbc2eb;
        --color-text: #2c2c2c;
        --color-light-text: #f0f0f0;
        --color-highlight: #51407d;
        --color-form-bg: #f8f9fa;
        /* Light background for form */

    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--color-lavender);
        margin: 0;
        padding-top: 70px;
    }

    /* --- Main Content Styling --- */
    .main-content-wrapper {
        padding: 30px 20px;
        /* Increased padding */
        min-height: calc(100vh - 70px);
    }

    /* Professional Contact Form */
    .contact-form {
        background: var(--color-form-bg);
        /* Light grey background */
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        /* Clearer shadow */
        border: 1px solid #ddd;
        /* Subtle border */
    }

    .contact-form h4 {
        font-weight: 600;
        color: var(--color-deep-purple);
    }

    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
    }

    .btn-contact {
        padding: 10px 30px;
        background-color: var(--color-deep-purple);
        color: white;
        border-radius: 25px;
        font-weight: 600;
        transition: background 0.3s ease, transform 0.2s;
    }

    .btn-contact:hover {
        background: var(--color-highlight);
        transform: translateY(-2px);
    }

    /* Professional Contact Info Box (Right Side) */
    .contact-info {
        background: var(--color-deep-purple);
        color: var(--color-light-text);
        border-radius: 12px;
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .contact-info h4 {
        border-bottom: 2px solid var(--color-dusty-pink);
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .contact-info p {
        margin-bottom: 15px;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
    }

    .contact-info a {
        color: var(--color-light-text);
        text-decoration: none;
        transition: color 0.2s;
    }

    .contact-info a:hover {
        color: var(--color-dusty-pink);
    }

    /* Adjusting icon sizes and margins */
    .contact-info i {
        font-size: 1.2rem;
        margin-right: 12px;
        color: var(--color-dusty-pink);
    }

    /* Social media icons */
    .contact-info .social-icons a {
        font-size: 1.5rem;
        margin-right: 15px;
    }
    </style>
</head>
<?php include 'navbar.php'; ?>

<body class="min-vh-100">

    <div class="main-content-wrapper">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-12 text-center">
                    <h2 class="mb-2" style="color: var(--color-deep-purple); font-weight: 700;">Get in Touch With
                        BookSpace</h2>
                    <p class="text-muted">We're here to answer your questions and help you with your reading journey.
                    </p>
                </div>
            </div>

            <div class="row justify-content-center g-5">
                <div class="col-12 col-lg-7">
                    <div class="contact-form">
                        <h4 class="mb-4">Send us a Message</h4>
                        <form action="#" method="post">
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" required
                                    placeholder="Enter your full name">
                            </div>
                            <div class="mb-3">
                                <label for="emailAddress" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="emailAddress" required
                                    placeholder="Enter your email">
                            </div>
                            <div class="mb-4">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="5" required
                                    placeholder="Enter your message"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-contact">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="contact-info h-100">
                        <h4 class="mb-4">Our Details</h4>
                        <p>
                            <i class="bi bi-geo-alt-fill"></i>
                            123 Bookworm Lane, Reading, Fictionland
                        </p>
                        <p>
                            <i class="bi bi-envelope-fill"></i>
                            <a href="mailto:contact@bookspace.com">contact@bookspace.com</a>
                        </p>
                        <p>
                            <i class="bi bi-telephone-fill"></i>
                            <a href="tel:+1234567890">+1 (234) 567-890</a>
                        </p>

                        <h5 class="mt-4 mb-3" style="color: var(--color-dusty-pink);">Connect with Us</h5>
                        <p class="social-icons">
                            <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>