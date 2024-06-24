<?php
include "connect.php";

// Check if a delete request was made
if (isset($_POST['delete'])) {
    $idToDelete = $_POST['id'];

    // Prepare the delete statement
    $deleteSql = "DELETE FROM studentregform WHERE id=?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $idToDelete);

    // Execute the delete statement
    if ($stmt->execute()) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

// Fetch the data to display
$sql = "SELECT * FROM studentregform";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div>";
    echo "<h2>Student Registration Form Data</h2>";
    echo "<img src='img/limK.jpg' alt='Image'>";
    echo "</div>";

    echo "<table border='1'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Full Name</th>";
    echo "<th>National ID</th>";
    echo "<th>Sponsorship Ref</th>";
    echo "<th>Faculty</th>";
    echo "<th>Program Name</th>";
    echo "<th>Intake</th>";
    echo "<th>Level/Year</th>";
    echo "<th>Semester</th>";
    echo "<th>Contact No</th>";
    echo "<th>Level/Award</th>";
    echo "<th>Sponsorship</th>";
    echo "<th>Student Signature</th>";
    echo "<th>Student Date</th>";
    echo "<th>Student Name</th>";
    echo "<th>Advisor Signature</th>";
    echo "<th>Advisor Date</th>";
    echo "<th>Advisor Name</th>";
    echo "<th>Academic Status</th>";
    echo "<th>Academic Signature</th>";
    echo "<th>Academic Date</th>";
    echo "<th>Academic Name</th>";
    echo "<th>Finance Status</th>";
    echo "<th>Finance Signature</th>";
    echo "<th>Finance Date</th>";
    echo "<th>Finance Name</th>";
    echo "<th>Registry Approval From Sponsor</th>";
    echo "<th>Registry Status</th>";
    echo "<th>Copy Filed</th>";
    echo "<th>Registry Signature</th>";
    echo "<th>Registry Date</th>";
    echo "<th>Registry Name</th>";
    echo "<th>Actions</th>"; // Update and delete buttons
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["fullName"]."</td>"; // Ensure this matches your database column name
        echo "<td>".$row["nationalID"]."</td>";
        echo "<td>".$row["sponsorshipRef"]."</td>";
        echo "<td>".$row["faculty"]."</td>";
        echo "<td>".$row["programName"]."</td>";
        echo "<td>".$row["intake"]."</td>";
        echo "<td>".$row["levelYear"]."</td>";
        echo "<td>".$row["semester"]."</td>";
        echo "<td>".$row["contactNo"]."</td>";
        echo "<td>".$row["levelAward"]."</td>";
        echo "<td>".$row["sponsorship"]."</td>";
        echo "<td>".$row["studentSignature"]."</td>";
        echo "<td>".$row["studentDate"]."</td>";
        echo "<td>".$row["studentName"]."</td>";
        echo "<td>".$row["advisorSignature"]."</td>";
        echo "<td>".$row["advisorDate"]."</td>";
        echo "<td>".$row["advisorName"]."</td>";
        echo "<td>".$row["academicStatus"]."</td>";
        echo "<td>".$row["academicSignature"]."</td>";
        echo "<td>".$row["academicDate"]."</td>";
        echo "<td>".$row["academicName"]."</td>";
        echo "<td>".$row["financeStatus"]."</td>";
        echo "<td>".$row["financeSignature"]."</td>";
        echo "<td>".$row["financeDate"]."</td>";
        echo "<td>".$row["financeName"]."</td>";
        echo "<td>".$row["registryApprovalFromSponsor"]."</td>";
        echo "<td>".$row["registryStatus"]."</td>";
        echo "<td>".$row["copyFiled"]."</td>";
        echo "<td>".$row["registrySignature"]."</td>";
        echo "<td>".$row["registryDate"]."</td>";
        echo "<td>".$row["registryName"]."</td>";
        echo "<td>";
        echo "<form method='post' action='update.php'>";
        echo "<input type='hidden' name='id' value='".$row["id"]."'>";
        echo "<input type='submit' name='update' value='Update'>";
        echo "</form>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='id' value='".$row["id"]."'>";
        echo "<input type='submit' name='delete' value='Delete'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>
