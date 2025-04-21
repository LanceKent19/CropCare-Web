<section class="sidebar-container">
    <div class="logo-container">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00c507"><path d="M342-80q-28 0-49-17t-28-44l-45-179h520l-45 179q-7 27-28 44t-49 17H342Zm138-560q0-90 61-156t152-80q5-1 9 1t8 5q4 3 5.5 7.5t.5 9.5q-11 79-64.5 137.5T520-644v84h280q17 0 28.5 11.5T840-520v80q0 33-23.5 56.5T760-360H200q-33 0-56.5-23.5T120-440v-80q0-17 11.5-28.5T160-560h280v-84q-78-13-131.5-71.5T244-853q-1-5 .5-9.5t5.5-7.5q4-3 8-5t9-1q91 14 152 80t61 156Z"/></svg>
        CropCare
    </div>
    <ul>
        <li><a href="home.php"><span class="material-symbols-outlined">home</span>Home</a></li>
        <li><a href="history.php"><span class="material-symbols-outlined">history</span>History</a></li>
        <li><a href="profile.php"><span class="material-symbols-outlined">settings</span>Settings</a></li>
    </ul>

</section>
<style>
/* Replace your existing notification dot styles with these */
.icon-container.notification {
    position: relative;
    display: inline-block; /* Makes it a positioning context */
    width: 25px; /* Match your icon size */
    height: 25px;
}

#notificationDot {
    position: absolute;
    top: 17px;    /* Adjust these pixel values */
    right: 30px;  /* until properly positioned */
    width: 10px;
    height: 10px;
    border-radius: 50%; /* This makes it circular */
    /* rest of the styles same as above */

}

/* Keep your existing color classes */
.status-green { background-color: #33b5e5; }
.status-yellow { background-color: #FFD63A; }
.status-red { background-color: #8E1616; }
.status-grey { background-color: #706D54; }

.status-dot.show {
    display: block;
}

</style>


<!-- ===================header=================== -->
<section class="header">
    <div class="logo poppins-regular">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00c507"><path d="M342-80q-28 0-49-17t-28-44l-45-179h520l-45 179q-7 27-28 44t-49 17H342Zm138-560q0-90 61-156t152-80q5-1 9 1t8 5q4 3 5.5 7.5t.5 9.5q-11 79-64.5 137.5T520-644v84h280q17 0 28.5 11.5T840-520v80q0 33-23.5 56.5T760-360H200q-33 0-56.5-23.5T120-440v-80q0-17 11.5-28.5T160-560h280v-84q-78-13-131.5-71.5T244-853q-1-5 .5-9.5t5.5-7.5q4-3 8-5t9-1q91 14 152 80t61 156Z"/></svg>
        CropCare
    </div>
    <div class="icon-container notification">
        <svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 -960 960 960" width="25px" fill="#666666"><path d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160ZM480-80q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80Z"/></svg>
    </div>
    <div id="notificationDot" class="status-dot"></div>
    <div class="notification-content"id="notificationContent">
    Soil Moisture: <span id="moistureStatus">Loading...</span>
    <br>
    Humidity: <span id="humidityStatus">Loading...</span>
    <br>
    Temperature: <span id="temperatureStatus">Loading...</span>
    <br>
    Ph Level: <span id="phStatus">Loading...</span>
    </div>
</section>

<script>    
    document.addEventListener("DOMContentLoaded", function() {
        const notificationIcon = document.querySelector(".notification");
        const notificationContent = document.querySelector(".notification-content");

        notificationIcon.addEventListener("click", function() {
            notificationContent.classList.toggle("show");
        });
    });
</script>
