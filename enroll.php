<?php
session_start();
include "connect.php";

if (isset($_POST['submit'])) {
    // Section 1: Application Information
    $fullName = $_POST['fullName'];
    $nationalID = $_POST['nationalID'];
    $sponsorshipRef = $_POST['sponsorshipRef'];
    $faculty = $_POST['faculty'];
    $programName = $_POST['programName'];
    $intake = $_POST['intake'];
    $levelYear = $_POST['levelYear'];
    $semester = $_POST['semester'];
    $contactNo = $_POST['contactNo'];

    // Section 2: Level/Award
    $levelAward = $_POST['levelAward'];

    // Section 3: Sponsorship
    $sponsorship = $_POST['sponsorship'];

    // Section 4: To be completed with the Course Advisor or Year Leader
    $courseData = [];
    for ($i = 1; $i <= $_POST['courseCount']; $i++) {
        $moduleCode = $_POST['moduleCode' . $i];
        $moduleName = $_POST['moduleName' . $i];
        $moduleStatus = $_POST['moduleStatus' . $i];
        $credits = $_POST['credits' . $i];
        $courseData[] = [$moduleCode, $moduleName, $moduleStatus, $credits];
    }

    // Section 5: Student's Declaration
    $studentSignature = $_POST['studentSignature'];
    $studentDate = $_POST['studentDate'];
    $studentName = $_POST['studentName'];

    // Section 6: Course Advisor/Year Leader
    $advisorSignature = $_POST['advisorSignature'];
    $advisorDate = $_POST['advisorDate'];
    $advisorName = $_POST['advisorName'];

    // Section 7: Academic Department
    $academicStatus = $_POST['academicStatus'];
    $academicSignature = $_POST['academicSignature'];
    $academicDate = $_POST['academicDate'];
    $academicName = $_POST['academicName'];

    // Section 8: Finance
    $financeStatus = $_POST['financeStatus'];
    $financeSignature = $_POST['financeSignature'];
    $financeDate = $_POST['financeDate'];
    $financeName = $_POST['financeName'];

    // Section 9: Registry Department
    $registryApprovalFromSponsor = $_POST['registryApprovalFromSponsor'];
    $registryStatus = $_POST['registryStatus'];
    $copyFiled = $_POST['copyFiled'];
    $registrySignature = $_POST['registrySignature'];
    $registryDate = $_POST['registryDate'];
    $registryName = $_POST['registryName'];

    // Insert student data
    $sql = "INSERT INTO studentregform (fullName, nationalID, sponsorshipRef, faculty, programName, intake, levelYear, semester, contactNo, levelAward, sponsorship, studentSignature, studentDate, studentName, advisorSignature, advisorDate, advisorName, academicStatus, academicSignature, academicDate, academicName, financeStatus, financeSignature, financeDate, financeName, registryApprovalFromSponsor, registryStatus, copyFiled, registrySignature, registryDate, registryName) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssssssssssssssssss", $fullName, $nationalID, $sponsorshipRef, $faculty, $programName, $intake, $levelYear, $semester, $contactNo, $levelAward, $sponsorship, $studentSignature, $studentDate, $studentName, $advisorSignature, $advisorDate, $advisorName, $academicStatus, $academicSignature, $academicDate, $academicName, $financeStatus, $financeSignature, $financeDate, $financeName, $registryApprovalFromSponsor, $registryStatus, $copyFiled, $registrySignature, $registryDate, $registryName);
    $result = $stmt->execute();

    if ($result) {
        $lastInsertId = $stmt->insert_id;
        $stmt->close();

        // Insert course data
        $courseSql = "INSERT INTO course (studentRegFormId, moduleCode, moduleName, moduleStatus, credits) VALUES (?, ?, ?, ?, ?)";
        $courseStmt = $conn->prepare($courseSql);
        foreach ($courseData as $course) {
            $courseStmt->bind_param("isssi", $lastInsertId, $course[0], $course[1], $course[2], $course[3]);
            $courseResult = $courseStmt->execute();
            if (!$courseResult) {
                die("Error inserting course data: " . $courseStmt->error);
            }
        }
        $courseStmt->close();

        echo "<script>alert('Registration successful'); window.location.href='enrol.php';</script>";
    } else {
        die("Error inserting student data: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Course Advising Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }
        h1, h2 {
            text-align: center;
        }
        h2 {
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
        }
        input[type="text"], input[type="date"], input[type="email"], input[type="password"], select {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 100%;
        }
        .input-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .eye-icon {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
    <script>
        let courseCount = 1; // Keep track of the number of course sections

        function addCourseSection() {
            courseCount++; // Increment the course count
            const tbody = document.getElementById('courseTable').getElementsByTagName('tbody')[0];
            const newRow = tbody.insertRow();
            newRow.innerHTML = `
                <td>${courseCount}</td>
                <td><input type="text" name="moduleCode${courseCount}" placeholder="Module Code" required></td>
                <td><input type="text" name="moduleName${courseCount}" placeholder="Module Name" required></td>
                <td><input type="text" name="moduleStatus${courseCount}" placeholder="Module Status" required></td>
                <td><input type="text" name="credits${courseCount}" placeholder="Credits" required></td>
            `;
            document.getElementById('courseCount').value = courseCount;
        }
    </script>
</head>
<body>
    <div class="container">
        <img style="display: block; margin: 0 auto;" src="img/limk.jpg" alt="Logo">

        <h1>Registration Course Advising Form</h1>

        <form method="POST" action="enroll.php">
            <h2>Section 1: Application Information</h2>
            <label for="fullName">Full Name(s)</label>
            <input type="text" id="fullName" name="fullName" placeholder="John Doe" onfocus="clearPlaceholder(this)" required>
            
            <label for="nationalID">National ID No.</label>
            <input type="text" id="nationalID" name="nationalID" placeholder="1234567890" onfocus="clearPlaceholder(this)" required>
            
            <label for="sponsorshipRef">Sponsorship Ref.</label>
            <input type="text" id="sponsorshipRef" name="sponsorshipRef" placeholder="Sponsorship Reference" onfocus="clearPlaceholder(this)" required>
            
            <label for="faculty">Faculty</label>
            <input type="text" id="faculty" name="faculty" placeholder="Faculty of Computer Science" onfocus="clearPlaceholder(this)" required>
            
            <label for="programName">Program Name</label>
            <input type="text" id="programName" name="programName" placeholder="BSc Computer Science" onfocus="clearPlaceholder(this)" required>
            
            <label for="intake">Intake</label>
            <input type="text" id="intake" name="intake" placeholder="January 2024" onfocus="clearPlaceholder(this)" required>
            
            <label for="levelYear">Level/Year</label>
            <input type="text" id="levelYear" name="levelYear" placeholder="Year 1" onfocus="clearPlaceholder(this)" required>
            
            <label for="semester">Semester</label>
            <input type="text" id="semester" name="semester" placeholder="Semester 1" onfocus="clearPlaceholder(this)" required>
            
            <label for="contactNo">Contact No.</label>
            <input type="text" id="contactNo" name="contactNo" placeholder="+232 79 123456" onfocus="clearPlaceholder(this)" required>

            <h2>Section 2: Level/Award</h2>
            <label for="levelAward">Level/Award</label>
            <input type="text" id="levelAward" name="levelAward" placeholder="Certificate/Diploma/Degree" onfocus="clearPlaceholder(this)" required>

            <h2>Section 3: Sponsorship</h2>
            <label for="sponsorship">Sponsorship</label>
            <input type="text" id="sponsorship" name="sponsorship" placeholder="Scholarship/Private" onfocus="clearPlaceholder(this)" required>

            <h2>Section 4: To be completed with the Course Advisor or Year Leader</h2>
            <table id="courseTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Module Code</th>
                        <th>Module Name</th>
                        <th>Module Status</th>
                        <th>Credits</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><input type="text" name="moduleCode1" placeholder="Module Code" required></td>
                        <td><input type="text" name="moduleName1" placeholder="Module Name" required></td>
                        <td><input type="text" name="moduleStatus1" placeholder="Module Status" required></td>
                        <td><input type="text" name="credits1" placeholder="Credits" required></td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" id="courseCount" name="courseCount" value="1">
            <button type="button" onclick="addCourseSection()">Add Course</button>

            <h2>Section 5: Student's Declaration</h2>
            <label for="studentSignature">Signature of Student</label>
            <input type="text" id="studentSignature" name="studentSignature" placeholder="Signature" onfocus="clearPlaceholder(this)" required>
            
            <label for="studentDate">Date</label>
            <input type="date" id="studentDate" name="studentDate" required>
            
            <label for="studentName">Name</label>
            <input type="text" id="studentName" name="studentName" placeholder="John Doe" onfocus="clearPlaceholder(this)" required>

            <h2>Section 6: Course Advisor/Year Leader</h2>
            <label for="advisorSignature">Signature of Course Advisor/Year Leader</label>
            <input type="text" id="advisorSignature" name="advisorSignature" placeholder="Signature" onfocus="clearPlaceholder(this)" required>
            
            <label for="advisorDate">Date</label>
            <input type="date" id="advisorDate" name="advisorDate" required>
            
            <label for="advisorName">Name</label>
            <input type="text" id="advisorName" name="advisorName" placeholder="Advisor Name" onfocus="clearPlaceholder(this)" required>

            <h2>Section 7: Academic Department</h2>
            <label for="academicStatus">Status</label>
            <input type="text" id="academicStatus" name="academicStatus" placeholder="Status" onfocus="clearPlaceholder(this)" required>
            
            <label for="academicSignature">Signature of Head of Academic Department</label>
            <input type="text" id="academicSignature" name="academicSignature" placeholder="Signature" onfocus="clearPlaceholder(this)" required>
            
            <label for="academicDate">Date</label>
            <input type="date" id="academicDate" name="academicDate" required>
            
            <label for="academicName">Name</label>
            <input type="text" id="academicName" name="academicName" placeholder="Academic Head Name" onfocus="clearPlaceholder(this)" required>

            <h2>Section 8: Finance</h2>
            <label for="financeStatus">Status</label>
            <input type="text" id="financeStatus" name="financeStatus" placeholder="Status" onfocus="clearPlaceholder(this)" required>
            
            <label for="financeSignature">Signature of Finance Manager</label>
            <input type="text" id="financeSignature" name="financeSignature" placeholder="Signature" onfocus="clearPlaceholder(this)" required>
            
            <label for="financeDate">Date</label>
            <input type="date" id="financeDate" name="financeDate" required>
            
            <label for="financeName">Name</label>
            <input type="text" id="financeName" name="financeName" placeholder="Finance Manager Name" onfocus="clearPlaceholder(this)" required>

            <h2>Section 9: Registry Department</h2>
            <label for="registryApprovalFromSponsor">Approval from Sponsor</label>
            <input type="text" id="registryApprovalFromSponsor" name="registryApprovalFromSponsor" placeholder="Approval Status" onfocus="clearPlaceholder(this)" required>
            
            <label for="registryStatus">Status</label>
            <input type="text" id="registryStatus" name="registryStatus" placeholder="Status" onfocus="clearPlaceholder(this)" required>
            
            <label for="copyFiled">Copy Filed</label>
            <input type="text" id="copyFiled" name="copyFiled" placeholder="Copy Filed Status" onfocus="clearPlaceholder(this)" required>
            
            <label for="registrySignature">Signature of Registrar</label>
            <input type="text" id="registrySignature" name="registrySignature" placeholder="Signature" onfocus="clearPlaceholder(this)" required>
            
            <label for="registryDate">Date</label>
            <input type="date" id="registryDate" name="registryDate" required>
            
            <label for="registryName">Name</label>
            <input type="text" id="registryName" name="registryName" placeholder="Registrar Name" onfocus="clearPlaceholder(this)" required>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>