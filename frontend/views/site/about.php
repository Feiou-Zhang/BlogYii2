<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Resume';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<link rel="stylesheet" href="css/reset.min.css">-->
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="css/resume.css">
<div class="resume-wrapper">
    <section class="profile section-padding">
        <div class="resume-container">
            <div class="picture-resume-wrapper">
                <div class="picture-resume">
                    <span><img src="img/feiou.jpg" alt="" /></span>
                    <svg version="1.1" viewBox="0 0 350 350">

                        <defs>
                            <filter id="goo">
                                <feGaussianBlur in="SourceGraphic" stdDeviation="8" result="blur" />
                                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 21 -9" result="cm" />
                            </filter>
                        </defs>


                        <g filter="url(#goo)" >

                            <circle id="main_circle" class="st0" cx="171.5" cy="175.6" r="130"/>

                            <circle id="circle" class="bubble0 st1" cx="171.5" cy="175.6" r="122.7"/>
                            <circle id="circle" class="bubble1 st1" cx="171.5" cy="175.6" r="122.7"/>
                            <circle id="circle" class="bubble2 st1" cx="171.5" cy="175.6" r="122.7"/>
                            <circle id="circle" class="bubble3 st1" cx="171.5" cy="175.6" r="122.7"/>
                            <circle id="circle" class="bubble4 st1" cx="171.5" cy="175.6" r="122.7"/>
                            <circle id="circle" class="bubble5 st1" cx="171.5" cy="175.6" r="122.7"/>
                            <circle id="circle" class="bubble6 st1" cx="171.5" cy="175.6" r="122.7"/>
                            <circle id="circle" class="bubble7 st1" cx="171.5" cy="175.6" r="122.7"/>
                            <circle id="circle" class="bubble8 st1" cx="171.5" cy="175.6" r="122.7"/>
                            <circle id="circle" class="bubble9 st1" cx="171.5" cy="175.6" r="122.7"/>
                            <circle id="circle" class="bubble10 st1" cx="171.5" cy="175.6" r="122.7"/>

                        </g>
                    </svg>
                </div>
<div class="clearfix"></div>
</div>
<div class="resume-name-wrapper">
    <h1>Feiou Zhang</h1>
</div>
<div class="clearfix"></div>
<div class="contact-info clearfix">
    <ul class="list-titles">
        <li>Mail</li>
        <li>Web</li>
        <li>Home</li>
    </ul>
    <ul class="list-content ">
        <li>feiou.zhang@hotmail.com</li>
        <li><a href="https://zhangfeiou.com">zhangfeiou.com</a></li> <!-- YOUR WEBSITE  -->
        <li>San Antonio, TX</li> <!-- YOUR STATE AND COUNTRY  -->
    </ul>
</div>
<div class="contact-presentation"> <!-- YOUR PRESENTATION RESUME  -->
    <p>A quick learner and problem solver. Committed to deliver high quality code. Always willing to take on challenges. Efficient communicator and team player. Learning is just one of my hobby.</p>
</div>
<div class="contact-social clearfix">
    <ul class="list-titles">
        <li>Linkedin</li>
        <li>Github</li>
    </ul>
    <ul class="list-content"> <!-- REMEMBER TO PUT THE URL ON THE HREF TAG  -->
        <li><a href="https://www.linkedin.com/in/feiouzhang/">Feiou Zhang</a></li>
        <li><a href="https://github.com/Feiou-Zhang">Feiou-Zhang</a></li>

    </ul>
</div>
</div>
</section>

<section class="experience section-padding">
    <div class="resume-container">
        <h3 class="experience-title">Experience</h3>

        <div class="experience-wrapper">
            <div class="company-wrapper clearfix">
                <div class="experience-title">Harland Clarke</div>
                <div class="time">Jun 2017 - Present</div>
            </div>

            <div class="job-wrapper clearfix">
                <div class="experience-title">Software Engineering Intern</div>
                <div class="company-description">
                    <p>Coming soon...</p>  <!-- JOB DESCRIPTION  -->
                </div>
            </div>

            <div class="company-wrapper clearfix">
                <div class="experience-title">Sirius Computer Solutions</div> <!-- NAME OF THE COMPANY YOUWORK WITH  -->
                <div class="time">Apr 2016 - Feb 2016</div> <!-- THE TIME YOU WORK WITH THE COMPANY  -->
            </div>

            <div class="job-wrapper clearfix">
                <div class="experience-title">IT Associate</div> <!-- JOB TITLE  -->
                <div class="company-description">
                    <p>Migrated reports from the exicting system to IBM Cognos, Developed, redesigned, documented, and maintained IBM Cognos reports.</p>  <!-- JOB DESCRIPTION  -->
                </div>
            </div>

            <div class="company-wrapper clearfix">
                <div class="experience-title">UTSA</div> <!-- NAME OF THE COMPANY YOUWORK WITH  -->
                <div class="time">Jun 2014 - Dec 2014</div> <!-- THE TIME YOU WORK WITH THE COMPANY  -->
            </div>

            <div class="job-wrapper clearfix">
                <div class="experience-title">Java Tutor </div> <!-- JOB TITLE  -->
                <div class="company-description">
                    <p>Tutored Java labs for Java beginners to intermediate level. Constructed fundamental concepts, logic control, instantiate of classes and classic data structures.  </p>   <!-- JOB DESCRIPTION  -->
                </div>
            </div>

        </div><!--Skill experience-->

        <div class="section-wrapper clearfix">
            <h3 class="section-title">Skills</h3>  <!-- YOUR SET OF SKILLS  -->
            <ul>
                <li class="skill-percentage">Java</li>
                <li class="skill-percentage">HTML/CSS</li>
                <li class="skill-percentage">Javascript</li>
                <li class="skill-percentage">Linux</li>
                <li class="skill-percentage">PHP</li>
                <li class="skill-percentage">SQL</li>

            </ul>

        </div>

        <div class="section-wrapper clearfix">
            <h3 class="section-title">Education and Activity</h3>
            <p>The University of Texas at San Antonio</p>
            <br/>
            <p>Master of Science in Information Technology, Expected Graduation: December 2017, GPA:4.00</p>
            <br/>
            <p>BBA in Information System, Graduated with Magna cum Laude Honor: December 2014, GPA: 3.81</p>
            <br/>
            <p>President of Badminton Club, August 2016 – Present</p>

        </div>

    </div>
</section>

<div class="clearfix"></div>
</div>
<script src='js/TweenMax.min.js'></script>

<script src="js/resume.js"></script>