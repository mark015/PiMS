<div class="container mt-4 d-flex justify-content-center align-items-center">
    <div class="card shadow-lg" style="width: 400px; border-radius: 15px;">
        <div class="card-body">
            <h3 class="text-center mb-4">Profile</h3>
            <table class="table table-borderless">
                <tr>
                    <td class="fw-bold text-secondary">Name:</td>
                    <td class="text-dark"><?php echo ucwords($rowUser['name']); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold text-secondary">Username:</td>
                    <td class="text-dark"><?php echo ucwords($rowUser['username']); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold text-secondary">Role:</td>
                    <td class="text-dark"><?php echo ucwords($rowUser['role']); ?></td>
                </tr>
            </table>
            <div class="text-center mt-4">
                <button class="btn btn-success btn-sm" style="border-radius: 20px;" data-bs-toggle="modal" data-bs-target="#updateProfileModal">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form id="updateProfileForm">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="userId" value="<?php echo $rowUser['id']; ?>" hidden>
                    </div>
                    <div class="mb-3">
                        <label for="updateName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="updateName" value="<?php echo $rowUser['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="updateUsername" value="<?php echo $rowUser['username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateRole" class="form-label">Role</label>
                        <input type="text" class="form-control" id="updateRole" value="<?php echo $rowUser['role']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Old Password</label>
                        <input type="password" class="form-control" id="oldPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success btn-sm" id="saveProfileButton">Save Changes</button>
            </div>
        </div>
    </div>
</div>
