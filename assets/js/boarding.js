function selectPackage(packageName, button) {
    // Remove active class from all buttons
    document.querySelectorAll('.package-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Add active class to selected button
    button.classList.add('active');
    
    // Update hidden input
    document.getElementById('selected_package').value = packageName;
}

function toggleDeliveryOptions() {
    const addressSection = document.getElementById('addressSection');
    const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked').value;
    
    addressSection.style.display = deliveryMethod === 'antar_jemput' ? 'block' : 'none';
}

// Validate dates
document.addEventListener('DOMContentLoaded', function() {
    const checkInDate = document.getElementById('check_in_date');
    const checkOutDate = document.getElementById('check_out_date');

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    checkInDate.min = today;

    checkInDate.addEventListener('change', function() {
        checkOutDate.min = checkInDate.value;
        if (checkOutDate.value && checkOutDate.value < checkInDate.value) {
            checkOutDate.value = checkInDate.value;
        }
    });
});