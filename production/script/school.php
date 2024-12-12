<script>

$(document).ready(function () {
    let currentPage = 1;
    var role = "<?php echo $rowUser['role'];?>";    
    
    // Function to fetch and display data
    function fetchSchool(page = 1, search = "") {
        $.ajax({
            url: "data/fetch_school.php",
            type: "GET",
            data: { page: page, search: search },
            dataType: "json",
            success: function (response) {
                console.log(response)
                let rows = "";
                response.data.forEach(function (item) {
                    if(role === 'Admin'){
                        var deleteBtn =  `<button class="btn btn-danger btn-sm delete-btn" data-id="${item.id}">Delete</button>`
                    }else {
                        var deleteBtn = '';
                    }

                    rows += `
                        <tr>
                            <td>${item.school_id}</td>
                            <td>${item.school_name}</td>
                            <td>
                                ${deleteBtn}
                                <button class="btn btn-success btn-sm" id="update-btn" data-update-id="${item.id}">Update</button>
                            </td>
                        </tr>
                    `;
                });
                $("#schoolTable tbody").html(rows);
                

                // Handle pagination
                const totalPages = Math.ceil(response.total / response.limit);
                generatePagination(totalPages, response.page);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }
    // Function to generate pagination buttons
    function generatePagination(totalPages, currentPage) {
        let pagination = "";

        // Previous button
        if (currentPage > 1) {
            pagination += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
                </li>
            `;
        } else {
            pagination += `
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            `;
        }

        // Generate page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                pagination += `
                    <li class="page-item ${i === currentPage ? "active" : ""}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                pagination += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                `;
            }
        }

        // Next button
        if (currentPage < totalPages) {
            pagination += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
                </li>
            `;
        } else {
            pagination += `
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            `;
        }

        $("#pagination").html(pagination);

        // Attach click event to pagination buttons
        $("#pagination .page-link").click(function (e) {
            e.preventDefault();
            const page = $(this).data("page");
            const search = $("#searchInput").val();
            fetchSchool(page, search);
        });
    }
    // ADD withdrawal item onclick btn
    $(document).on('click', '#addBtns' , function(){
        $('#schoolForm')[0].reset();
        $('#formFooter').html(`<button type="submit" class="btn btn-primary" id="saveSchoolButton">Save</button>`)
    })
    // // Function to add documents
    $(document).on('click', '#saveSchoolButton' , function(e){
        var school_id = $("#schoolId").val();
        var school_name = $("#schoolName").val();

        // Check if the input quantity is greater than remaining quantity
        if (school_id === '' || school_name === '') {
            toastr.warning('input all required fields.');
            e.preventDefault(); // Prevent form submission
            return;
        }else{
            var formData = new FormData();
            formData.append('school_id', school_id);
            formData.append('school_name', school_name);
            console.log(formData)

            $.ajax({
                url: "data/add_school.php",
                type: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire(
                            'Saved!',
                            'Successfully Addded.',
                            'success'
                        );
                        $("#addModal").modal("hide");
                        fetchSchool();
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                    alert("An error occurred: " + error);
                }
            });
        }
    });

    // // UPDATE  Item onclick btn
    $(document).on('click', '#update-btn' , function(){
        const schoolId = $(this).data('update-id');
        console.log(schoolId)
        $('#formFooter').html(`<button type="submit" class="btn btn-success" id="updateSchoolButton">update</button>`)
        $('#schoolForm')[0].reset();   
        $.ajax({
            url: "data/getSchoolDetails.php", // Endpoint to fetch details
            type: "GET",
            data: { id: schoolId },
            dataType: "json",
            success: function (response) {
               
                if (response.success) {
                    $("#scId").val(response.data.id);
                    $("#schoolId").val(response.data.school_id);
                    $("#schoolName").val(response.data.school_name);
                } else {
                    alert("Failed to fetch document details.");
                }
            },
            error: function () {
                alert("An error occurred while fetching the document details.");
            },
        });
    })
    
    $(document).on('click', '#updateSchoolButton' , function(e){
        var id = $("#scId").val();
        var school_id = $("#schoolId").val();
        var school_name = $("#schoolName").val();

        // Check if the input quantity is greater than remaining quantity
        if (school_id === '' || school_name === '') {
            toastr.warning('input all required fields.');
            e.preventDefault(); // Prevent form submission
            return;
        }else{
            var formData = new FormData();
            formData.append('id', id);
            formData.append('school_id', school_id);
            formData.append('school_name', school_name);
            console.log(formData)

            $.ajax({
                url: "data/updateSchool.php",
                type: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success === true) {
                        Swal.fire(
                            'Saved!',
                            'Successfully Updated.',
                            'success'
                        );
                        $("#addModal").modal("hide");
                        fetchSchool();
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                    console.log("An error occurred: " + error);
                }
            });
        }
    });

    
    // Handle search input
    $("#searchInput").on("keyup", function () {
        const search = $(this).val();
        currentPage = 1; // Reset to first page on new search
        fetchSchool(currentPage, search);
    }); 
    fetchSchool();
    // setInterval(updateNotif, 2000);
    // Delete encoded items using SweetAlert
    $(document).on("click", ".delete-btn", function() {
        const documentId = $(this).data("id");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with delete request
                $.ajax({
                    url: "data/delete_school.php",
                    type: "POST",
                    data: { id: documentId },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire(
                                'Deleted!',
                                'Your school has been deleted.',
                                'success'
                            );
                            fetchSchool(currentPage); // Refresh the document list
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the school.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the withdrawal items.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});


</script>