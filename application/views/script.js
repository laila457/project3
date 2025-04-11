function toggleForm() {
	let loginForm = document.getElementById("loginForm");
	let registerForm = document.getElementById("registerForm");

	loginForm.style.display =
		loginForm.style.display === "none" ? "block" : "none";
	registerForm.style.display =
		registerForm.style.display === "none" ? "block" : "none";
}

function handleLogin(event) {
	event.preventDefault();

	let username = document.getElementById("loginUsername").value;
	let password = document.getElementById("loginPassword").value;

	console.log("Username:", username); // Debugging
	console.log("Password:", password); // Debugging

	if (username === "" || password === "") {
		alert("Username dan password harus diisi!");
		return;
	}

	fetch("login.php", {
		method: "POST",
		headers: { "Content-Type": "application/x-www-form-urlencoded" },
		body: `username=${username}&password=${password}`,
	})
		.then((response) => response.json())
		.then((data) => {
			alert(data.message);
			if (data.status === "success") {
				window.location.href = "index.php";
			}
		})
		.catch((error) => console.error("Error:", error));
}

function handleRegister(event) {
	event.preventDefault();

	let username = document.getElementById("registerUsername").value;
	let email = document.getElementById("registerEmail").value;
	let password = document.getElementById("registerPassword").value;

	if (username === "" || email === "" || password === "") {
		alert("Semua field harus diisi!");
		return;
	}

	fetch("register.php", {
		method: "POST",
		headers: { "Content-Type": "application/x-www-form-urlencoded" },
		body: `username=${username}&email=${email}&password=${password}`,
	})
		.then((response) => response.json())
		.then((data) => {
			alert(data.message);
			if (data.status === "success") {
				toggleForm();
			}
		})
		.catch((error) => console.error("Error:", error));
}
