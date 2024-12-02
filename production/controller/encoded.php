<style>
.pagination .page-item.disabled .page-link {
    color: #6c757d;
    cursor: not-allowed;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}
.w-50{
    width: 50%;
}
</style>


<div class="container mt-5">
    <h3>Encoded Items</h3>
    <div class="row mb-3 align-items-center">
        <div class="col-md-10">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Item Code..." />
        </div>
        <div class="col-md-2 text-end" id="addBtn">
            <button class="btn btn-primary" id="addBtns" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    
    <table id="encodedTable" class="table table-striped">
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Item Description</th>
                <th>Item Quantity</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic rows will be injected here -->
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-end" id="pagination">
            <!-- Pagination buttons will be injected here -->
        </ul>
    </nav>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" id="modalHeader">
                
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addItemForm">
                    <!-- Hidden Input for Document ID -->
                    <input type="text" id="itemId" name="itemId" hidden />
                    <!-- Hidden Input for Status -->
                    <div class="mb-3">
                        <label for="itemCode" class="form-label">Item Code</label>
                        <input type="text" class="form-control" id="itemCode" name="itemCode" required />
                    </div>
                    <div class="mb-3">
                        <label for="documentTitle" class="form-label">Item Description</label>
                        <input type="text" class="form-control" id="itemDesc" name="itemDesc" required />
                    </div>
                    <div class="mb-3">
                        <label for="itemQuantity" class="form-label">Item Quantity</label>
                        <input type="number" class="form-control" id="itemQuantity" name="itemQuantity" required/>
                        <div class="mb-3" id="filePreview"></div>
                    </div>
                    <div class="mb-3">
                        <label for="itemDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="itemDate" name="itemDate" required/>
                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer" id="footerModal">
                
            </div>
        </div>
    </div>
</div>