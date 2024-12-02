<script>

$(document).ready(function () {
    let currentPage = 1;
    var role = "<?php echo $rowUser['role'];?>";    
    
    // Function to fetch and display data
    function fetchItems(page = 1, search = "") {
        $.ajax({
            url: "data/fetch_withdrawal.php",
            type: "GET",
            data: { page: page, search: search },
            dataType: "json",
            success: function (response) {
                let rows = "";
                response.data.forEach(function (item) {
                    if(role === 'Admin'){
                        var deleteBtn =  `<button class="btn btn-danger btn-sm delete-btn" data-id="${item.wId}">Delete</button>`
                    }else {
                        var deleteBtn = '';
                    }

                    rows += `
                        <tr>
                            <td>${item.item_code}</td>
                            <td>${item.item_desc}</td>
                            <td>${item.wQuantity}</td>
                            <td>${item.date || "N/A"}</td>
                            <td>${item.scId || "N/A"}</td>
                            <td>${item.school_name || "N/A"}</td>
                            <td>
                                ${deleteBtn}
                                <button class="btn btn-success btn-sm" id="update-btn" data-update-id="${item.wId}">Update</button>
                            </td>
                        </tr>
                    `;
                });
                $("#withdrawalTable tbody").html(rows);
                

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
            fetchItems(page, search);
        });
    }

   // Fetch suggestions dynamically
    $('#itemCode').on('keyup', function () {
        const query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: 'data/getItems.php', // Endpoint to fetch item suggestions
                type: 'GET',
                data: { query: query },
                dataType: 'json',
                success: function (response) {
                    const dropdownList = $('#dropdownList');
                    dropdownList.empty(); // Clear previous suggestions
                    console.log(response)
                    if (response.success && response.items.length > 0) {
                        response.items.forEach((item) => {
                            dropdownList.append(`<li class="dropdown-item" data-code="${item.item_code}" data-desc="${item.item_desc}" data-rquantity = "${item.rQuantity}">${item.item_code} -- ${item.item_desc} -- ${item.rQuantity} </li>`);
                        });
                        dropdownList.show(); // Show the dropdown
                    } else {
                        dropdownList.hide(); // Hide if no results
                    }
                },
                error: function () {
                    console.error('Error fetching item codes.');
                }
            });
        } else {
            $('#dropdownList').hide(); // Hide if input is empty
        }
    });

    // Handle item selection from dropdown
    $(document).on('click', '#dropdownList li', function () {
        let code = $(this).data('code');
        let desc = $(this).data('desc');
        let rQuantity = $(this).data('rquantity');
        console.log(rQuantity)
        $('#itemCode').val(code);
        $('#remainingQuantity').val(rQuantity);
        $('#itemDesc').val(desc);
        $('#dropdownList').hide();
    });

    // Hide dropdown when clicking outside
    $(document).click(function (e) {
        if (!$(e.target).closest('#itemCode, #dropdownList').length) {
            $('#dropdownList').hide();
        }
    });
    
    // ADD withdrawal item onclick btn
    $(document).on('click', '#addBtns' , function(){
        $('#addItemForm')[0].reset();
        $('#modalHeader').html(`<h5 class="modal-title" id="addModalLabel">Add New Withdrawal Items</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>`)
        $('#footerModal').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="savewithdrawalButton">Save</button>`)
    })
    // // Function to add documents
    $(document).on('click', '#savewithdrawalButton' , function(e){
        var itemCode = $("#itemCode").val();
        var itemDesc = $("#itemDesc").val();
        var itemQuantity = parseInt($("#itemQuantity").val());
        var school = $("#school").val();
        var rQuantity = parseInt($("#remainingQuantity").val());

        if(itemCode === '' || itemDesc === '' || itemQuantity === '' || school === '' || rQuantity === ''){
            toastr.warning('input all required fields.');
            e.preventDefault(); // Prevent form submission
            return;
        }
        // Check if the input quantity is greater than remaining quantity
        if (itemQuantity > rQuantity) {
            toastr.warning('Not enough remaining quantity available.');
            e.preventDefault(); // Prevent form submission
            return;
        }else{
            var formData = new FormData();
            formData.append('itemCode', itemCode);
            formData.append('itemDesc', itemDesc);
            formData.append('itemQuantity', itemQuantity);
            formData.append('school', school);

            $.ajax({
                url: "data/add_withdrawal_item.php",
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
                        fetchItems();
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
        const withdralId = $(this).data('update-id');
        $('#modalHeader').html(`<h5 class="modal-title" id="addModalLabel">Update Withdrawal Items</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>`)
        $('#footerModal').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="updateWithdrawalButton">Save</button>`)
        $('#addItemForm')[0].reset();   
        $.ajax({
            url: "data/getWithdrawalDetails.php", // Endpoint to fetch details
            type: "GET",
            data: { id: withdralId },
            dataType: "json",
            success: function (response) {
                console.log(response)
                if (response.success) {
                    $("#itemId").val(response.data.wid);
                    $("#itemCode").val(response.data.code);
                    $("#itemDesc").val(response.data.desc);
                    $("#itemQuantity").val(response.data.wquantity);
                    $("#remainingQuantity").val(response.remainingQuantity);
                    $("#school").append(new Option(response.data.scName, response.data.sid));
                    $("#addModal").modal("show");
                } else {
                    alert("Failed to fetch document details.");
                }
            },
            error: function () {
                alert("An error occurred while fetching the document details.");
            },
        });
    })
    
    $(document).on('click', '#updateWithdrawalButton' , function(e){
        var id = $("#itemId").val();
        var itemDesc = $("#itemDesc").val();
        var itemCode = $("#itemCode").val();
        var itemQuantity = parseInt($("#itemQuantity").val());
        var school = $("#school").val();
        var rQuantity = parseInt($("#remainingQuantity").val());

        if(itemCode === '' || itemDesc === '' || itemQuantity === '' || school === '' || rQuantity === ''){
            toastr.warning('input all required fields.');
            e.preventDefault(); // Prevent form submission
            return;
        }
        // Check if the input quantity is greater than remaining quantity
        if (itemQuantity > rQuantity || itemQuantity == 0) {
            toastr.warning('Not enough remaining quantity available.');
            e.preventDefault(); // Prevent form submission
            return;
        }else{
            var formData = new FormData();
            formData.append('itemCode', itemCode);
            formData.append('itemDesc', itemDesc);
            formData.append('itemQuantity', itemQuantity);
            formData.append('school', school);
            formData.append('id', id);

            $.ajax({
                url: "data/updateWithdrawal.php",
                type: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success === true) {
                        Swal.fire(
                            'Saved!',
                            'Successfully Addded.',
                            'success'
                        );
                        $("#addModal").modal("hide");
                        fetchItems();
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
        fetchItems(currentPage, search);
    }); 
    fetchItems();
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
                    url: "data/delete_withdrawal.php",
                    type: "POST",
                    data: { id: documentId },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire(
                                'Deleted!',
                                'Your withdrawal items has been deleted.',
                                'success'
                            );
                            fetchItems(currentPage); // Refresh the document list
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the withdrawal items.',
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