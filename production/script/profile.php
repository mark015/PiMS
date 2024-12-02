<script>
    $(document).ready(function () {
        $('#saveProfileButton').click(function () {
            const id = $('#userId').val().trim();
            const name = $('#updateName').val().trim();
            const username = $('#updateUsername').val().trim();
            const oldPassword = $('#oldPassword').val().trim();
            const newPassword = $('#newPassword').val().trim();

            if (name && username && oldPassword && newPassword) {
                $.ajax({
                    url: 'data/updateProfile.php',
                    type: 'POST',
                    data: {
                        id:id,
                        oldPassword: oldPassword,
                        newPassword: newPassword,
                        name: name,
                        username: username
                    },
                    success: function (response) {
                        console.log(response)
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Profile Updated',
                                text: 'Your profile has been successfully updated.',
                            }).then(() => {
                                location.reload(); // Reload the page to reflect changes
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Incorrect old password.',
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred.',
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Fields',
                    text: 'Please fill in all fields before saving.',
                });
            }
        });
    });
</script>