<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .eye-icon {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        .input-container {
            position: relative;
            display: flex;
            align-items: center;
        }
    </style>
    <script>
        function clearPlaceholder(input) {
            input.placeholder = '';
        }

        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.textContent = "🙈";
            } else {
                input.type = "password";
                icon.textContent = "👁";
            }
        }
    </script>
</head>
<body>
    <div class="registration-container">
        <img style="align-items: center;" src="img/limk.jpg" alt="Logo">

        <h2 style="text-align: center;">Users Form</h2>
        <form method="POST" action="signup_config.php"> 
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder=" John Doe" onfocus="clearPlaceholder(this)" required><br>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="johndoe@example.com" onfocus="clearPlaceholder(this)" required><br>
            
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="birth" placeholder=" DD/MM/YYYY" onfocus="clearPlaceholder(this)" required><br>
            
            <label for="faculty">Faculty Study/Lecture</label>
            <input type="text" id="faculty" name="falstudylec" placeholder=" Faculty of Engineering" onfocus="clearPlaceholder(this)" required><br>
            
            <label for="student-id">Student ID/ Lecturer Code Number</label>
            <input type="text" id="student-id" name="studentidleccode" placeholder=" LKW123456" onfocus="clearPlaceholder(this)" required><br>
            
            <label for="program">Program Study or Lecture</label>
            <input type="text" id="program" name="pstudylec" placeholder="Bsc Hons In Software Engineering and Multimedia" onfocus="clearPlaceholder(this)" required><br>
            
            <label for="semester">Semesters Study/ Lecture</label>
            <input type="text" id="semester" name="semstudylec" placeholder=" Semester 1, Year 1" onfocus="clearPlaceholder(this)" required><br>
            
            <label for="password">Password</label>
            <div class="input-container">
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <span class="eye-icon" id="toggle-password" onclick="togglePasswordVisibility('password', 'toggle-password')">👁</span>
            </div>
            
            <label for="confirm-password">Confirm Password</label>
            <div class="input-container">
                <input type="password" id="confirm-password" name="compass" placeholder="Confirm your password" required>
                <span class="eye-icon" id="toggle-confirm-password" onclick="togglePasswordVisibility('confirm-password', 'toggle-confirm-password')">👁</span>
            </div>






            

            <label for="role">Register as:</label>
            <select id="role" name="regas">
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
            </select>
            
            <button type="submit" name="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>