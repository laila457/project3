<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Hewan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&libraries=places&callback=initMap" async defer></script>
</head>

<body>
    <div class="banner-container">
        <img src="./image/logooo.png" alt="Pet Banner" class="banner-image" />
    </div>
    <nav>
        <a href="index.php">Beranda</a>
        <a href="layanan.php">Layanan</a>
        <a href="booking.php">Booking</a>
        <a href="akun.php">Akun</a>
    </nav>
    <div class="container">
        <h3>Pilih Bulan</h3>
        <select id="monthSelector" class="form-control" onchange="changeMonth()">
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>
            <option value="8">Agustus</option>
            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
        </select>

        <h3 class="mt-3">Pilih Tanggal</h3>
        <div id="dateButtons" class="d-flex flex-wrap gap-2"></div>

        <button class="btn btn-primary mt-3" onclick="nextWeek()">Minggu Selanjutnya</button>

        <form id="bookingForm" action="process_booking.php" method="POST" onsubmit="return validateBooking()">
            <input type="hidden" id="booking_date" name="booking_date">

            <label for="booking_time" class="mt-3">Pilih Jam Booking:</label>
            <input type="time" id="booking_time" name="booking_time" required class="form-control">

            <h5 class="mt-3">Data Pelanggan</h5>
            <input type="text" class="form-control" name="owner_name" placeholder="Nama Pemilik" required>
            <input type="text" class="form-control mt-2" name="phone" placeholder="No. HP" required>

            <div class="mt-2">
                <label for="pet_type">Jenis Hewan:</label>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input me-1" id="dog" name="pet_type" value="Anjing" required style="width: 1.2em; height: 1.2em; border: 2px solid #000;">
                    <label class="form-check-label" for="dog">Anjing</label>
                </div>
                <div class="form-check form-check-inline ms-3">
                    <input type="radio" class="form-check-input me-1" id="cat" name="pet_type" value="Kucing" required style="width: 1.2em; height: 1.2em; border: 2px solid #000;">
                    <label class="form-check-label" for="cat">Kucing</label>
                </div>
            </div>

            <h5 class="mt-3">Pilih Paket</h5>
            <div>
                <button type="button" class="btn btn-outline-primary package-btn" onclick="selectPackage('Basic - 59k', this)">Basic - 59k</button>
                <button type="button" class="btn btn-outline-primary package-btn" onclick="selectPackage('Kutu - Jamur - 70k', this)">Kutu - Jamur - 70k</button>
                <button type="button" class="btn btn-outline-primary package-btn" onclick="selectPackage('Full - 86k', this)">Full - 86k</button>
            </div>
            <input type="hidden" id="selected_package" name="package">

            <h5 class="mt-3">Lokasi dan Pengantaran</h5>
            <div class="mb-3">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input me-1" id="datang_sendiri" name="delivery_method" value="datang_sendiri" checked onchange="toggleDeliveryOptions()" style="width: 1.2em; height: 1.2em; border: 2px solid #000;">
                    <label class="form-check-label" for="datang_sendiri">Datang Sendiri</label>
                </div>
                <div class="form-check form-check-inline ms-3">
                    <input type="radio" class="form-check-input me-1" id="antar_jemput" name="delivery_method" value="antar_jemput" onchange="toggleDeliveryOptions()" style="width: 1.2em; height: 1.2em; border: 2px solid #000;">
                    <label class="form-check-label" for="antar_jemput">Antar Jemput (+20k)</label>
                </div>
            </div>

            <!-- Replace the map section with this -->
                <div id="addressSection">
                    <div class="mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <select class="form-control" id="kecamatan" name="kecamatan" onchange="updateDesa()" required>
                            <option value="">Pilih Kecamatan</option>
                            <option value="Karawang Barat">Karawang Barat</option>
                            <option value="Karawang Timur">Karawang Timur</option>
                            <option value="Telukjambe Timur">Telukjambe Timur</option>
                            <option value="Telukjambe Barat">Telukjambe Barat</option>
                            <option value="Klari">Klari</option>
                            <option value="Ciampel">Ciampel</option>
                            <option value="Majalaya">Majalaya</option>
                            <option value="Rawamerta">Rawamerta</option>
                            <option value="Tirtamulya">Tirtamulya</option>
                            <option value="Jatisari">Jatisari</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="desa" class="form-label">Desa/Kelurahan</label>
                        <select class="form-control" id="desa" name="desa" required>
                            <option value="">Pilih Desa/Kelurahan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="detail_alamat" class="form-label">Detail Alamat</label>
                        <textarea class="form-control" id="detail_alamat" name="detail_alamat" rows="3" placeholder="Masukkan detail alamat (nama jalan, nomor rumah, RT/RW)" required></textarea>
                    </div>
                </div>

                <!-- Remove the old Google Maps script and replace with this -->
                <script>
                    const desaList = {
                        'Karawang Barat': ['Adiarsa Barat', 'Tanjungpura', 'Nagasari', 'Karawang Wetan', 'Karangpawitan'],
                        'Karawang Timur': ['Adiarsa Timur', 'Palumbonsari', 'Plawad', 'Warungbambu', 'Tegalsawah'],
                        'Telukjambe Timur': ['Sukaluyu', 'Sirnabaya', 'Puseurjaya', 'Pinayungan', 'Parungmulya'],
                        'Telukjambe Barat': ['Wanakerta', 'Wanasari', 'Telukjambe', 'Sukamakmur', 'Margamulya'],
                        'Klari': ['Anggadita', 'Cibalongsari', 'Curug', 'Gintungkerta', 'Klari'],
                        'Ciampel': ['Ciampel', 'Mulyasari', 'Parungmulya', 'Tegalsari', 'Tegalwaru'],
                        'Majalaya': ['Majalaya', 'Pasirjaya', 'Pasirtanjung', 'Tajurhalang', 'Talagasari'],
                        'Rawamerta': ['Rawamerta', 'Sukajaya', 'Sukaluyu', 'Tempuran', 'Tirtasari'],
                        'Tirtamulya': ['Tirtamulya', 'Tirtasari', 'Waluya', 'Wanasari', 'Sukamerta'],
                        'Jatisari': ['Jatisari', 'Mekarmulya', 'Pacing', 'Sukamerta', 'Sukasari']
                    };

                    function updateDesa() {
                        const kecamatan = document.getElementById('kecamatan').value;
                        const desaSelect = document.getElementById('desa');
                        desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                        
                        if (kecamatan && desaList[kecamatan]) {
                            desaList[kecamatan].forEach(desa => {
                                const option = document.createElement('option');
                                option.value = desa;
                                option.textContent = desa;
                                desaSelect.appendChild(option);
                            });
                        }
                    }

                    function toggleDeliveryOptions() {
                        const addressSection = document.getElementById('addressSection');
                        addressSection.style.display = document.getElementById('antar_jemput').checked ? 'block' : 'none';
                    }
                </script>

            <button type="submit" class="btn btn-success mt-3">Selesaikan Pemesanan</button>
            <input type="hidden" name="redirect_to" value="payment">
        </form>

    <script>
        let selectedMonth = new Date().getMonth() + 1;
        let startDate = new Date();

        function changeMonth() {
            selectedMonth = parseInt(document.getElementById("monthSelector").value);
            startDate = new Date(new Date().getFullYear(), selectedMonth - 1, 1);
            generateDates();
        }

        function generateDates() {
            let dateButtons = document.getElementById("dateButtons");
            dateButtons.innerHTML = "";

            let weekDates = getWeekDates(startDate);
            for (let date of weekDates) {
                let btn = document.createElement("button");
                btn.innerText = date;
                btn.classList.add("btn", "btn-outline-secondary", "m-1");
                btn.onclick = function() {
                    selectDate(date, btn);
                };
                dateButtons.appendChild(btn);
            }
        }

        function nextWeek() {
            startDate.setDate(startDate.getDate() + 7);
            generateDates();
        }

        function selectDate(date, btn) {
            const [day, monthName] = date.split(" ");
            const month = getMonthNumber(monthName);
            const year = new Date().getFullYear(); // Atau sesuaikan dengan tahun yang diinginkan
            const formattedDate = `${year}-${month < 10 ? '0' + month : month}-${day < 10 ? '0' + day : day}`;

            document.getElementById("booking_date").value = formattedDate;
            console.log("Tanggal yang dipilih:", formattedDate); // Debugging
            document.querySelectorAll("#dateButtons button").forEach(b => b.classList.remove("btn-primary"));
            btn.classList.add("btn-primary");
        }

        function getMonthNumber(monthName) {
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            return monthNames.indexOf(monthName) + 1;
        }

        function selectPackage(packageName, btn) {
            document.getElementById("selected_package").value = packageName;
            document.querySelectorAll(".package-btn").forEach(b => b.classList.remove("btn-primary"));
            btn.classList.add("btn-primary");
        }

        function getWeekDates(startDate) {
            let dates = [];
            for (let i = 0; i < 7; i++) {
                let date = new Date(startDate);
                date.setDate(startDate.getDate() + i);
                dates.push(date.getDate() + " " + getMonthName(selectedMonth));
            }
            return dates;
        }

        function getMonthName(month) {
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            return monthNames[month - 1];
        }

        function validateBooking() {
            const bookingDate = document.getElementById("booking_date").value;
            if (!bookingDate) {
                alert("Silakan pilih tanggal booking.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        window.onload = generateDates;
    </script>

    <!-- Replace the existing map script with this -->
        <script>
            let map, marker;
            
            function toggleDeliveryOptions() {
                const addressSection = document.getElementById('addressSection');
                addressSection.style.display = document.getElementById('antar_jemput').checked ? 'block' : 'none';
                if (document.getElementById('antar_jemput').checked && !map) {
                    initMap();
                }
            }
    
            function initMap() {
                if (!document.getElementById('map')) return;
                
                const defaultLocation = { lat: 3.5952, lng: 98.6722 };
                
                map = new google.maps.Map(document.getElementById('map'), {
                    center: defaultLocation,
                    zoom: 13,
                    mapTypeControl: true,
                    streetViewControl: true
                });
    
                marker = new google.maps.Marker({
                    position: defaultLocation,
                    map: map,
                    draggable: true
                });
    
                const searchInput = document.getElementById('searchAddress');
                const autocomplete = new google.maps.places.Autocomplete(searchInput);
    
                autocomplete.bindTo('bounds', map);
    
                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();
                    if (!place.geometry) return;
    
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
    
                    marker.setPosition(place.geometry.location);
                    updateAddressFields(place);
                });
    
                marker.addListener('dragend', function() {
                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        location: marker.getPosition()
                    }, function(results, status) {
                        if (status === 'OK' && results[0]) {
                            updateAddressFields(results[0]);
                        }
                    });
                });
            }
    
            function updateAddressFields(place) {
                document.getElementById('fullAddress').value = place.formatted_address;
                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
            }
    
            // Update the existing window.onload
            window.onload = function() {
                generateDates();
                toggleDeliveryOptions();
            };
        </script>
</body>

</html>