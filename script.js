// Contact Form Validation & Submission
document.addEventListener("DOMContentLoaded", () => {
    const contactForm = document.getElementById("contactForm");

    contactForm?.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        // Trim values
        const fname = contactForm.fname.value.trim();
        const lname = contactForm.lname.value.trim();
        const phone = contactForm.phone.value.trim();
        const email = contactForm.email.value.trim();
        const requirement = contactForm.requirement.value;

        // Basic validation
        if (!fname || !lname || !phone || !email || !requirement) {
            alert("⚠️ Please fill in all required fields.");
            return;
        }

        if (!/^\d{10}$/.test(phone)) {
            alert("⚠️ Enter a valid 10-digit phone number.");
            return;
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            alert("⚠️ Enter a valid email address.");
            return;
        }

        // Success message
        alert(`✅ Thank you, ${fname}! Your form has been submitted.`);

        // Submit form to PHP backend
        contactForm.submit();
    });
});
