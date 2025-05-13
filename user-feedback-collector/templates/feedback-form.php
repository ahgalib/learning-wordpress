<div class="ufc-feedback-form-wrapper">
    <form id="ufc-feedback-form" enctype="multipart/form-data">
        <p>
            <label for="ufc_name">Your Name:</label><br>
            <input type="text" name="ufc_name" id="ufc_name">
        <div class="ufc-error" id="ufc_name_error" style="color:red;"></div>
        </p>
        <p>
            <label for="ufc_email">Your Email:</label><br>
            <input type="email" name="ufc_email" id="ufc_email">
        <div class="ufc-error" id="ufc_email_error" style="color:red;"></div>
        </p>
        <p>
            <label for="ufc_message">Your Feedback:</label><br>
            <textarea name="ufc_message" id="ufc_message" rows="5"></textarea>
        </p>
        <p>
            <label for="ufc_screenshot">Screenshot (optional):</label><br>
            <input type="file" name="ufc_screenshot" id="ufc_screenshot" accept="image/*">
        </p>
        <p>
            <button type="submit">Submit Feedback</button>
        </p>
    </form>
</div>