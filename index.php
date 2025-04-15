<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to SoulSphere</title>
    <link rel="stylesheet" href="soulsphere.css">
</head>
<body onload="checkDarkMode()">
    <div class="home-hero feature-card fade-in">
        <h1>🌟 Welcome to <span class="highlight">SoulSphere</span></h1>
        <p>Your mental wellness companion — a safe space for expression, support, and healing.</p>
        <button onclick="location.href='voc.php'" class="cta-button">Explore Voices of the Crowd</button>
    </div>

    <section class="features-section">
        <h2>🧭 What You’ll Find Here</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <h3>🗣️ Voices of the Crowd</h3>
                <p>Share anonymous messages, vote on others, and read inspiring insights daily.</p>
            </div>
            <div class="feature-card">
                <h3>🧘 Wellness</h3>
                <p>Practical self-care techniques, meditations, and motivational content to help you thrive.</p>
            </div>
            <div class="feature-card">
                <h3>🤝 Help Circle</h3>
                <p>Join peer groups, engage in healing conversations, and support others like you.</p>
            </div>
            <div class="feature-card">
                <h3>📚 Resources</h3>
                <p>Access curated articles, professional help links, and crisis helpline info.</p>
            </div>
        </div>
    </section>

    <section class="mission-statement">
        <h2>🌈 Our Mission</h2>
        <p>To empower everyone to speak up, connect, and heal — one voice at a time.</p>
        <p>You're never alone here. Let’s grow together 💙</p>
    </section>

       <script src="soulsphere.js"></script>  <!-- Link to your JS file -->

</body>
</html>
