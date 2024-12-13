<?php include_once("inc/header.php"); ?>

<div class="contact-container">
    <div class="contact-info">
        <h1>Contact Us</h1>
        <p>Have questions? We'd love to hear from you.</p>
        
        <div class="contact-details">
            <div class="contact-item">
                <i class="fa fa-map-marker"></i>
                <p>4135 Bd Industriel, Sherbrooke, QC J1L 2S7</p>
            </div>
            <div class="contact-item">
                <i class="fa fa-phone"></i>
                <p>+1 (514) 123-4567</p>
            </div>
            <div class="contact-item">
                <i class="fa fa-envelope"></i>
                <p>support@techshop.com</p>
            </div>
            <div class="contact-item">
                <i class="fa fa-clock-o"></i>
                <p>Monday - Friday: 9:00 AM - 8:00 PM</p>
                <p>Saturday - Sunday: 10:00 AM - 6:00 PM</p>
            </div>
        </div>
    </div>

    <div class="contact-form-container">
        <form class="contact-form" action="https://api.web3forms.com/submit" method="POST">
            <input type="hidden" name="access_key" value="e6ace6b0-ff34-45f0-b03c-58f40ecf48b3">

            <div class="form-group">
                <label for="name">Full Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address <span class="required">*</span></label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone">
            </div>

            <div class="form-group">
                <label for="subject">Subject <span class="required">*</span></label>
                <input type="text" id="subject" name="subject" required>
            </div>

            <div class="form-group">
                <label for="message">Message <span class="required">*</span></label>
                <textarea id="message" name="message" rows="6" required></textarea>
            </div>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>
</div>

<?php include_once("inc/footer.php"); ?>