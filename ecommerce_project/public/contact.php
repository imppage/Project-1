<?php include('../includes/header.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary">Contact Us</h2>

    <div class="row">
        <!-- Contact Information -->
        <div class="col-md-6">
            <h4 class="text-info">Contact Information</h4>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Email:</strong> TreasureGifts@gmail.com</li>
                <li class="list-group-item"><strong>Phone:</strong> 01-4263876, 01-4473645</li>
                <li class="list-group-item"><strong>Address:</strong> Sanepa, Lalitpur</li>
            </ul>

            <h4 class="text-success">Our Location</h4>
            <!-- Optional: Embed Google Map -->
            <div class="embed-responsive embed-responsive-16by9 mb-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2976.3991672298307!2d85.30240327353621!3d27.68526937387461!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb190dbf2aebcd%3A0x5ad4b845ab34f7fa!2sSanepa%20khari%20ko%20bot!5e1!3m2!1sen!2sus!4v1732765232275!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <!-- Message Form -->
        <div class="col-md-6">
            <h4 class="text-warning">Send Us a Message</h4>
            <form method="POST" action="send_message.php">
                <div class="form-group">
                    <label for="name" class="text-primary">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email" class="text-primary">Your Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message" class="text-primary">Your Message</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-danger btn-block">Send Message</button>
            </form>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
