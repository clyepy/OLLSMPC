<?php
include "../connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Awards - OLLSMPC</title>

<!-- Favicons -->
<link href="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" rel="icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Vendor CSS -->
<link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="index.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 8.2.14, nicepage.com">
<!-- Main CSS -->
<link href="../assets/css/main.css" rel="stylesheet">
</head>
<body>

<!-- ================= HEADER ================= -->
  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
<a href="index.php" class="logo d-flex align-items-center">
  <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" alt="OLLSMPC Logo">
  <h1 class="sitename">OLLSMPC</h1>
</a>
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../about.php">About</a></li>
            <li><a href="../services.php">Services</a></li>
            <li><a href="../event.php">Events</a></li> 
            <li><a href="../team.php">Team</a></li>
            <li class="dropdown"><a href="#"><span>Others</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="../FAQ.php">Frequently Ask Questions</a></li>
                <li><a href="../reviews.php">Reviews</a></li>
                <li><a href="index.php">Awards</a></li>
                <li><a href="../term.php">Term</a></li>
              </ul>
            </li>
            <li><a href="contact-submit.php">Contact</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>
  </header>

    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Awards</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Awards</li>
          </ol>
        </nav>
      </div>
    </div>
      <style>

.page-title {
  color: var(--default-color);
  background-color: var(--background-color);
  padding: 25px 0;
  position: relative;
}

.page-title h1 {
  margin-top: 0%;
  font-size: 24px;
  font-weight: 700;
  font-family: 'Ubuntu', sans-serif;
}

.page-title .breadcrumbs ol {
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  padding: 0;
  margin: 0;
  font-size: 14px;
  font-weight: 400;
}

.page-title .breadcrumbs ol li+li {
  padding-left: 10px;
}

.page-title .breadcrumbs ol li+li::before {
  content: "/";
  display: inline-block;
  padding-right: 10px;
  color: color-mix(in srgb, var(--default-color), transparent 70%);
}

.header .logo {
  display: flex;
  align-items: center;
  gap: 10px; 
}

.header .logo img {
  max-height: 40px; 
  width: auto;
}

.header .logo h1 {
  font-size: 30px;
  margin: 0;
  font-weight: 700;
  font-family: 'Ubuntu', sans-serif;
}

.header {
  --background-color: #ffffff;
  color: var(--default-color);
  transition: all 0.5s;
  z-index: 997;
  background-color: var(--background-color);
}

.header .branding {
  min-height: 60px;
  padding: 10px 0;
}

.header .logo {
  line-height: 1;
}

.header .logo img {
  max-height: 36px;
  margin-right: 8px;
}

.header .logo h1 {
  font-size: 30px;
  margin: 0;
  font-weight: 700;
  color: var(--heading-color);
}

.scrolled .header {
  box-shadow: 0px 0 18px rgba(0, 0, 0, 0.1);
}

.scrolled .header .topbar {
  height: 0;
  visibility: hidden;
  overflow: hidden;
}

@media (min-width: 1200px) {
  .navmenu {
    padding: 0;
  }

  .navmenu ul {
    margin: 0;
    padding: 0;
    display: flex;
    list-style: none;
    align-items: center;
  }

  .navmenu li {
    position: relative;
  }

  .navmenu a,
  .navmenu a:focus {
    color: var(--nav-color);
    padding: 18px 15px;
    font-size: 16px;
    font-family: var(--nav-font);
    font-weight: 400;
    display: flex;
    align-items: center;
    justify-content: space-between;
    white-space: nowrap;
    transition: 0.3s;
  }

  .navmenu a i,
  .navmenu a:focus i {
    font-size: 12px;
    line-height: 0;
    margin-left: 5px;
    transition: 0.3s;
  }

  .navmenu li:last-child a {
    padding-right: 0;
  }

  .navmenu li:hover>a,
  .navmenu .active,
  .navmenu .active:focus {
    color: var(--nav-hover-color);
  }

  .navmenu .dropdown ul {
    margin: 0;
    padding: 10px 0;
    background: var(--nav-dropdown-background-color);
    display: block;
    position: absolute;
    visibility: hidden;
    left: 14px;
    top: 130%;
    opacity: 0;
    transition: 0.3s;
    border-radius: 4px;
    z-index: 99;
    box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.1);
  }

  .navmenu .dropdown ul li {
    min-width: 200px;
  }

  .navmenu .dropdown ul a {
    padding: 10px 20px;
    font-size: 15px;
    text-transform: none;
    color: var(--nav-dropdown-color);
  }

  .navmenu .dropdown ul a i {
    font-size: 12px;
  }

  .navmenu .dropdown ul a:hover,
  .navmenu .dropdown ul .active:hover,
  .navmenu .dropdown ul li:hover>a {
    color: var(--nav-dropdown-hover-color);
  }

  .navmenu .dropdown:hover>ul {
    opacity: 1;
    top: 100%;
    visibility: visible;
  }

  .navmenu .dropdown .dropdown ul {
    top: 0;
    left: -90%;
    visibility: hidden;
  }

  .navmenu .dropdown .dropdown:hover>ul {
    opacity: 1;
    top: 0;
    left: -100%;
    visibility: visible;
  }
}

