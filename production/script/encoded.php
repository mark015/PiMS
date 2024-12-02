<script>

$(document).ready(function () {
    let currentPage = 1;
    var role = "<?php echo $rowUser['role'];?>";    
    
    // Function to fetch and display data
    function fetchItems(page = 1, search = "") {
        $.ajax({
            url: "data/fetch_items.php",
            type: "GET",
            data: { page: page, search: search },
            dataType: "json",
            success: function (response) {
                let rows = "";
                response.data.forEach(function (item) {
                    if(role === 'Admin'){
                        
                        var deleteBtn =  `<button class="btn btn-danger btn-sm delete-btn" data-id="${item.eId}">Delete</button>`
                    }else {
                        var deleteBtn = '';
                    }

                    rows += `
                        <tr>
                            <td>${item.item_code}</td>
                            <td>${item.item_desc}</td>
                            <td>${item.remaining_quantity}</td>
                            <td>${item.date || "N/A"}</td>
                            <td>
                                ${deleteBtn}
                                <button class="btn btn-success btn-sm" id="update-btn" data-update-id="${item.eId}">Update</button>
                            </td>
                        </tr>
                    `;
                });
                $("#encodedTable tbody").html(rows);
                

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
    
    // ADD Encoded onclick btn
    $(document).on('click', '#addBtns' , function(){
        $('#addItemForm')[0].reset();
        $('#modalHeader').html(`<h5 class="modal-title" id="addModalLabel">Add New Encoded Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>`)
        $('#footerModal').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="saveItemButton">Save</button>`)
    })

    // // UPDATE  Item onclick btn
    $(document).on('click', '#update-btn' , function(){
        const itemId = $(this).data('update-id');
        console.log(itemId)
        $('#footerModal').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="updateItemButton">Save</button>`)
                
        $('#modalHeader').html(`<h5 class="modal-title" id="addModalLabel">Update Encoded Items</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>`)   
        $('#addItemForm')[0].reset();
        $.ajax({
            url: "data/getItemDetails.php", // Endpoint to fetch details
            type: "GET",
            data: { id: itemId },
            dataType: "json",
            success: function (response) {
                console.log(response)
                if (response.success) {
                    $("#itemId").val(response.data.id);
                    $("#itemCode").val(response.data.item_code);
                    $("#itemDesc").val(response.data.item_desc);
                    $("#itemQuantity").val(response.data.quantity);
                    $("#itemDate").val(response.data.date);
                    $("#addModal").modal("show");
                } else {
                    alert("Failed to fetch encoded items details.");
                }
            },
            error: function () {
                alert("An error occurred while fetching the encoded item details.");
            },
        });
    })
    
    $(document).on('click', '#updateItemButton' , function(){
        var itemId = $("#itemId").val();
        var itemCode = $("#itemCode").val();
        var itemDesc = $("#itemDesc").val();
        var itemQuantity = $("#itemQuantity").val();
        var itemDate = $("#itemDate").val();
        

        var formData = new FormData();
        formData.append('itemCode', itemCode);
        formData.append('itemDesc', itemDesc);
        formData.append('itemQuantity', itemQuantity);
        formData.append('itemDate', itemDate);
        formData.append('itemId', itemId);

        $.ajax({
            url: "data/updateItem.php",
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
    });

    // // Function to add encoded item
    $(document).on('click', '#saveItemButton' , function(){
    
        var itemCode = $("#itemCode").val();
        var itemDesc = $("#itemDesc").val();
        var itemQuantity = $("#itemQuantity").val();
        var itemDate = $("#itemDate").val();
        

        var formData = new FormData();
        formData.append('itemCode', itemCode);
        formData.append('itemDesc', itemDesc);
        formData.append('itemQuantity', itemQuantity);
        formData.append('itemDate', itemDate);

        $.ajax({
            url: "data/add_item.php",
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
        const itemId = $(this).data("id");

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
                    url: "data/delete_items.php",
                    type: "POST",
                    data: { id: itemId },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire(
                                'Deleted!',
                                'Your encoded item has been deleted.',
                                'success'
                            );
                            fetchItems(currentPage); // Refresh the encoded list
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the encoded item.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the encoded.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    // function updateNotif(){
    //     $.ajax({
    //         url: "data/updateNotif.php",
    //         type: "POST",
    //         dataType: "json",
    //         success: function (response) {
    //             if (response.success) {
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             console.error("AJAX Error:", xhr.responseText);
    //             alert("An error occurred: " + error);
    //         }
    //     });
    // }
});


</script>