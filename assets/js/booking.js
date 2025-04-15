function changeMonth() {
    const month = document.getElementById('monthSelector').value;
    const year = new Date().getFullYear();
    const firstDay = new Date(year, month - 1, 1);
    const lastDay = new Date(year, month, 0);
    const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
    
    const dateButtons = document.getElementById('dateButtons');
    dateButtons.innerHTML = '';
    
    for (let i = 1; i <= lastDay.getDate(); i++) {
        const date = new Date(year, month - 1, i);
        if (date >= new Date()) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-outline-primary date-btn';
            
            const dateNumber = document.createElement('span');
            dateNumber.className = 'date-number';
            dateNumber.textContent = i;
            
            const dateDay = document.createElement('span');
            dateDay.className = 'date-day';
            dateDay.textContent = days[date.getDay()];
            
            button.appendChild(dateNumber);
            button.appendChild(dateDay);
            
            button.onclick = function() {
                selectDate(year, month, i);
                document.querySelectorAll('.date-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
            };
            dateButtons.appendChild(button);
        }
    }
}

function selectDate(year, month, day) {
    const selectedDate = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
    document.getElementById('booking_date').value = selectedDate;
    
    // Show selected date to user
    const formattedDate = `${day} ${getMonthName(month)} ${year}`;
    const dateDisplay = document.createElement('div');
    dateDisplay.className = 'selected-date-display mt-3';
    dateDisplay.innerHTML = `<strong>Tanggal yang dipilih:</strong> ${formattedDate}`;
    
    // Update or create date display
    const existingDisplay = document.querySelector('.selected-date-display');
    if (existingDisplay) {
        existingDisplay.replaceWith(dateDisplay);
    } else {
        document.getElementById('dateButtons').after(dateDisplay);
    }
}

function getMonthName(month) {
    const months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    return months[month - 1];
}

// Initialize calendar with current month
document.addEventListener('DOMContentLoaded', function() {
    const currentMonth = new Date().getMonth() + 1;
    document.getElementById('monthSelector').value = currentMonth;
    changeMonth();
});


// Add this function for package selection
function selectPackage(packageName, button) {
    // Remove active class from all package buttons
    document.querySelectorAll('.package-btn').forEach(btn => {
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline-primary');
    });
    
    // Add active class to selected button
    button.classList.remove('btn-outline-primary');
    button.classList.add('btn-primary');
    
    // Set the selected package value
    document.getElementById('selected_package').value = packageName;
}


const CENTER_LOCATION = {
    kecamatan: 'Telukjambe Timur',
    desa: 'Sukaharja'
};

const DISTANCES = {
    'Telukjambe Timur': {
        'Sukaharja': 0,
        'Pinayungan': 1.5,
        'Puseurjaya': 1.8,
        'Sukamakmur': 2.5,
        'Telukjambe': 3,
        'Sirnabaya': 3.5
    }
};

const AVAILABLE_AREAS = {
    'Telukjambe Timur': ['Sukaharja', 'Pinayungan', 'Puseurjaya']
};

function updateDesa() {
    const kecamatan = document.getElementById('kecamatan').value;
    const desaSelect = document.getElementById('desa');
    desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
    
    if (AVAILABLE_AREAS[kecamatan]) {
        AVAILABLE_AREAS[kecamatan].forEach(desa => {
            const option = document.createElement('option');
            option.value = desa;
            option.textContent = desa;
            desaSelect.appendChild(option);
        });
    }
}

function toggleDeliveryOptions() {
    const addressSection = document.getElementById('addressSection');
    const antar_jemput = document.getElementById('antar_jemput');
    
    if (antar_jemput.checked) {
        addressSection.style.display = 'block';
        document.getElementById('kecamatan').value = 'Telukjambe Timur';
        updateDesa();
    } else {
        addressSection.style.display = 'none';
    }
}