<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tailor History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="d-flex">
        <?php $this->load->view('include/sidebar'); ?>
        <div class="main">
            <?php $this->load->view('include/navbar'); ?>

            <div class="container-fluid p-3 p-md-4">
                <div class="container mt-3 mt-md-5 p-3 p-md-4 bg-light rounded shadow">
                    <h2 class="section-heading mb-3 mb-md-4">Tailor History</h2>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tailorTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Product ID</th>
                                    <th>Tailor ID</th>
                                    <th>Tailor Name</th>
                                    <th>Alteration Type</th>
                                    <th>Return Date</th>
                                    <th>Tailor Instructions</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tailor_data)): ?>
                                    <?php foreach ($tailor_data as $row): ?>
                                        <tr data-id="<?= $row->id ?>">
                                            <td><?= $row->id ?></td>
                                            <td><?= $row->product_id ?></td>
                                            <td><?= $row->tailor_id ?></td>
                                            <td><?= $row->tailor_name ?></td>
                                            <td><?= $row->alteration_type ?></td>
                                            <td><?= $row->return_date ?></td>
                                            <td><?= $row->tailor_instructions ?></td>
                                            <td>
                                                <form method="post" action="<?= base_url('TailorController/update_status') ?>">
                                                    <input type="hidden" name="id" value="<?= $row->id ?>">
                                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        <option value="Pending" <?= $row->status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                        <option value="In Progress" <?= $row->status == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                                        <option value="Completed" <?= $row->status == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td><?= $row->created_at ?></td>
                                            <td>
                                                <!-- Send to Dryclean button -->
                                                <?php if ($row->status == 'Completed'): ?>
                                                    <a href="<?= base_url('AdminController/DryCleaning_Forward/' . $row->product_id) ?>"
                                                        class="btn btn-warning btn-sm btn-action">
                                                        Dry Clean
                                                    </a>
                                                <?php else: ?>
                                                    <button class="btn btn-warning btn-sm btn-action" disabled>
                                                        Dry Clean
                                                    </button>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div id="pagination" class="mt-3 d-flex justify-content-center"></div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let table = document.getElementById("tailorTable").getElementsByTagName("tbody")[0];
            let rows = table.getElementsByTagName("tr");
            let rowsPerPage = 5;
            let currentPage = 1;

            function displayRows() {
                for (let i = 0; i < rows.length; i++) {
                    rows[i].style.display = "none";
                }
                let start = (currentPage - 1) * rowsPerPage;
                let end = start + rowsPerPage;
                for (let i = start; i < end && i < rows.length; i++) {
                    rows[i].style.display = "";
                }
            }

            function setupPagination() {
                let pagination = document.getElementById("pagination");
                pagination.innerHTML = "";
                let pageCount = Math.ceil(rows.length / rowsPerPage);

                for (let i = 1; i <= pageCount; i++) {
                    let btn = document.createElement("button");
                    btn.innerText = i;
                    btn.classList.add("btn", "btn-sm", "btn-primary", "me-1");
                    if (i === currentPage) btn.classList.add("active");
                    btn.addEventListener("click", function() {
                        currentPage = i;
                        displayRows();
                        setupPagination();
                    });
                    pagination.appendChild(btn);
                }
            }

            displayRows();
            setupPagination();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar  toggler
        const toggler = document.querySelector(".toggler-btn");
        const closeBtn = document.querySelector(".close-sidebar");
        const sidebar = document.querySelector("#sidebar");

        if (toggler && sidebar) {
            toggler.addEventListener("click", function() {
                sidebar.classList.toggle("collapsed");
            });
        }

        if (closeBtn && sidebar) {
            closeBtn.addEventListener("click", function() {
                sidebar.classList.remove("collapsed");
            });
        }
    </script>

</body>

</html>