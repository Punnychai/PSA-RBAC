<?php
function passwordAnalyser($password) {
    $score = 0;
    $score += min(strlen($password), 20);   // max score for length = 20

    $categories = [
        'uppercase' => ['regex' => '/[A-Z]/', 'message' => 'Uppercase'],
        'lowercase' => ['regex' => '/[a-z]/', 'message' => 'Lowercase'],
        'digit' => ['regex' => '/[0-9]/', 'message' => 'Digit'],
        'special' => ['regex' => '/[^A-Za-z0-9]/', 'message' => 'Special Character'],
    ];

    $missingCategories = [];
    foreach ($categories as $category => $details) {
        if (preg_match($details['regex'], $password)) {
            $score += 5; // Each category adds 5 to the score
        } else {
            $missingCategories[] = $details['message'];
        }
    }

    // Repeated Chars or Consecutive Seq.
    $repeatedCharRegex = '/(.)\1{2,}/';
    $consecutiveSeqRegex = '/(?:123|234|345|456|567|678|789|890|987|876|765|654|543|432|321|210)/';

    if (preg_match($repeatedCharRegex, $password) || preg_match($consecutiveSeqRegex, $password)) {
        $score -= 10;
    }

    $feedback = '';
    if ($score >= 40) $feedback = 'Very Strong';
    else if ($score >= 30) $feedback = 'Strong';
    else if ($score >= 20) $feedback = 'Medium';
    else if ($score < 20) $feedback = 'Weak';

    $missList = '';
    if (count($missingCategories) > 0) {
        $missList = 'missing ' . implode(', ', $missingCategories);
    }

    return [$feedback, $missList];
}
?>
