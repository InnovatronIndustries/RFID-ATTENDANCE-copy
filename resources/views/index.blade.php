<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Academe Access</title>
  <link rel="icon" href="ap.png">
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col imageColumn d-flex flex-column justify-content-center align-items-center">
      <div class="row">
        <img
          class="image"
          src="{{ $school->logo }}"
          alt=""
          onerror="this.src='{{ $school->logo }}'"
        />
      </div>
      <div class="row">
        <form>
          <input type="text" name="text" class="inputUID" placeholder="UID" style = "opacity: 0;" id="uidInput">
        </form>
      </div>
    </div>
    <div class="col detailsColumn d-flex justify-content-center align-items-center">
      <div class="detailsContainer">
        <h1 class="schoolName" style="font-weight: 700; margin-top: 100px;">{{ $school->name }}</h1>
        <h1 id="current-time" style="font-weight: 700;"></h1>
        <h1 id="student-name" style="font-weight: 700;"></h1>
        <h3 id="current-date" style="font-weight: 500;"></h3>
        <h3 id="status" style="font-weight: 500;"></h3>
        <h4 class="schoolAddress" style="font-weight: 300; margin-top: 65px">{{ $school->address }}</h4>
        <div id="additionalInfo" style="display: none;"></div>
        <img id="apLogo" src="ap.png" alt="logo" style="margin-top: 150px" />
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

  let refreshTimeoutId;

  $(document).ready(function () {
    $('#uidInput').focus();
  });

  function getCurrentTimeInTimeZone(timezone) {
    const options = {
      timeZone: 'Asia/Manila',
      hour12: true,
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    };
    return new Date().toLocaleTimeString('en-US', options);
  }

  function displayCurrentTime() {
    const currentTime = getCurrentTimeInTimeZone();
    $('#current-time').text(currentTime);
  }

  setInterval(displayCurrentTime, 1000);

  function getCurrentDate() {
    const today = new Date();
    const day = today.getDay();
    const month = today.getMonth();
    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
    return days[day] + ', ' + months[month] + ' ' + today.getDate();
  }

  function displayTimeZone(loginTime) {
    const currentTime = getCurrentTimeInTimeZone();
    const currentDate = getCurrentDate();
    const timeZoneInfo = "Current Time & Date: " + currentTime + ', ' + currentDate;
    $('#additionalInfo').text(timeZoneInfo);
  }

  function isWithinLastHour(time) {
    const currentTime = new Date();
    const timeDiff = currentTime - time;
    const oneHour = 60 * 60 * 1000;
    return timeDiff < oneHour;
  }

  $('form').submit(function (e) {
    e.preventDefault();
    var uidToCheck = $('#uidInput').val();
    handleUIDCheck(uidToCheck);

    $('#uidInput').val('');
    $('#uidInput').focus();

    refreshPageAfterTap();
  });

  function refreshPageAfterTap() {
    // check if a refresh is already scheduled within the next 5 seconds
    if (refreshTimeoutId) {
      // cancel the previous refresh
      console.log('cancelled previous refresh..');
      clearTimeout(refreshTimeoutId);
    }

    // schedule a new refresh after 10 seconds
    refreshTimeoutId = setTimeout(function () {
      console.log('no activity detected.. reloading page.');
      location.reload();
    }, 10000);
  }

  
  function handleUIDCheck(uidToCheck) {
    $.ajax({
        type: 'POST',
        url: '/check-uid',
        data: {
            uid: uidToCheck,
        },
        success: function (response) {
            if (response.success) {
              shouldLogOut(uidToCheck);
            } else {
              Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'RFID Not Registered',
                showConfirmButton: false,
                timer: 1500
              });
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
  }
  function shouldLogOut(uidToCheck) {
    $.ajax({
        type: 'GET',
        url: '/should-log-out',
        data: { uid: uidToCheck },
        success: function (response) {
            if (response.success) {
              getLogoutTime(uidToCheck);
            } else {
              getLoginTime(uidToCheck);
            }
        },
        error: function (xhr) {
            console.error("Check last login request error: " + xhr.responseText);
        }
    });
  }
  function getLoginTime(uidToCheck) {
    $.ajax({
      type: 'GET',
      url: '/get-login-time/' + uidToCheck,
      data: { uid: uidToCheck },
      success: function (data) {

        login(uidToCheck, function (result) {

          if (result) {
            var logDate = new Date(data.log_date);
            var options = {
              hour: '2-digit',
              minute: '2-digit',
              second: '2-digit',
              hour12: true,
              weekday: 'long',
              month: 'long',
              day: 'numeric'
            };
            var student = data.user;
            $('.schoolName').text(student.school);
            $('#current-time').css('display', 'none');
            $('#student-name').text(`${student.firstname} ${student.middlename?? ''} ${student.lastname}`);
            $('#current-date').css('display', 'none');
            $('.schoolAddress').text(student.details);
            $('.image').attr('src', student.avatar);
            $('.image').css('border-radius', '50%');
            $('#additionalInfo').css('display', 'block');
            setInterval(function () {
              displayTimeZone();
            }, 1000);
            var formattedDateTime = logDate.toLocaleString('en-US', options);
            $('#status').text("Log In: " + formattedDateTime);
          }
        });

      },
      error: function (xhr) {
        console.error(xhr.responseText);
      }
    });
  }

  function login(uid, callback) {
    $.ajax({
      type: 'POST',
      url: '/rfid-login',
      data: { uid: uid },
      success: function (response) {
        if (response.success) {
          console.log('Login successful');
          callback(true);
        } else {
          console.error('Already Logged In');

          Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Login Failed',
            text: 'User has recently logged out. Please try again after 5 minutes.',
            showConfirmButton: false,
            timer: 1500
          });

          callback(false);
        }
      },
      error: function (xhr) {
        console.error("Login request error: " + xhr.responseText);
        callback(false);
      }
    });
  }

  function getLogoutTime(uidToCheck) {
    $.ajax({
      type: 'GET',
      url: '/get-logout-time/' + uidToCheck,
      data: { uid: uidToCheck },
      success: function (data) {
        var logDate = new Date(data.log_date);
        var options = {
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit',
          hour12: true,
          weekday: 'long',
          month: 'long',
          day: 'numeric'
        };
        var student = data.user;
        $('.schoolName').text(student.school);
        $('#current-time').css('display', 'none');
        $('#student-name').text(`${student.firstname} ${student.middlename?? ''} ${student.lastname}`);
        $('#current-date').css('display', 'none');
        $('.schoolAddress').text(student.details);
        $('.image').attr('src', student.avatar);
        $('.image').css('border-radius', '50%');
        $('#additionalInfo').css('display', 'block');
        setInterval(function () {
          displayTimeZone();
        }, 1000);
        var formattedDateTime = logDate.toLocaleString('en-US', options);
        $('#status').text("Log In: " + formattedDateTime);

        logout(uidToCheck);
      },
      error: function (xhr) {
        console.error(xhr.responseText);
      }
    });
  }

  function logout(uid) {
    $.ajax({
      type: 'POST',
      url: '/rfid-logout',
      data: { uid: uid },
      success: function (response) {
        if (response.success) {
          console.log('Logout successful');
          var logDate = new Date;
          var options = {
              hour: '2-digit',
              minute: '2-digit',
              second: '2-digit',
              hour12: true,
              weekday: 'long',
              month: 'long',
              day: 'numeric'
          };
          var formattedDateTime = logDate.toLocaleString('en-US', options);
          $('#status').text("Log Out: " + formattedDateTime);
        } else {
          console.error('Logout failed');

          Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Logout Failed',
            text: 'User has recently logged in. Please try again after 5 minutes.',
            showConfirmButton: false,
            timer: 1500
          });

        }
      },
      error: function (xhr) {
        console.error("Logout request error: " + xhr.responseText);
      }
    });
  }

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