@media (max-width: 1199px) {
  .mobile-nav-toggle {
    color: var(--nav-color);
    font-size: 28px;
    line-height: 0;
    margin-right: 10px;
    cursor: pointer;
    transition: color 0.3s;
  }

  .navmenu {
    padding: 0;
    z-index: 9997;
  }

  .navmenu ul {
    display: none;
    list-style: none;
    position: absolute;
    inset: 60px 20px 20px 20px;
    padding: 10px 0;
    margin: 0;
    border-radius: 6px;
    background-color: var(--nav-mobile-background-color);
    overflow-y: auto;
    transition: 0.3s;
    z-index: 9998;
    box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.1);
  }

  .navmenu a,
  .navmenu a:focus {
    color: var(--nav-dropdown-color);
    padding: 10px 20px;
    font-family: var(--nav-font);
    font-size: 17px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: space-between;
    white-space: nowrap;
    transition: 0.3s;
  }

  .navmenu a i,
  .navmenu a:focus i {
    font-size: 12px;
    line-height: 0;
    margin-left: 5px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: 0.3s;
    background-color: color-mix(in srgb, var(--accent-color), transparent 90%);
  }

  .navmenu a i:hover,
  .navmenu a:focus i:hover {
    background-color: var(--accent-color);
    color: var(--contrast-color);
  }

  .navmenu a:hover,
  .navmenu .active,
  .navmenu .active:focus {
    color: var(--nav-dropdown-hover-color);
  }

  .navmenu .active i,
  .navmenu .active:focus i {
    background-color: var(--accent-color);
    color: var(--contrast-color);
    transform: rotate(180deg);
  }

  .navmenu .dropdown ul {
    position: static;
    display: none;
    z-index: 99;
    padding: 10px 0;
    margin: 10px 20px;
    background-color: var(--nav-dropdown-background-color);
    border: 1px solid color-mix(in srgb, var(--default-color), transparent 90%);
    box-shadow: none;
    transition: all 0.5s ease-in-out;
  }

  .navmenu .dropdown ul ul {
    background-color: rgba(33, 37, 41, 0.1);
  }

  .navmenu .dropdown>.dropdown-active {
    display: block;
    background-color: rgba(33, 37, 41, 0.03);
  }

  .mobile-nav-active {
    overflow: hidden;
  }

  .mobile-nav-active .mobile-nav-toggle {
    color: #fff;
    position: absolute;
    font-size: 32px;
    top: 15px;
    right: 15px;
    margin-right: 0;
    z-index: 9999;
  }

  .mobile-nav-active .navmenu {
    position: fixed;
    overflow: hidden;
    inset: 0;
    background: rgba(33, 37, 41, 0.8);
    transition: 0.3s;
  }

  .mobile-nav-active .navmenu>ul {
    display: block;
  }
}

.footer {
  color: var(--default-color);
  background-color: var(--background-color);
  font-size: 14px;
  padding-bottom: 50px;
  position: relative;
}

.footer .footer-top {
  padding-top: 50px;
  border-top: 1px solid color-mix(in srgb, var(--default-color), transparent 90%);
}

.footer .footer-about .logo {
  line-height: 1;
  margin-bottom: 25px;
  border-radius: 50%;
}

.footer .footer-about .logo img {
  max-height: 40px;
  margin-right: 6px;
  border-radius: 50%;
}

.footer .footer-about .logo span {
  color: var(--heading-color);
  font-size: 30px;
  font-weight: 700;
  letter-spacing: 1px;
  font-family: var(--heading-font);
}

.footer .footer-about p {
  font-size: 14px;
  font-family: var(--heading-font);
}

.footer .social-links a {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 1px solid color-mix(in srgb, var(--default-color), transparent 50%);
  font-size: 16px;
  color: color-mix(in srgb, var(--default-color), transparent 50%);
  margin-right: 10px;
  transition: 0.3s;
}

.footer .social-links a:hover {
  color: var(--accent-color);
  border-color: var(--accent-color);
}

.footer h4 {
  font-size: 16px;
  font-weight: bold;
  position: relative;
  padding-bottom: 12px;
}

.footer .footer-links {
  margin-bottom: 30px;
}

.footer .footer-links ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer .footer-links ul i {
  padding-right: 2px;
  font-size: 12px;
  line-height: 0;
}

.footer .footer-links ul li {
  padding: 10px 0;
  display: flex;
  align-items: center;
}

.footer .footer-links ul li:first-child {
  padding-top: 0;
}

.footer .footer-links ul a {
  color: color-mix(in srgb, var(--default-color), transparent 20%);
  display: inline-block;
  line-height: 1;
}

.footer .footer-links ul a:hover {
  color: var(--accent-color);
}

.footer .footer-contact p {
  margin-bottom: 5px;
}

.footer .copyright {
  padding-top: 25px;
  padding-bottom: 25px;
  background-color: color-mix(in srgb, var(--default-color), transparent 95%);
}

.footer .copyright p {
  margin-bottom: 0;
}

.footer .credits {
  margin-top: 6px;
  font-size: 13px;
}

#preloader {
  position: fixed;
  inset: 0;
  z-index: 999999;
  overflow: hidden;
  background: var(--background-color);
  transition: all 0.6s ease-out;
}

#preloader:before {
  content: "";
  position: fixed;
  top: calc(50% - 30px);
  left: calc(50% - 30px);
  border: 6px solid #ffffff;
  border-color: var(--accent-color) transparent var(--accent-color) transparent;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  animation: animate-preloader 1.5s linear infinite;
}

