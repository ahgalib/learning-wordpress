document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('ufc-feedback-form');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Clear previous errors
        document.querySelectorAll('.ufc-error').forEach(el => el.textContent = '');

        // Get values
        const name = document.getElementById('ufc_name').value.trim();
        const email = document.getElementById('ufc_email').value.trim();
        const message = document.getElementById('ufc_message').value.trim();

        let hasError = false;

        if (name === '') {
            document.getElementById('ufc_name_error').textContent = 'Name is required.';
            hasError = true;
        }

        if (email === '') {
            document.getElementById('ufc_email_error').textContent = 'Email is required.';
            hasError = true;
        }

        if (message === '') {
            document.getElementById('ufc_message_error').textContent = 'Message is required.';
            hasError = true;
        }

        if (hasError) return;

        // Proceed to AJAX submission in next step
        alert('Form is valid! (AJAX submission coming next)');

         // Prepare form data
        const formData = new FormData();
        formData.append('action', 'ufc_submit_feedback'); // WordPress AJAX action
        formData.append('name', name);
        formData.append('email', email);
        formData.append('message', message);

        // Send AJAX request
        fetch(ufc_ajax_obj.ajax_url, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Thank you! Your feedback has been submitted.');
                form.reset();
            } else {
                alert('Submission failed: ' + data.data);
            }
        })
        .catch(err => {
            alert('Error submitting feedback.');
            console.error(err);
        });
    });


});
