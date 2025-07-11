
<?php include "header.php"; ?>

<section id="terms-of-service" class="terms-of-service section">
<div class="row mt-5 mb-5 justify-content-center">
<div class="col-lg-6 text-justify">
    <h2>Become a Trainer</h2>
   <P> In the digital age, the demand for quality online education is skyrocketing. Learnora.ng, a leading Nigerian e-learning platform, offers educators the opportunity to share their expertise and make a significant impact. Here's how you can become a trainer on Learnora.ng and what benefits await you.</p>

<P>Learnora.ng is designed to bridge the educational gap by providing accessible and quality learning experiences. As a trainer, you'll be part of a community dedicated to transforming education in Nigeria and beyond. The platform supports various subjects, from technology and business to arts and sciences, catering to a diverse learner base.</p>

    
    <h3>Steps to Become a Trainer</h3>
   <ol>
  <li><strong>Visit the Website:</strong> Go to Learnora.ng and navigate to the 'Become a Trainer' section.</li>
  <li><strong>Create an Account:</strong> Sign up by providing your details and verifying your email address.</li>
  <li><strong>Submit Your Application:</strong> Fill out the application form with information about your qualifications, experience, and the courses you wish to offer.</li>
  <li><strong>Course Approval:</strong> Once your application is reviewed and approved, you'll gain access to the course creation tools.</li>
  <li><strong>Publish and Promote:</strong> After developing your course content, publish it on the platform and promote it to attract learners.</li>
</ol>

<h3>Benefits of Teaching on Learnora.ng</h3>
<ul>
  <li><strong>Global Reach:</strong> Connect with learners from across Nigeria and the globe.</li>
  <li><strong>Flexible Scheduling:</strong> Offer courses that fit your schedule, whether live sessions or pre-recorded content.</li>
  <li><strong>Monetization Opportunities:</strong> Earn revenue through course enrolments and premium content.</li>
  <li><strong>Supportive Community:</strong> Join a network of educators and professionals committed to continuous learning and development.</li>
</ul>
<div class="tos-contact" data-aos="fade-up" data-aos-delay="300">
          <div class="contact-box">
            
            <div class="contact-content">
             
              <p>Becoming a trainer on Learnora.ng is more than just teaching; it's about shaping the future of education. If you're passionate about sharing your knowledge and making a difference, this is your opportunity to inspire and educate the next generation of learners. </p>
             <?php if ($active_log == 0): ?>
    <a href="register-trainer.php" class="contact-link">Become a Trainer</a>

<?php elseif ($active_log == 1 && $trainer == 1): ?>
    <a href="dashboard.php" class="contact-link">Go to Dashboard</a>

<?php else: ?>
    <a href="settings.php" class="contact-link">Upgrade to a Trainer</a>
<?php endif; ?>
            </div>
          </div>
        </div>
</div>

    
</div>

 
</section>



<?php include "footer.php"; ?>