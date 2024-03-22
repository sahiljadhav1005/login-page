function validateForm() {
    var username = document.getElementById("username").value.trim();
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value.trim();
    var confirmPassword = document.getElementById("confirm_password").value.trim();

    var usernameError = document.getElementById("usernameError");
    var emailError = document.getElementById("emailError");
    var passwordError = document.getElementById("passwordError");
    var confirmPasswordError = document.getElementById("confirmPasswordError");

    // Reset error messages
    usernameError.textContent = "";
    emailError.textContent = "";
    passwordError.textContent = "";
    confirmPasswordError.textContent = "";

    var isValid = true;

    // Validating username
    if (username === "") {
        usernameError.textContent = "Username is required";
        isValid = false;
    } else if (!isValidUsername(username)) {
        usernameError.textContent = "Username can only contain letters, numbers, and underscores";
        isValid = false;
    }

    // Validating email
    if (email === "") {
        emailError.textContent = "Email is required";
        isValid = false;
    } else if (!isValidEmail(email)) {
        emailError.textContent = "Invalid email format";
        isValid = false;
    }

    // Validating password
    if (password === "") {
        passwordError.textContent = "Password is required";
        isValid = false;
    } else if (password.length < 8) {
        passwordError.textContent = "Password must be at least 8 characters long";
        isValid = false;
    } else if (!isValidPassword(password)) {
        passwordError.textContent = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character";
        isValid = false;
    }

    // Validating confirm password
    if (confirmPassword === "") {
        confirmPasswordError.textContent = "Confirm Password is required";
        isValid = false;
    } else if (password !== confirmPassword) {
        confirmPasswordError.textContent = "Passwords do not match";
        document.getElementById("password").value = ""; // Clear password field
        document.getElementById("confirm_password").value = ""; // Clear confirm password field
        document.getElementById("password").focus(); // Focus on password field
        isValid = false;
    }

    return isValid;
}

function isValidEmail(email) {
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function isValidUsername(username) {
    var usernamePattern = /^[a-zA-Z0-9_]+$/;
    return usernamePattern.test(username);
}

function isValidPassword(password) {
    // Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character
    var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return passwordPattern.test(password);
}