@keyframes animate-preloader {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

.u-section-1 {
  padding-bottom: 40px;
}

.u-section-2 {
  padding-bottom: 20px;
}

/* AWARD BOX */
.award-box {
  background: #fff;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  transition: 0.3s;
}

.award-box:hover {
  transform: translateY(-5px);
}

.u-section-1 .u-sheet-1 {
  min-height: auto !important;
  height: auto !important;

}


.u-section-1 .u-shape-1 {
  width: 838px;
  background-image: none;
  height: 634px;
    margin: 0px auto 0 113px;
}

.u-section-1 .u-image-1 {
  width: 526px;
  min-height: 477px;
  background-image: url("images/u_150.png");
  background-position: 50% 50%;
  height: auto;
  margin: -495px 0 0 auto;
}

.u-section-1 .u-container-layout-1 {
  margin-bottom: 0;
  padding: 0 0 30px;
}

.u-section-1 .u-image-2 {
  width: 918px;
  height: 635px;
  object-position: 23.86% 100%;
  margin: -547px auto 0 0;
}

.u-section-1 .u-group-2 {
  width: 751px;
  min-height: 273px;
  background-image: none;
  height: auto;
  margin: -102px 0 0 auto;
}

.u-section-1 .u-container-layout-2 {
  padding: 30px 40px;
}

.u-section-1 .u-text-1 {
  font-size: 4.5rem;
  margin: 0;
}

.u-section-1 .u-group-3 {
  width: 506px;
  min-height: 365px;
  height: auto;
  margin: 20px auto 60px 123px;
}

.u-section-1 .u-container-layout-3 {
  padding: 30px 20px 30px 0;
}

.u-section-1 .u-text-2 {
  font-size: 3rem;
  margin: 8px 0 0;
}

.u-section-1 .u-text-3 {
  margin: 20px 0 0;
}

@media (max-width: 1199px) {
  .u-section-1 .u-sheet-1 {
    min-height: 1310px;
  }

  .u-section-1 .u-shape-1 {
    width: 722px;
    height: 591px;
    margin-top: 143px;
    margin-left: 102px;
  }

  .u-section-1 .u-image-1 {
    height: auto;
  }

  .u-section-1 .u-image-2 {
    width: 725px;
    height: 607px;
  }

  .u-section-1 .u-group-2 {
    width: 598px;
    height: auto;
  }

  .u-section-1 .u-text-1 {
    font-size: 3.75rem;
  }

  .u-section-1 .u-group-3 {
    margin-bottom: 51px;
    margin-left: 102px;
    height: auto;
  }
}

@media (max-width: 991px) {
  .u-section-1 .u-sheet-1 {
    min-height: 1260px;
  }

  .u-section-1 .u-shape-1 {
    width: 623px;
    height: 486px;
    margin-top: 353px;
    margin-left: 41px;
  }

  .u-section-1 .u-image-2 {
    width: 556px;
    height: 485px;
  }

  .u-section-1 .u-group-2 {
    width: 581px;
    min-height: 238px;
    margin-top: 13px;
  }

  .u-section-1 .u-container-layout-2 {
    padding-left: 30px;
    padding-right: 30px;
  }

  .u-section-1 .u-group-3 {
    margin-bottom: 12px;
    margin-left: 41px;
  }
}

@media (max-width: 767px) {
  .u-section-1 .u-sheet-1 {
    min-height: 1120px;
  }

  .u-section-1 .u-shape-1 {
    width: 459px;
    height: 382px;
    margin-top: 166px;
    margin-left: 35px;
  }

  .u-section-1 .u-image-1 {
    width: 445px;
    min-height: 301px;
    margin-top: -316px;
  }

  .u-section-1 .u-image-2 {
    width: 439px;
    height: 384px;
    margin-top: -477px;
  }

  .u-section-1 .u-group-2 {
    width: 452px;
    min-height: 203px;
    margin-top: -27px;
  }

  .u-section-1 .u-container-layout-2 {
    padding-left: 25px;
    padding-right: 25px;
  }

  .u-section-1 .u-group-3 {
    min-height: 428px;
    margin-right: 0;
    margin-bottom: 56px;
    margin-left: auto;
  }

  .u-section-1 .u-container-layout-3 {
    padding-right: 10px;
  }

  .u-section-1 .u-text-2 {
    width: auto;
    margin-top: 18px;
  }
}

@media (max-width: 575px) {
  .u-section-1 .u-sheet-1 {
    min-height: 1104px;
  }

  .u-section-1 .u-shape-1 {
    height: 272px;
    margin-top: 202px;
    margin-right: initial;
    margin-left: initial;
    width: auto;
  }

  .u-section-1 .u-image-1 {
    width: 246px;
    min-height: 274px;
    margin-top: -160px;
  }

  .u-section-1 .u-image-2 {
    width: 305px;
    height: 255px;
  }

  .u-section-1 .u-group-2 {
    min-height: 169px;
    width: 307px;
    margin-top: 60px;
  }

  .u-section-1 .u-container-layout-2 {
    padding-left: 20px;
    padding-right: 20px;
  }

  .u-section-1 .u-text-1 {
    font-size: 2.1875rem;
  }

  .u-section-1 .u-group-3 {
    min-height: 479px;
    margin-bottom: 10px;
    margin-right: initial;
    margin-left: initial;
    width: auto;
  }

  .u-section-1 .u-text-2 {
    font-size: 1.875rem;
    margin-top: 8px;
  }
}.u-section-2 .u-sheet-1 {
  min-height: 610px;
}

.u-section-2 .u-list-1 {
  grid-template-rows: repeat(1, auto);
  margin-top: 60px;
  margin-bottom: 60px;
}

.u-section-2 .u-repeater-1 {
  grid-template-columns: repeat(3, 33.3333%);
  min-height: 490px;
  --gap: 0px;
  grid-auto-columns: 33.3333%;
}

.u-section-2 .u-container-layout-1 {
  padding: 20px 30px;
}

.u-section-2 .u-image-1 {
  height: 319px;
  margin-top: 0;
  margin-bottom: 0;
}

.u-section-2 .u-text-1 {
  margin: 20px auto 0 0;
}

.u-section-2 .u-text-2 {
  margin: 20px 0 0;
}

.u-section-2 .u-container-layout-2 {
  padding: 20px 30px;
}

.u-section-2 .u-image-2 {
  height: 319px;
  margin-top: 0;
  margin-bottom: 0;
}

.u-section-2 .u-text-3 {
  margin: 20px auto 0 0;
}

.u-section-2 .u-text-4 {
  margin: 20px 0 0;
}

.u-section-2 .u-container-layout-3 {
  padding: 20px 30px;
}

.u-section-2 .u-image-3 {
  height: 319px;
  margin-top: 0;
  margin-bottom: 0;
}

.u-section-2 .u-text-5 {
  margin: 20px auto 0 0;
}

.u-section-2 .u-text-6 {
  margin: 20px 0 0;
}

@media (max-width: 1199px) {
  .u-section-2 .u-repeater-1 {
    grid-template-columns: repeat(3, 33.333333333333336%);
    min-height: 404px;
    grid-gap: 0px;
    grid-auto-columns: 33.333333333333336%;
  }

  .u-section-2 .u-image-1 {
    height: 173px;
  }

  .u-section-2 .u-image-2 {
    height: 173px;
  }

  .u-section-2 .u-image-3 {
    height: 173px;
  }
}

@media (max-width: 991px) {
  .u-section-2 .u-repeater-1 {
    grid-template-columns: repeat(2, 50%);
    min-height: 928px;
    grid-auto-columns: 50%;
  }

  .u-section-2 .u-image-1 {
    height: 205px;
  }

  .u-section-2 .u-image-2 {
    height: 205px;
  }

  .u-section-2 .u-image-3 {
    height: 205px;
  }
}

@media (max-width: 767px) {
  .u-section-2 .u-repeater-1 {
    grid-template-columns: 100%;
    grid-auto-columns: 100%;
  }

  .u-section-2 .u-container-layout-1 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-2 .u-image-1 {
    height: 355px;
  }

  .u-section-2 .u-container-layout-2 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-2 .u-image-2 {
    height: 355px;
  }

  .u-section-2 .u-container-layout-3 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-2 .u-image-3 {
    height: 355px;
  }
}

@media (max-width: 575px) {
  .u-section-2 .u-image-1 {
    height: 218px;
  }

  .u-section-2 .u-image-2 {
    height: 218px;
  }

  .u-section-2 .u-image-3 {
    height: 218px;
  }
}.u-section-3 .u-sheet-1 {
  min-height: 916px;
}

.u-section-3 .u-layout-wrap-1 {
  width: 1140px;
  margin: 34px -13px 60px auto;
}

.u-section-3 .u-image-1 {
  min-height: 379px;
  background-image: url("images/award.jpg");
  background-position: 50% 50%;
  background-size: cover;
}

.u-section-3 .u-container-layout-1 {
  padding: 30px;
}

.u-section-3 .u-layout-cell-2 {
  min-height: 379px;
}

.u-section-3 .u-container-layout-2 {
  padding: 30px 60px;
}

.u-section-3 .u-text-1 {
  margin: 0;
}

.u-section-3 .u-text-2 {
  margin: 63px 0 0;
}

.u-section-3 .u-layout-cell-3 {
  min-height: 383px;
}

.u-section-3 .u-container-layout-3 {
  padding: 30px 60px;
}

.u-section-3 .u-text-3 {
  margin: 28px 0 0;
}

.u-section-3 .u-text-4 {
  margin: 63px 0 0;
}

.u-section-3 .u-image-2 {
  min-height: 315px;
  background-image: url("images/award.jpg");
  background-position: 50% 50%;
}

.u-section-3 .u-container-layout-4 {
  padding: 30px;
}

@media (max-width: 1199px) {
  .u-section-3 .u-sheet-1 {
    min-height: 783px;
  }

  .u-section-3 .u-layout-wrap-1 {
    width: 940px;
    margin-right: 0;
  }

  .u-section-3 .u-image-1 {
    min-height: 313px;
  }

  .u-section-3 .u-layout-cell-2 {
    min-height: 313px;
  }

  .u-section-3 .u-layout-cell-3 {
    min-height: 316px;
  }

  .u-section-3 .u-image-2 {
    min-height: 260px;
  }
}

@media (max-width: 991px) {
  .u-section-3 .u-sheet-1 {
    min-height: 310px;
  }

  .u-section-3 .u-layout-wrap-1 {
    width: 720px;
  }

  .u-section-3 .u-image-1 {
    min-height: 240px;
  }

  .u-section-3 .u-layout-cell-2 {
    min-height: 100px;
  }

  .u-section-3 .u-container-layout-2 {
    padding-left: 30px;
    padding-right: 30px;
  }

  .u-section-3 .u-layout-cell-3 {
    min-height: 100px;
  }

  .u-section-3 .u-container-layout-3 {
    padding-left: 30px;
    padding-right: 30px;
  }

  .u-section-3 .u-image-2 {
    min-height: 199px;
  }
}

@media (max-width: 767px) {
  .u-section-3 .u-layout-wrap-1 {
    width: 540px;
  }

  .u-section-3 .u-image-1 {
    min-height: 360px;
  }

  .u-section-3 .u-container-layout-1 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-3 .u-container-layout-2 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-3 .u-container-layout-3 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-3 .u-image-2 {
    min-height: 299px;
  }

  .u-section-3 .u-container-layout-4 {
    padding-left: 10px;
    padding-right: 10px;
  }
}

@media (max-width: 575px) {
  .u-section-3 .u-layout-wrap-1 {
    width: 340px;
  }

  .u-section-3 .u-image-1 {
    min-height: 227px;
  }

  .u-section-3 .u-image-2 {
    min-height: 188px;
  }
}.u-section-4 .u-sheet-1 {
  min-height: 490px;
}

.u-section-4 .u-list-1 {
  grid-template-rows: repeat(1, auto);
  margin-top: 22px;
  margin-bottom: 22px;
}

.u-section-4 .u-repeater-1 {
  grid-template-columns: repeat(3, 33.3333%);
  min-height: 446px;
  --gap: 0px;
  grid-auto-columns: 33.3333%;
}

.u-section-4 .u-container-layout-1 {
  padding: 20px 30px;
}

.u-section-4 .u-image-1 {
  height: 319px;
  margin-top: 0;
  margin-bottom: 0;
}

.u-section-4 .u-text-1 {
  margin: 20px auto 0 0;
}

.u-section-4 .u-text-2 {
  margin: 20px 0 0;
}

.u-section-4 .u-container-layout-2 {
  padding: 20px 30px;
}

.u-section-4 .u-image-2 {
  height: 319px;
  margin-top: 0;
  margin-bottom: 0;
}

.u-section-4 .u-text-3 {
  margin: 20px auto 0 0;
}

.u-section-4 .u-text-4 {
  margin: 20px 0 0;
}

.u-section-4 .u-container-layout-3 {
  padding: 20px 30px;
}

.u-section-4 .u-image-3 {
  height: 319px;
  margin-top: 0;
  margin-bottom: 0;
}

.u-section-4 .u-text-5 {
  margin: 20px auto 0 0;
}

.u-section-4 .u-text-6 {
  margin: 20px 0 0;
}

@media (max-width: 1199px) {
  .u-section-4 .u-repeater-1 {
    grid-template-columns: repeat(3, 33.333333333333336%);
    min-height: 368px;
    grid-auto-columns: 33.333333333333336%;
  }

  .u-section-4 .u-image-1 {
    height: 173px;
  }

  .u-section-4 .u-image-2 {
    height: 173px;
  }

  .u-section-4 .u-image-3 {
    height: 173px;
  }
}

@media (max-width: 991px) {
  .u-section-4 .u-repeater-1 {
    grid-template-columns: repeat(2, 50%);
    min-height: 846px;
    grid-auto-columns: 50%;
  }

  .u-section-4 .u-image-1 {
    height: 205px;
  }

  .u-section-4 .u-image-2 {
    height: 205px;
  }

  .u-section-4 .u-image-3 {
    height: 205px;
  }
}

@media (max-width: 767px) {
  .u-section-4 .u-repeater-1 {
    grid-template-columns: 100%;
    grid-auto-columns: 100%;
  }

  .u-section-4 .u-container-layout-1 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-4 .u-image-1 {
    height: 355px;
  }

  .u-section-4 .u-container-layout-2 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-4 .u-image-2 {
    height: 355px;
  }

  .u-section-4 .u-container-layout-3 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-4 .u-image-3 {
    height: 355px;
  }
}

@media (max-width: 575px) {
  .u-section-4 .u-image-1 {
    height: 218px;
  }

  .u-section-4 .u-image-2 {
    height: 218px;
  }

  .u-section-4 .u-image-3 {
    height: 218px;
  }
}.u-section-5 .u-sheet-1 {
  min-height: 400px;
}

.u-section-5 .u-list-1 {
  grid-template-rows: repeat(1, auto);
  margin: 0 auto 0 20px;
}

.u-section-5 .u-repeater-1 {
  grid-template-columns: repeat(3, 33.3333%);
  min-height: 446px;
  --gap: 0px;
  grid-auto-columns: 33.3333%;
}

.u-section-5 .u-container-layout-1 {
  padding: 20px 30px;
}

.u-section-5 .u-image-1 {
  height: 319px;
  margin-top: 0;
  margin-bottom: 0;
}

.u-section-5 .u-text-1 {
  margin: 20px auto 0 0;
}

.u-section-5 .u-text-2 {
  margin: 20px 0 0;
}

.u-section-5 .u-container-layout-2 {
  padding: 20px 30px;
}

.u-section-5 .u-image-2 {
  height: 319px;
  margin-top: 0;
  margin-bottom: 0;
}

.u-section-5 .u-text-3 {
  margin: 20px auto 0 0;
}

.u-section-5 .u-text-4 {
  margin: 20px 0 0;
}

.u-section-5 .u-container-layout-3 {
  padding: 20px 30px;
}

.u-section-5 .u-image-3 {
  height: 319px;
  margin-top: 0;
  margin-bottom: 0;
}

.u-section-5 .u-text-5 {
  margin: 20px auto 0 0;
}

.u-section-5 .u-text-6 {
  margin: 20px 0 0;
}

@media (max-width: 1199px) {
  .u-section-5 .u-list-1 {
    margin-right: initial;
    margin-left: initial;
  }

  .u-section-5 .u-repeater-1 {
    grid-template-columns: repeat(3, 33.333333333333336%);
    min-height: 374px;
    grid-auto-columns: 33.333333333333336%;
  }

  .u-section-5 .u-image-1 {
    height: 173px;
  }

  .u-section-5 .u-image-2 {
    height: 173px;
  }

  .u-section-5 .u-image-3 {
    height: 173px;
  }
}

@media (max-width: 991px) {
  .u-section-5 .u-repeater-1 {
    grid-template-columns: repeat(2, 50%);
    min-height: 859px;
    grid-auto-columns: 50%;
  }

  .u-section-5 .u-image-1 {
    height: 205px;
  }

  .u-section-5 .u-image-2 {
    height: 205px;
  }

  .u-section-5 .u-image-3 {
    height: 205px;
  }
}

@media (max-width: 767px) {
  .u-section-5 .u-repeater-1 {
    grid-template-columns: 100%;
    grid-auto-columns: 100%;
  }

  .u-section-5 .u-container-layout-1 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-5 .u-image-1 {
    height: 355px;
  }

  .u-section-5 .u-container-layout-2 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-5 .u-image-2 {
    height: 355px;
  }

  .u-section-5 .u-container-layout-3 {
    padding-left: 10px;
    padding-right: 10px;
  }

  .u-section-5 .u-image-3 {
    height: 355px;
  }
}

@media (max-width: 575px) {
  .u-section-5 .u-image-1 {
    height: 218px;
  }

  .u-section-5 .u-image-2 {
    height: 218px;
  }

  .u-section-5 .u-image-3 {
    height: 218px;
  }

  .award-box {
  background: #ffffff;
  padding: 35px;
  border-radius: 15px;
  box-shadow: 0 15px 35px rgba(0,0,0,0.08);
}

.award-badge {
  display: inline-block;
  background: linear-gradient(45deg, #4a14ad, #7b3fe4);
  color: #fff;
  font-size: 12px;
  letter-spacing: 2px;
  padding: 8px 18px;
  border-radius: 30px;
  margin-bottom: 15px;
}

.citation {
  margin-bottom: 18px;
  line-height: 1.8;
  color: #444;
}

.date {
  margin-top: 25px;
  font-weight: 600;
  color: #4a14ad;
  font-size: 16px;
}

.location {
  color: #666;
  font-style: italic;
}

}


      </style>
    </head>
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Oswald:wght@200;300;400;500;600;700&amp;family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900">
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": ""}
</script>
    <meta name="theme-color" content="#277ed0">
    <meta property="og:title" content="Copy of Page 3">
    <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/"></head>
  <body data-home-page="https://website6618230.nicepage.io/Copy-of-Page-3.html?version=56156872-6601-43da-54cd-cb9fcf7ba56f" data-home-page-title="Copy of Page 3" data-path-to-root="./" data-include-products="false" class="u-body u-clearfix u-xl-mode" data-lang="en"> 
    <section class="u-clearfix u-section-1" id="sec-c5bb">
      <div class="u-clearfix u-sheet u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-sheet-1">
        <div class="u-expanded-width-xs u-palette-5-base u-shape u-shape-rectangle u-shape-1"></div>
        <div class="u-container-style u-group u-image u-image-tiles u-image-1" data-image-width="100" data-image-height="100">
          <div class="u-container-layout u-container-layout-1"></div>
        </div>
        <img src="images/618805846_122163660884853626_2706226786252513494_n.jpg" alt="" class="u-image u-image-default u-image-2" data-image-width="2048" data-image-height="1536">
        <div class="u-container-style u-group u-white u-group-2">
          <div class="u-container-layout u-valign-middle u-container-layout-2">
            <h2 class="u-text u-text-1">OLLSMPC&nbsp; Awards &amp; Recognition
            </h2>
          </div>
        </div>
        <div class="u-container-align-left u-container-style u-expanded-width-xs u-group u-group-3">
          <div class="u-container-layout u-valign-middle-lg u-valign-middle-md u-valign-middle-xs u-container-layout-3">
            <h3 class="u-align-left u-text u-text-2"> Celebrating Excellence, Trust, and Achievement<br>
            </h3>
            <p class="u-align-left u-text u-text-3"> Our commitment to quality, integrity, and continuous improvement has earned us recognition from respected organizations and industry partners. These awards reflect the trust of our clients, the dedication of our team, and our ongoing pursuit of excellence in everything we do.</p>
          </div>
        </div>
      </div>
    </section>
    <section class="u-clearfix u-container-align-center u-section-2" id="block-3">
      <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <div class="u-expanded-width u-list u-list-1">
          <div class="u-repeater u-repeater-1">
            <div class="u-container-align-left u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top-lg u-valign-top-md u-valign-top-sm u-valign-top-xs u-container-layout-1">
                <img alt="" class="u-expanded-width u-image u-image-default u-image-1" data-image-width="980" data-image-height="980" src="images/award10.png">
                <h4 class="u-align-left u-text u-text-default u-text-1">2023 Villar Awards</h4>
                <p class="u-align-left u-text u-text-2"> The 2023 Villar Awards on Poverty Reduction was conferred upon Our Lady of La Salette Multi-Purpose Cooperative in recognition of its sustained and impactful initiatives aimed at alleviating poverty. The award honors the Cooperative’s commitment to empowering communities through accessible financial services, livelihood support, and inclusive economic programs that promote long-term social and economic stability.</p>
              </div>
            </div>
            <div class="u-container-align-left u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top-lg u-valign-top-md u-valign-top-sm u-valign-top-xs u-container-layout-2">
                <img alt="" class="u-expanded-width u-image u-image-default u-image-2" data-image-width="980" data-image-height="980" src="images/award9.png">
                <h4 class="u-align-left u-text u-text-default u-text-3"> Plaque of Appreciation</h4>
                <p class="u-align-left u-text u-text-4"> This Plaque of Appreciation was awarded to Our Lady of La Salette Multi-Purpose Cooperative in acknowledgment of its invaluable support to cooperative programs and services. The Cooperative’s contributions significantly strengthened the federation’s growth, operational stability, and continued advancement in serving its member institutions.</p>
              </div>
            </div>
            <div class="u-container-align-left u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top-lg u-valign-top-md u-valign-top-sm u-valign-top-xs u-container-layout-3">
                <img alt="" class="u-expanded-width u-image u-image-default u-image-3" data-image-width="980" data-image-height="980" src="images/award8.png">
                <h4 class="u-align-left u-text u-text-default u-text-5"> Most Exemplary Proactive and Dynamic Cooperative of the year</h4>
                <p class="u-align-left u-text u-text-6"> This distinction was granted in recognition of the Cooperative’s proactive leadership, innovative initiatives, and dynamic service delivery. The award highlights its strong governance, financial stability, and active engagement in programs that promote cooperative development and member empowerment.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="u-clearfix u-section-3" id="block-7">
      <div class="u-clearfix u-sheet u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-sheet-1">
        <div class="custom-expanded data-layout-selected u-clearfix u-gutter-10 u-layout-wrap u-layout-wrap-1">
          <div class="u-layout">
            <div class="u-layout-col">
              <div class="u-size-30">
                <div class="u-layout-row">
                  <div class="u-container-style u-image u-layout-cell u-left-cell u-size-30 u-image-1"
     style="background-image: url('images/award2.png'); background-size: cover; background-position: center;"
     data-image-width="980"
     data-image-height="980">
  <div class="u-container-layout u-valign-middle u-container-layout-1"></div>
</div>
                  <div class="u-align-left u-container-align-left u-container-style u-layout-cell u-right-cell u-size-30 u-layout-cell-2">
                    <div class="u-container-layout u-container-layout-2">
                      <h2 class="u-text u-text-1"> Best in Membership Growth</h2>
                      <p class="u-text u-text-2"> Search for the Most Outstanding Cooperatives in Santiago City 2020, Our Lady of La Salette Multi-Purpose Cooperative - Best in Membership Growth. In commendation for its effort for the promotion of the cooperative movement having the most effective strategies for membership growth. Given this 27th day of October 2020 at San Andres Ampitheater Barangay San Andres, Santiago City.</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="u-size-30">
                <div class="u-layout-row">
                  <div class="u-align-right u-container-align-left u-container-style u-layout-cell u-left-cell u-size-30 u-layout-cell-3">
                    <div class="u-container-layout u-container-layout-3">
                      <h2 class="u-text u-text-3"> Best in Pandemic Resiliency Program</h2>
                      <p class="u-text u-text-4"> Search for the Most Outstanding Cooperatives in Santiago City 2020. Our Lady of La Salette Multi-Purpose Cooperative - Best in Pandemic Resiliency Program. In commendation for implementing effective programs in adaptation to the new normals caused by the COVID-19 pandemic towards resiliency and sustainability of the business of the cooperative. Given this 27th day of October 2020 at San Andres Ampitheater Barangay San Andres, Santiago City.</p>
                    </div>
                  </div>
                  <div class="u-container-style u-image u-layout-cell u-right-cell u-size-30 u-image-2"
     style="background-image: url('images/award11.png'); background-size: cover; background-position: center;"
     data-image-width="980"
     data-image-height="980">
  <div class="u-container-layout u-valign-middle u-container-layout-4"></div>
</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="u-clearfix u-section-4" id="block-4">
      <div class="u-clearfix u-sheet u-valign-middle-xl u-sheet-1">
        <div class="u-expanded-width u-list u-list-1">
          <div class="u-repeater u-repeater-1">
            <div class="u-container-align-left u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-container-layout-1">
                <img alt="" class="u-expanded-width u-image u-image-default u-image-1" data-image-width="980" data-image-height="980" src="images/award5.png">
                <h4 class="u-align-left u-text u-text-default u-text-1"> Champion in Search for the Most Outstanding Cooperatives in Santiago City</h4>
                <p class="u-align-left u-text u-text-2"> Our Lady of La Salette Multi-Purpose Cooperative was declared Champion for its exemplary performance and remarkable achievements as an institution advancing equity, social justice, and sustainable economic development. The award recognizes its outstanding operational excellence, community impact, and commitment to cooperative principles.</p>
              </div>
            </div>
            <div class="u-container-align-left u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-container-layout-2">
                <img alt="" class="u-expanded-width u-image u-image-default u-image-2" data-image-width="980" data-image-height="980" src="images/award6.png">
                <h4 class="u-align-left u-text u-text-default u-text-3"> Outstanding COVID-19 Volunteer Award</h4>
                <p class="u-align-left u-text u-text-4"> Presented by the Philippine National Volunteer Service Coordinating Agency, this award recognizes the Cooperative’s invaluable volunteer service and meaningful contributions to the nation’s response during the COVID-19 pandemic. The Cooperative demonstrated compassion, leadership, and social responsibility through active participation in relief and recovery initiatives.</p>
              </div>
            </div>
            <div class="u-container-align-left u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-container-layout-3">
                <img alt="" class="u-expanded-width u-image u-image-default u-image-3" data-image-width="980" data-image-height="980" src="images/award7.png">
                <h4 class="u-align-left u-text u-text-default u-text-5"> Gov. Faustino N. Dy, Sr. Hall of Fame Award</h4>
                <p class="u-align-left u-text u-text-6"> This prestigious Hall of Fame Award was conferred in recognition of the Cooperative’s consistent excellence in service delivery and governance. Having been declared Grand Winner for Outstanding Non-Agribased Cooperative for two consecutive years (2006 & 2007), the Cooperative demonstrated sustained competency, integrity, and a model standard of cooperative excellence worthy of emulation.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="u-clearfix u-section-5" id="block-5">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-expanded-width u-list u-list-1">
          <div class="u-repeater u-repeater-1">
            <div class="u-container-align-left u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-container-layout-1">
                <img alt="" class="u-expanded-width u-image u-image-default u-image-1" data-image-width="980" data-image-height="980" src="images/award3.png">
                <h4 class="u-align-left u-text u-text-default u-text-1"> Gov. Faustino N. Dy Sr. Awards</h4>
                <p class="u-align-left u-text u-text-2">This award honors the Cooperative’s dedicated years of excellent service and its implementation of innovative and best practices that significantly uplifted the lives of its members and the wider community. It acknowledges the Cooperative’s enduring commitment to sustainable development and member-centered growth.</p>
              </div>
            </div>
            <div class="u-container-align-left u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-container-layout-2">
                <img alt="" class="u-expanded-width u-image u-image-default u-image-2" data-image-width="980" data-image-height="980" src="images/award4.png">
                <h4 class="u-align-left u-text u-text-default u-text-3"> Most Outstanding Civil Society Organization (Cooperative Category)</h4>
                <p class="u-align-left u-text u-text-4">This recognition was awarded for the Cooperative’s unwavering commitment to public service and its substantial contribution to the socio-economic development of Santiago City. Its programs and initiatives have created measurable and lasting impact within the community.</p>
              </div>
            </div>
            <div class="u-container-align-left u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-container-layout-3">
                <img alt="" class="u-expanded-width u-image u-image-default u-image-3" data-image-width="980" data-image-height="980" src="images/award1.png">
                <h4 class="u-align-left u-text u-text-default u-text-5"> 2nd Runner Up in Search for the Most Outstanding Cooperatives in Santiago City 2020</h4>
                <p class="u-align-left u-text u-text-6">Our Lady of La Salette Multi-Purpose Cooperative was recognized as 2nd Runner-Up for its exemplary performance and sustained achievements in promoting equity, social justice, and sustainable economic growth. The award further acknowledged the Cooperative’s resilience and adaptability amid the challenges of the pandemic, exemplifying the theme of sustainability and institutional strength.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

 <footer id="footer" class="footer dark-background">

  <div class="container footer-top">
    <div class="row gy-4">

      <div class="col-lg-5 col-md-12 footer-about">
        <a href="index.html" class="logo d-flex align-items-center">
          <img src="https://tse2.mm.bing.net/th/id/OIP.AT9YKEwkahvV_Z8_Ph_SjgHaHa?rs=1&pid=ImgDetMain&o=7&rm=3" alt="OLLSMPC Logo">
          <span class="sitename">OLLSMPC</span>
        </a>

        <p>
          OLLSMPC is committed to providing reliable financial services,
          empowering members, and strengthening communities through
          cooperation, transparency, and integrity.
        </p>

        <div class="social-links d-flex mt-4">
          <a href="https://www.facebook.com/share/18Md4ovapL/"><i class="bi bi-facebook"></i></a>
          <a href="mailto:ollsmpc.helpdesk@gmail.com"><i class="bi bi-envelope"></i></a>
          <a href="tel:+639557047434"><i class="bi bi-telephone"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-6 footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="../about.php">About Us</a></li>
          <li><a href="../services.php">Services</a></li>
          <li><a href="../event.php">Events</a></li>
          <li><a href="../contact-submit.php">Contact</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-6 footer-links">
        <h4>Services</h4>
        <ul>
          <li><a href="services.ph">Savings Deposit</a></li>
          <li><a href="services.ph">Loan Services</a></li>
          <li><a href="services.ph">Specialized Loan Programs</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
        <h4>Contact Us</h4>
        <p>
          <strong>Phone:</strong>
          <span>(0977) 805-7365</span>
        </p>
        <p>
          <strong>Email:</strong>
          <span>ollsmpc.helpdesk@gmail.com</span>
        </p>
      </div>

    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>
      © <span>2026</span>
      <strong class="px-1 sitename">OLLSMPC</strong>
      <span>All Rights Reserved</span>
    </p>
  </div>
</footer>
 
</body>
</html>