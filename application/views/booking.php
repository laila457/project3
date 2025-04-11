<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Hewan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
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
                <div>
                    <input type="radio" id="dog" name="pet_type" value="Anjing" required>
                    <label for="dog">Anjing</label>
                </div>
                <div>
                    <input type="radio" id="cat" name="pet_type" value="Kucing" required>
                    <label for="cat">Kucing</label>
                </div>
            </div>

            <label class="mt-3">Total Hewan</label>
            <select name="total_pets" class="form-control">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>

            <h5 class="mt-3">Pilih Paket</h5>
            <div>
                <button type="button" class="btn btn-outline-primary package-btn" onclick="selectPackage('Basic - 59k', this)">Basic - 59k</button>
                <button type="button" class="btn btn-outline-primary package-btn" onclick="selectPackage('Kutu - Jamur - 70k', this)">Kutu - Jamur - 70k</button>
                <button type="button" class="btn btn-outline-primary package-btn" onclick="selectPackage('Full - 86k', this)">Full - 86k</button>
            </div>
            <input type="hidden" id="selected_package" name="package">

            <label class="mt-3">Alamat</label>
            <input type="text" name="address" required class="form-control">

            <button type="submit" class="btn btn-success mt-3">Selesaikan Pemesanan</button>
        </form>
    </div>

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
</body>

</html>