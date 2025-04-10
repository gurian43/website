<?php

require_once __DIR__ . '/php/utility/load_env.php';
require_once __DIR__ . '/php/config/database.php';

if(!isset($db)) {
    loadEnv(__DIR__ . '/.env');
    $db = new Database();
    $conn = $db->connect();
}

if(isset($_GET['u'])) {
    $url = $db->getUrl($_GET['u']);

    if($url !== null) {
        header('Location: ' . $url);
        exit;
    } else {
        echo 'URL not found';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preload" href="resources/css/index.css" as="style">
    <link rel="preload" href="/resources/images/logo.webp" as="image">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" as="style">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gurian's personal website">
    <link rel="icon" type="image/x-icon" href="/resources/images/logo.webp">
    <link rel="stylesheet" href="resources/css/index.css">
    <link rel="stylesheet" href="resources/css/stratagem-hero.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js" defer></script>
    <title>Gurian</title>

    <meta content="Gurian's Website" property="og:title" />
    <meta content="cool stuff and more stuff" property="og:description" />
    <meta content="https://gurian-website.vercel.app" property="og:url" />
    <meta content="/resources/images/logo.webp" property="og:image" />
    <meta content="#d3d3ff" data-react-helmet="true" name="theme-color" />
</head>
<body>
    <div class="container">
        <div class="fixed">
            <img alt="logo" src="resources/images/logo.webp" class="logo scaling" loading="lazy">
            <div class="scroll-button scaling" onclick="scrollToTop()" style="font-size: 24px;">
                ↑
            </div>
            <div class="scrollbar">
                <div onclick="scrollToSection('lander')" id="lander-dot" class="dot active"></div>
                <div onclick="scrollToSection('about')" id="about-dot" class="dot"></div>
                <div onclick="scrollToSection('projects')" id="projects-dot" class="dot"></div>
                <div onclick="scrollToSection('stuff')" id="stuff-dot" class="dot"></div>
            </div>
        </div> 
        <div class="landing-page page" id="lander">
            <div class="header">
                <h1>GURIAN</h1>
                <p class="mobile-warning">BEWARE: unstable on mobile devices</p>
            </div>
            <div class="art-credit" id="author">art by narukamitooru ❤️</div>
        </div>
        <div class="separator full-separator"></div>
        <div class="about page fade-in" id="about">
            <div class="about-text">
                <h1>ABOUT ME</h1>
                <p>IT Student @ <a class="spsul-link" href="https://spsul.cz/" target="_blank" rel="noreferrer noopener">SPSUL</a></p>
            </div>
            <div class="sections-container">
                <div class="section">
                    <h2>SOCIALS</h2>
                    <ul>
                        <li class="scaling"><a class="socials" href="https://github.com/gurian43" target="_blank" rel="noopener noreferrer"><img class="socials-logo" src="/resources/images/github.png">GitHub</a></li>
                        <li class="scaling"><a class="socials" href="https://steamcommunity.com/profiles/76561198273615787" target="_blank" rel="noopener noreferrer"><img class="socials-logo" src="/resources/images/steam.png">Steam</a></li>
                        <li class="scaling"><a class="socials"><img class="socials-logo" src="/resources/images/discord.png">@gurian43</a></li>
                    </ul>
                </div>
                <div class="section">
                    <h2>OTHER LINKS</h2>
                    <ul>
                        <li class="scaling"><a class="socials" href="https://imgur.com/a/ca8wsp8/" target="_blank" rel="noopener noreferrer">Rin Art Gallery</a></li>
                        <li class="scaling"><a class="socials" href="https://github.com/gurian43/website" target="_blank" rel="noopener noreferrer">Source Code</a></li>
                        <li class="scaling"><a class="socials" href="https://steamcommunity.com/tradeoffer/new/?partner=313350059&token=nOZ6_-4V" target="_blank" rel="noopener noreferrer">Steam Trade Link</a></li>
                    </ul>
                </div>
                <!--
                <div class="section">
                    <h2>PC SPECS</h2>
                    <div class="setup">
                        <div>
                            <h3>Motherboard</h3>
                            <p>Gigabyte B550 Gaming X V2</p>
                        </div>
                        <div>
                            <h3>GPU</h3>
                            <p>Nvidia RTX 3070Ti Founders Edition</p>
                        </div>
                        <div>
                            <h3>CPU</h3>
                            <p>AMD Ryzen 7 5800X3D</p>
                        </div>
                        <div>
                            <h3>RAM</h3>
                            <p>Kingston Fury 2x16GB DDR4 3200MHz</p>
                        </div>
                        <div>
                            <h3>SSD</h3>
                            <p>WD Black SN770 NVMe 1TB</p>
                        </div>
                    </div>                    
                </div>
                -->
            </div>
        </div>
        <div class="separator"></div>
        <div class="projects page fade-in" id="projects">
            <h1>PROJECTS</h1>
            <div class="sections-container">
                <?php
                $projects = $db->getProjects();

                foreach($projects as $project) {
                    echo '<div class="section project-section">';
                    if($project['project_url'] != "") {
                        echo '<a href="' . $project['project_url'] . '" target="_blank" rel="noreferrer noopener">';
                    } else {
                        echo '<a onclick="return false;">';
                    }
                    echo '<img src="' . $project['image_url'] . '" alt="' . $project['name'] . '" class="project-preview">';
                    echo '</a>';
                    echo '<h2>' . $project['name'] . '</h2>';
                    echo '<p>' . $project['description'] . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <div class="separator"></div>
        <div class="stuff page fade-in" id="stuff">
            <img src="./resources/images/helldivers2.webp" alt="helldivers" class="helldivers">
            <h1>Stratagem Hero</h1>
            <h2 class="mobile-warning">PC ONLY</h2>
            <div class="stratagem-div">
                <img id="img" height="50px" width="50px"></img>
                <p id="name"></p>
                <div id="sequence"></div>
            </div>
        </div>
    </div>

    <script src="resources/data/stratagem-data.js"></script>
    <script src="resources/js/index.js"></script>
    <script src="resources/js/stratagem-hero.js"></script>
</body>
</html>