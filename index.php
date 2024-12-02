<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="production/images/favicon.ico" type="image/ico" />
    <title>EIS</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendors/swal/dist/sweetalert2.min.css">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> 

    <style>
  .styled-input {
    padding-right: 40px; /* Space for the toggle button */
    border: 2px solid #ced4da;
    border-radius: 5px;
    padding: 10px;
    font-size: 16px;
    transition: border-color 0.3s ease-in-out;
  }

  .styled-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
  }

  .toggle-password-btn {
    position: absolute;
    right: 10px;
    top: 35%;
    transform: translateY(-50%);
    background-color: transparent;
    border: none;
    cursor: pointer;
  }

  .toggle-password-btn:focus {
    outline: none;
  }

  .toggle-password-btn i {
    color: #007bff;
    font-size: 18px;
  }

  .toggle-password-btn i.fa-eye-slash {
    color: #dc3545; /* Change color when the password is visible */
  }

  /* Optional: Add some hover effect */
  .toggle-password-btn:hover i {
    color: #0056b3;
  }
</style>

  </head>

  <body class="login" style="background-color:#ffffff;">
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form id="loginForm">
                <h1>Login</h1>
                <div>
                    <input type="text" id="username" class="form-control" placeholder="Username" required />
                </div>
                <div>
                <div class="form-group" style="position: relative;">
                  <div class="input-group">
                    <input type="password" id="password" class="form-control styled-input" placeholder="Password" required>
                    <button class="btn btn-outline-secondary toggle-password-btn" type="button" id="togglePassword">
                      <i class="fa fa-eye"></i>
                    </button>
                  </div>
                </div>
                </div>
                <div>
                    <button class="btn btn-secondary" type="submit" name="login">Log in</button>
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    <div class="clearfix"></div>
                    <br />
                    <div>
                        <p><i class="fa fa-file-code-o"></i> Developed By <strong>TechzQuad</strong></p>
                        <p>©2016 All Rights Reserved. We Are The Solution</p>
                    </div>
                </div>
            </form>
          </section>

        </div>
      </div>
    </div>
    <script src="vendors/swal/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function (e) {
    // Toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    // Toggle the eye icon
    this.querySelector('i').classList.toggle('fa-eye');
    this.querySelector('i').classList.toggle('fa-eye-slash');
  });


      $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();  // Prevent default form submission

            var email = $('#username').val();
            var password = $('#password').val();
            // Perform AJAX request
            $.ajax({
                url: 'process.php',  // Change this URL to your server-side script
                type: 'POST',
                dataType: 'json',
                data: {
                    email: email,
                    password: password
                },
                success: function(response) {
                    if (response.success) {
                        // If login is successful, redirect to dashboard or another page
                       // Show SweetAlert notification on successful login
                        var href = "production/index?link=dashboard";
                          Swal.fire({
                              icon: "success",
                              title: "Successfully Logged In!",
                              showConfirmButton: false,
                              timer: 1500  // Show for 1.5 seconds
                          }).then(() => {
                              // Redirect to the dashboard after the notification
                              window.location.href = href;  // Change this URL to your desired destination
                          });
                    } else {
                        // If login failed, show an error message
                        toastr.error('Incorrect username or password!', 'Error');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors (e.g., server not responding, etc.)
                    console.error('AJAX Error:', error);
                    alert('An error occurred while logging in.');
                }
            });
        });
      });

    </script>
  </body>
</html>
