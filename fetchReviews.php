<?php
include('./database/connection.php');
session_start();

// Select from review table
$query = "SELECT * FROM review ORDER BY review_id DESC";
$result = $connect->query($query);

$output = '';
if ($result->num_rows > 0) {
    $total_rating = 0;
    $total_review = 0;
    $five_star_review = 0;
    $four_star_review = 0;
    $three_star_review = 0;
    $two_star_review = 0;
    $one_star_review = 0;

    while ($row = $result->fetch_assoc()) {
        $output .= '
        <div class="border mb-2 p-2">
            <strong>' . htmlspecialchars($row['name']) . '</strong>
            <div class="text-warning">';

        for ($count = 0; $count < $row['rating']; $count++) {
            $output .= '<i class="fas fa-star"></i>';
        }
        $output .= '</div>
            <p>' . htmlspecialchars($row['content']) . '</p>
        </div>';
        
        // Count each rating type
        switch ($row['rating']) {
            case 5: $five_star_review++; break;
            case 4: $four_star_review++; break;
            case 3: $three_star_review++; break;
            case 2: $two_star_review++; break;
            case 1: $one_star_review++; break;
        }
        $total_rating += $row['rating'];
        $total_review++;
    }

    // Calculate average rating
    $average_rating = $total_review > 0 ? number_format($total_rating / $total_review, 1) : 0;

    // Pass calculated values to JavaScript for display
    $output .= '
    <script>
        document.getElementById("average_rating").textContent = "' . $average_rating . '";
        document.getElementById("total_review").textContent = "' . $total_review . '";
        document.getElementById("total_five_star_review").textContent = "' . $five_star_review . '";
        document.getElementById("total_four_star_review").textContent = "' . $four_star_review . '";
        document.getElementById("total_three_star_review").textContent = "' . $three_star_review . '";
        document.getElementById("total_two_star_review").textContent = "' . $two_star_review . '";
        document.getElementById("total_one_star_review").textContent = "' . $one_star_review . '";

        // Calculate progress bars as percentages
        document.getElementById("five_star_progress").style.width = "' . (($five_star_review / $total_review) * 100) . '%";
        document.getElementById("four_star_progress").style.width = "' . (($four_star_review / $total_review) * 100) . '%";
        document.getElementById("three_star_progress").style.width = "' . (($three_star_review / $total_review) * 100) . '%";
        document.getElementById("two_star_progress").style.width = "' . (($two_star_review / $total_review) * 100) . '%";
        document.getElementById("one_star_progress").style.width = "' . (($one_star_review / $total_review) * 100) . '%";
    </script>';
} else {
    $output .= '<h4 class="text-danger">No Reviews Found</h4>';
}

echo $output;
$connect->close();
?>
