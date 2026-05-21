/**
 * National ID Extractor
 * 
 * Extracts birth date, governorate, and gender from Egyptian National ID
 */

// Egyptian Governorate codes mapping
const GOVERNORATE_CODES = {
    '01': 'Cairo',
    '02': 'Alexandria',
    '03': 'Port Said',
    '04': 'Suez',
    '11': 'Damietta',
    '12': 'Dakahlia',
    '13': 'Ash Sharqia',
    '14': 'Kaliobeya',
    '15': 'Kafr El Sheikh',
    '16': 'Gharbia',
    '17': 'Monufia',
    '18': 'El Beheira',
    '19': 'Ismailia',
    '21': 'Giza',
    '22': 'Beni Suef',
    '23': 'Fayoum',
    '24': 'El Menia',
    '25': 'Assiut',
    '26': 'Sohag',
    '27': 'Qena',
    '28': 'Aswan',
    '29': 'Luxor',
    '31': 'Red Sea',
    '32': 'New Valley',
    '33': 'Matrouh',
    '34': 'North Sinai',
    '35': 'South Sinai',
    '88': 'Foreign'
};

/**
 * Validate National ID format
 */
function validateNationalId(nationalId) {
    // Must be exactly 14 digits
    if (!/^\d{14}$/.test(nationalId)) {
        return false;
    }

    // First digit must be 2 or 3
    const century = nationalId.charAt(0);
    if (century !== '2' && century !== '3') {
        return false;
    }

    // Validate governorate code
    const governorateCode = nationalId.substring(7, 9);
    if (!GOVERNORATE_CODES[governorateCode]) {
        return false;
    }

    return true;
}

/**
 * Extract birth date from National ID
 */
function extractBirthDate(nationalId) {
    if (nationalId.length !== 14) return null;

    const century = nationalId.charAt(0);
    const year = nationalId.substring(1, 3);
    const month = nationalId.substring(3, 5);
    const day = nationalId.substring(5, 7);

    const fullYear = (century === '2' ? '19' : '20') + year;
    
    // Format as YYYY-MM-DD for date input
    return `${fullYear}-${month}-${day}`;
}

/**
 * Extract governorate from National ID
 */
function extractGovernorate(nationalId) {
    if (nationalId.length !== 14) return null;

    const governorateCode = nationalId.substring(7, 9);
    return GOVERNORATE_CODES[governorateCode] || null;
}

/**
 * Extract gender from National ID
 */
function extractGender(nationalId) {
    if (nationalId.length !== 14) return null;

    // Digit 10 (index 9) determines gender
    const genderDigit = parseInt(nationalId.charAt(9));
    
    // Odd = Male, Even = Female
    return (genderDigit % 2 === 1) ? 'male' : 'female';
}

/**
 * Show validation feedback
 */
function showValidationFeedback(inputElement, isValid, message = '') {
    const feedbackElement = inputElement.parentElement.querySelector('.validation-feedback');
    
    if (feedbackElement) {
        if (isValid) {
            feedbackElement.innerHTML = '<i class="fas fa-check-circle text-green-500"></i> <span class="text-green-600 text-sm">Valid National ID</span>';
            feedbackElement.classList.remove('hidden');
            inputElement.classList.remove('border-red-500');
            inputElement.classList.add('border-green-500');
        } else if (message) {
            feedbackElement.innerHTML = `<i class="fas fa-times-circle text-red-500"></i> <span class="text-red-600 text-sm">${message}</span>`;
            feedbackElement.classList.remove('hidden');
            inputElement.classList.remove('border-green-500');
            inputElement.classList.add('border-red-500');
        } else {
            feedbackElement.classList.add('hidden');
            inputElement.classList.remove('border-green-500', 'border-red-500');
        }
    }
}

/**
 * Initialize National ID extraction
 */
