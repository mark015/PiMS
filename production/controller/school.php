<div class="container mt-5">
    <h3>Schools</h3>
    
    <div class="row">
        <div class="col-md-8">
            <div class="row mb-3 align-items-center">
                <div class="col-md-10">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search..." />
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" id="addBtns"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <table id="schoolTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>School ID</th>
                        <th>School Name</th>
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
        <div class="col-md-4">
            <form id="schoolForm">
                <!-- Hidden Input for Item ID -->
                <input type="text" id="scId" name="scId" hidden />
                <!-- Hidden Input for Status -->
                <div class="mb-3">
                    <label for="schoolId" class="form-label">*School ID</label>
                    <input type="text" class="form-control" id="schoolId" name="schoolId" required />
                    <ul id="dropdownList" class="dropdown-menu" ></ul>
                </div>
                <div class="mb-3">
                    <label for="schoolName" class="form-label">*School Name</label>
                    <input type="text" class="form-control" id="schoolName" name="schoolName" required />
                    <ul id="dropdownList" class="dropdown-menu" ></ul>
                </div>
            </form>
            
            <div id="formFooter">
                    <button type="submit" class="btn btn-primary" id="saveSchoolButton">Save</button>
                </div>
        </div>
    </div>
</div>