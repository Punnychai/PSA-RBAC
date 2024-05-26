function passwordAnalyser(password) {
    let score = 0;
    score += Math.min(password.length, 20);   // max score for length = 20

    const categories = {
        uppercase: { regex: /[A-Z]/, message: 'Uppercase' },
        lowercase: { regex: /[a-z]/, message: 'Lowercase' },
        digit: { regex: /[0-9]/, message: 'Digit' },
        special: { regex: /[^A-Za-z0-9]/, message: 'Special Character' }
    };

    const missingCategories = [];
    for (const category in categories) {
        if (categories[category].regex.test(password)) {
            score += 5; // Each category adds 5 to the score
        } else {
            missingCategories.push(categories[category].message);
        }
    }

    // Repeated Chars or Consecutive Seq.
    const repeatedCharRegex = /(.)\1{2,}/;
    const consecutiveSeqRegex = /(?:123|234|345|456|567|678|789|890|987|876|765|654|543|432|321|210)/;

    if (repeatedCharRegex.test(password) || consecutiveSeqRegex.test(password)) {
        score -= 10;
    }

    let feedback = 'Password Strength : ';
    if (score >= 40) feedback += 'Very Strong';
    else if (score >= 30) feedback += 'Strong';
    else if (score >= 20) feedback += 'Medium';
    else if (score < 20) feedback += 'Weak';

    let missList = '';
    if (missingCategories.length > 0) {
        missList = 'Missing ' + missingCategories.join(', ');
    }

    return [feedback, missList];
}
