<?php
header("Content-Type: application/json");

// Log incoming data for debugging
$input_data = file_get_contents("php://input");
error_log("Received data: " . $input_data);

// Decode received JSON data
$data = json_decode($input_data, true);
$user_message = strtolower(trim($data['message'])); // Normalize input

// Define FAQs (static responses for common questions)
$faqs = [
    "what are your opening hours" => "Our clinic is open from Tuesday to Saturday, 11 AM to 4.30 PM with Saturday opening half an hour earlier.",
    "how do i book an appointment" => "You can book an appointment by visiting our 'Book Appointment' page on the top right then choose a date and time to have the appointment on.",
    "can i book an appointment online" => "Yes, you can book online via our website.",
    "how do i cancel an appointment" => "To cancel or reschedule, please call our clinic.",
    "where is the clinic located" => "Our clinic is located at: Block 729, #01-101 Yishun Street 71, Singapore 760729."
];

// Improved fuzzy matching
$best_match = null;
$best_distance = PHP_INT_MAX;
$best_similarity = 0;

// Dynamic threshold based on question length
$lev_threshold = 3; // Default tolerance
$similarity_threshold = 70; // Percentage match (0-100)

// Iterate through FAQs to find the best match
foreach ($faqs as $question => $answer) {
    // Levenshtein distance
    $lev_distance = levenshtein($user_message, $question);

    // Similarity percentage (more accurate for fuzzy matching)
    similar_text($user_message, $question, $similarity_score);

    // Adjust Levenshtein threshold based on question length
    $lev_tolerance = max(3, floor(strlen($question) * 0.2));

    // Choose the best match based on similarity and Levenshtein
    if ($lev_distance <= $lev_tolerance || $similarity_score >= $similarity_threshold) {
        if ($similarity_score > $best_similarity) {
            $best_similarity = $similarity_score;
            $best_match = $question;
            $best_distance = $lev_distance;
        }
    }
}

// Respond with the best match
if ($best_match) {
    echo json_encode(["response" => $faqs[$best_match]]);
} else {
    echo json_encode(["response" => "I'm sorry, I didn't understand that. Can you please rephrase?"]);
}
?>