document.addEventListener('DOMContentLoaded', function() {
    const nationalIdInput = document.getElementById('national_id');
    
    if (!nationalIdInput) return;

    const birthDateInput = document.getElementById('birth_date');
    const birthGovernorateInput = document.getElementById('birth_governorate');
    const genderMaleRadio = document.getElementById('gender_male');
    const genderFemaleRadio = document.getElementById('gender_female');

    nationalIdInput.addEventListener('input', function(e) {
        const nationalId = e.target.value.trim();

        // Clear feedback if input is empty
        if (nationalId.length === 0) {
            showValidationFeedback(nationalIdInput, false, '');
            return;
        }

        // Show feedback for incomplete input
        if (nationalId.length < 14) {
            showValidationFeedback(nationalIdInput, false, 'National ID must be 14 digits');
            return;
        }

        // Validate and extract
        if (validateNationalId(nationalId)) {
            showValidationFeedback(nationalIdInput, true);

            // Extract and fill fields
            const birthDate = extractBirthDate(nationalId);
            const birthGovernorate = extractGovernorate(nationalId);
            const gender = extractGender(nationalId);

            if (birthDateInput && birthDate) {
                birthDateInput.value = birthDate;
                birthDateInput.classList.add('bg-green-50');
            }

            if (birthGovernorateInput && birthGovernorate) {
                birthGovernorateInput.value = birthGovernorate;
                birthGovernorateInput.classList.add('bg-green-50');
            }

            if (gender) {
                if (gender === 'male' && genderMaleRadio) {
                    genderMaleRadio.checked = true;
                } else if (gender === 'female' && genderFemaleRadio) {
                    genderFemaleRadio.checked = true;
                }
            }
        } else {
            showValidationFeedback(nationalIdInput, false, 'Invalid National ID format');
        }
    });

    // Allow manual editing of auto-filled fields
    [birthDateInput, birthGovernorateInput].forEach(input => {
        if (input) {
            input.addEventListener('focus', function() {
                this.classList.remove('bg-green-50');
            });
        }
    });
});

/**
 * Phone number validation
 */
document.addEventListener('DOMContentLoaded', function() {
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            
            // Limit to 11 digits
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            
            e.target.value = value;

            // Validate phone number
            if (value.length === 11) {
                const validPrefixes = ['010', '011', '012', '015'];
                const prefix = value.substring(0, 3);
                
                const feedbackElement = input.parentElement.querySelector('.phone-feedback');
                if (feedbackElement) {
                    if (validPrefixes.includes(prefix)) {
                        feedbackElement.innerHTML = '<i class="fas fa-check-circle text-green-500"></i> <span class="text-green-600 text-sm">Valid phone number</span>';
                        feedbackElement.classList.remove('hidden');
                        input.classList.remove('border-red-500');
                        input.classList.add('border-green-500');
                    } else {
                        feedbackElement.innerHTML = '<i class="fas fa-times-circle text-red-500"></i> <span class="text-red-600 text-sm">Must start with 010, 011, 012, or 015</span>';
                        feedbackElement.classList.remove('hidden');
                        input.classList.remove('border-green-500');
                        input.classList.add('border-red-500');
                    }
                }
            } else if (value.length > 0) {
                const feedbackElement = input.parentElement.querySelector('.phone-feedback');
                if (feedbackElement) {
                    feedbackElement.innerHTML = '<i class="fas fa-info-circle text-blue-500"></i> <span class="text-blue-600 text-sm">Enter 11 digits</span>';
                    feedbackElement.classList.remove('hidden');
                    input.classList.remove('border-green-500', 'border-red-500');
                }
            }
        });
    });

    // Check if student phone and parent phone are different
    const studentPhone = document.getElementById('phone');
    const parentPhone = document.getElementById('parent_phone');

    if (studentPhone && parentPhone) {
        function checkPhonesDifferent() {
            if (studentPhone.value && parentPhone.value && studentPhone.value === parentPhone.value) {
                const warningDiv = document.getElementById('phone-warning');
                if (warningDiv) {
                    warningDiv.classList.remove('hidden');
                }
            } else {
                const warningDiv = document.getElementById('phone-warning');
                if (warningDiv) {
                    warningDiv.classList.add('hidden');
                }
            }
        }

        studentPhone.addEventListener('input', checkPhonesDifferent);
        parentPhone.addEventListener('input', checkPhonesDifferent);
    }
});
