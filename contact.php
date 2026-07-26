<?php
require_once __DIR__ . '../config/db.php';
require_once __DIR__ . '../config/config.php';
require_once __DIR__ . '../includes/functions.php';
?>

<?php require_once __DIR__ . '../includes/header.php'; ?>


<div class="staticblog-container">
<div class="staticblog-heading">Contact Us – TechSolNews.com</div>
<div class="staticblog-paragraph">
We'd love to hear from you! Whether you have a news tip, a question, feedback, a business inquiry, or would like to report an issue, the TechSolNews.com team is here to help.
TechSolNews.com is your trusted destination for technology, society, culture, government updates, and modern digital awareness.
At TechSolNews.com, we believe that news should not only inform people but also inspire awareness, knowledge, and positive thinking. We value every message from our readers and strive to respond as quickly as possible.
</div>
<div class="staticblog-subtopic">Contact form</div>
<div class="staticblog-paragraph">
<div class="container-form">
<div class="title-form">Please use the contact form below to reach out to us.</div>
<p class="form-desc">Please fill this form.</p>
  <form class="form-box" method="POST" action="/auth/contactform.php" onsubmit="return validateForm()">
    <input type="text" name="name" placeholder="John Doe" required>
    <input type="email" name="email" placeholder="Email" required>
    <textarea name="message" placeholder="Your Message" required></textarea>
    <button type="submit" name="submit" class="formbtn">Send Message</button>
  </form>
</div>
</div>
<div class="staticblog-subtopic">Our Email</div>
<div class="staticblog-paragraph">
<a href="mailto:help@techsolnews.com">help@techsolnews.com</a>
</div>
<div class="staticblog-subtopic">News Tips</div>
<div class="staticblog-paragraph">
Have a breaking story, technology update, government announcement, or community news worth sharing?
Send your information through our contact form or email us. We carefully review all submissions before publication.
</div>
<div class="staticblog-subtopic">Privacy Notice</div>
<div class="staticblog-paragraph">
The information you submit through this page is used solely to respond to your inquiry.
We respect your privacy and do not sell or share your personal information except where required by law.
Please avoid sending sensitive or confidential information through the contact form.
</div>
<div class="staticblog-subtopic">Thank You</div>
<div class="staticblog-paragraph">
Thank you for visiting TechSolNews.com.
We appreciate your trust and support as we continue delivering reliable news, 
insightful articles, and valuable information that empowers our readers in an ever-changing digital world.
</div>
<div class="staticblog-list">
<ul>
<li>General Questions - Ask about our website, articles, or services.</li>
<li>News Tips - Share breaking news, technology updates, government announcements, or community stories.</li>
<li>Corrections & Feedback - Report errors, suggest improvements, or provide constructive feedback.</li>
<li>Business Inquiries - Contact us for advertising, sponsorships, partnerships, guest posts, or media collaborations.</li>
<li>Technical Issues - Report website bugs, broken links, security concerns, or other technical problems.</li>
</ul>
</div>
</div>
</div>

<?php require_once __DIR__ . '../includes/footer.php'; ?>
