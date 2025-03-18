<?php
$showAlert = false;
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /ClientWork/ExoEra/exoEra-main/ExoEra/login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    include '../Partials/_db_connect.php';

    $sql = "INSERT INTO `contact` (`subject`, `message`) VALUES ('$subject', '$message');";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $showAlert = true;
    }   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Contact Us</title>
    <style>
        :root {
            --primary-color: #4461F2;
            --secondary-color: #6C7BF2;
            --accent-color: #2C3ED7;
            --text-color: #333333;
            --text-light: #666666;
            --background-color: #ffffff;
            --card-background: #f9f9f9;
            --border-color: #e0e0e0;
            --success-color: #4CAF50;
            --error-color: #f44336;
            --shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        /* Dark theme variables */
        .dark-theme {
            --primary-color: #6C7BF2;
            --secondary-color: #4461F2;
            --accent-color: #7B88F3;
            --text-color: #f0f0f0;
            --text-light: #cccccc;
            --background-color: #1a1a1a;
            --card-background: #2a2a2a;
            --border-color: #444444;
            --shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            transition: var(--transition);
            min-height: 100vh;
            padding: 20px;
        }

        header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 40px;
            padding: 20px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .tagline {
            color: var(--text-light);
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
            background: var(--card-background);
            border: 1px solid var(--border-color);
            padding: 8px 12px;
            border-radius: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .theme-toggle:hover {
            transform: translateY(-2px);
        }

        .theme-toggle .icon {
            margin-right: 8px;
        }

        #toggle-text {
            font-weight: 500;
        }

        .contact-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-info {
            background: var(--card-background);
            border-radius: 15px;
            padding: 30px;
            flex: 1;
            min-width: 280px;
            max-width: 400px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid var(--border-color);
            animation: fadeInLeft 0.5s ease-out both;
        }

        .contact-form {
            background: var(--card-background);
            border-radius: 15px;
            padding: 30px;
            flex: 2;
            min-width: 280px;
            max-width: 700px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid var(--border-color);
            animation: fadeInRight 0.5s ease-out both;
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }

        .contact-method {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .contact-icon {
            background: rgba(68, 97, 242, 0.1);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .contact-details h3 {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .contact-details p {
            color: var(--text-light);
            line-height: 1.5;
        }

        .social-media {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transition: var(--transition);
            cursor: pointer;
        }

        .social-icon:hover {
            transform: translateY(-5px);
            background: var(--accent-color);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--background-color);
            color: var(--text-color);
            font-size: 1rem;
            transition: var(--transition);
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(68, 97, 242, 0.2);
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .submit-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 1rem;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            min-width: 150px;
            display: inline-block;
        }

        .submit-btn:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Map container */
        .map-container {
            margin-top: 40px;
            margin-left: 20%;
            width: 60%;
            border-radius: 15px;
            overflow: hidden;
            height: 300px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            animation: fadeInUp 0.5s ease-out 0.3s both;
            background-color: var(--card-background);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .map-placeholder {
            width: 100%;
            height: 100%;
            background-color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
            font-size: 1.2rem;
            font-weight: 500;
        }

        .dark-theme .map-placeholder {
            background-color: #3a3a3a;
        }

        /* Animations */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .contact-container {
                flex-direction: column;
                align-items: center;
            }

            .contact-info, .contact-form {
                width: 100%;
                max-width: 500px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            h1 {
                font-size: 2rem;
            }
        }

        .faq-container {
            width: 80%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .faq-container h1 {
            text-align: center;
        }

        .faq-item {
            border-bottom: 1px solid #fff;
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            cursor: pointer;
            background-color: #fff;
        }

        .faq-answer {
            display: none;
            padding: 15px;
            background-color: #fff;
        }

        .arrow {
            font-weight: bold;
        }


    </style>
</head>
<body>
<?php 
 if($showAlert) {
    echo '<div class="alert alert-success" role="alert">
 Message Successfully sent!
</div>';
 }
?>
    <div class="theme-toggle" onclick="toggleTheme()">
        <span class="icon" id="theme-icon">☀️</span>
        <span id="toggle-text">Light Mode</span>
    </div>

    <header>
        <h1>Get In Touch</h1>
        <p class="tagline">We'd love to hear from you. Here's how you can reach us</p>
    </header>

    <div class="contact-container">
        <div class="contact-info">
            <h2 class="section-title">Contact Information</h2>
            
            <div class="contact-method">
                <div class="contact-icon">📍</div>
                <div class="contact-details">
                    <h3>Our Location</h3>
                    <p>123 Business Avenue, Suite 500<br>San Francisco, CA 94107</p>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-icon">📱</div>
                <div class="contact-details">
                    <h3>Phone Number</h3>
                    <p>+1 (555) 123-4567<br>Mon-Fri, 9AM-6PM PST</p>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-icon">✉️</div>
                <div class="contact-details">
                    <h3>Email Address</h3>
                    <p>support@yourcompany.com<br>info@yourcompany.com</p>
                </div>
            </div>
            
            <div class="social-media">
                <div class="social-icon">f</div>
                <div class="social-icon">in</div>
                <div class="social-icon">𝕏</div>
                <div class="social-icon">ig</div>
            </div>
        </div>
        
        <div class="contact-form">
            <h2 class="section-title">Send Us a Message</h2>
            
            <form id="contactForm" method="POST" onsubmit="submitForm(event)">
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <select id="subject" name="subject" required>
                        <option value="" disabled selected>Select a subject</option>
                        <option value="general">General Inquiry</option>
                        <option value="support">Technical Support</option>
                        <option value="billing">Billing Question</option>
                        <option value="partnership">Partnership Opportunity</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
    </div>
    <br><br><br>

    <section>
        <div class="faq-container">
                    <h1>Recently Asked Questions</h1>
                    
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            <span>What’s the best way to prepare for coding interviews?</span>
                            <span class="arrow">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Preparation is key and we are here to make you prepared! Consistent practice with coding problems is more effective than last-minute cramming. Tuf also helps you simulate the interview environment. We’ve got dedicated sections for practice problems, coding challenges, and guides!</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            <span>How should I approach system design interview questions?</span>
                            <span class="arrow">+</span>
                        </div>
            <div class="faq-answer">
                        <p>Consider understanding the fundamentals of system design, practicing with various types of systems, and reviewing common patterns used in design.</p>
                        </div>
                    </div>
            
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            <span>Are the Striver's SDE sheet questions enough for interview preparation?</span>
                            <span class="arrow">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Striver's SDE sheet is a good starting point, but you should also solve additional problems and delve into system design concepts.</p>
                        </div>
                    </div>
            
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            <span>How do I get the most out of your website or TUF community?</span>
                            <span class="arrow">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Participate actively in discussions, utilize available resources, and engage with mentors.</p>
                        </div>
                    </div>
            
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            <span>What are the essential things to cover in core coding subjects?</span>
                            <span class="arrow">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Focus on data structures, algorithms, time complexities, and problem-solving practices.</p>
                        </div>
                    </div>
            
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            <span>Do you offer any mentorship or career guidance programs?</span>
                            <span class="arrow">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, we offer various mentorship programs to guide you through your career journey.</p>
                        </div>
                    </div>
                </div>
    </section>
    <br><br><br>
    
    <section class="map-section" data-aos="fade-up">
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.25436351647!2d-74.11976373946229!3d40.69766374934207!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1647043075487!5m2!1sen!2sin" 
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </section>

    <script>
        function toggleTheme() {
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');
            const toggleText = document.getElementById('toggle-text');
            
            if (body.classList.contains('dark-theme')) {
                body.classList.remove('dark-theme');
                themeIcon.textContent = '☀️';
                toggleText.textContent = 'Light Mode';
                localStorage.setItem('theme', 'light');
            } else {
                body.classList.add('dark-theme');
                themeIcon.textContent = '🌙';
                toggleText.textContent = 'Dark Mode';
                localStorage.setItem('theme', 'dark');
            }
        }

        window.onload = function() {
            const savedTheme = localStorage.getItem('theme');
            const themeIcon = document.getElementById('theme-icon');
            const toggleText = document.getElementById('toggle-text');
            
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-theme');
                themeIcon.textContent = '🌙';
                toggleText.textContent = 'Dark Mode';
            }
        };

        

        function toggleAnswer(element) {
            const answer = element.nextElementSibling;
            const arrow = element.querySelector('.arrow');
            
            if (answer.style.display === "block") {
                answer.style.display = "none";
                arrow.textContent = "+";
            } else {
                answer.style.display = "block";
                arrow.textContent = "-";
            }
        }

    </script>
</body>
</html>