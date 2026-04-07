document.addEventListener("DOMContentLoaded", function () {

    const toggle = document.getElementById("statusToggle");
    const statusText = document.getElementById("statusText");
    const onlineContent = document.getElementById("onlineContent");
    const offlineContent = document.getElementById("offlineContent");

    function updateUI(data) {
        if (data === "ONLINE") {
            statusText.innerText = "Online";
            toggle.checked = true;
            onlineContent.style.display = "block";
            offlineContent.style.display = "none";
        } else {
            statusText.innerText = "Offline";
            toggle.checked = false;
            onlineContent.style.display = "none";
            offlineContent.style.display = "block";
        }
    }

    // Toggle click
    toggle.addEventListener("change", function() {
        fetch("togglestatus.php", { method: "POST" })
        .then(res => res.text())
        .then(data => {
            updateUI(data);
        });
    });

    // Load on refresh
    fetch("getstatus.php")
    .then(res => res.text())
    .then(data => {
        updateUI(data);
    });

});