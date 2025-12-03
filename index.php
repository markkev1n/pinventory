<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pinventory - Pigeon Inventory</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #122c2d;
    }

    h2 {
      color: #ffffff;
    }

    @media (max-width: 767px) {
      table thead {
        display: none;
      }

      table,
      tbody,
      tr,
      td {
        display: block;
        width: 100%;
      }

      tr {
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
        padding: 10px;
        border-radius: 5px;
        background: #f8f9fa;
      }

      td {
        text-align: left;
        border: none;
        padding: 8px;
      }

      td::before {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        content: attr(data-label);
      }

      .card-body {
        padding: 0px;
      }

      tr {
        border-radius: 0px;
      }
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <h2 class="text-center">Dos Loft Pigeon Inventory</h2>

    <!-- Add/Edit Pigeon Modal -->
    <div class="modal fade" id="addPigeonModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Add New Pigeon</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="pigeonForm">
            <input type="hidden" name="id" id="pigeon_id">
            <div class="modal-body">
              <div class="form-group">
                <label>Ring Number</label>
                <input type="text" name="ring_number" class="form-control" style="text-transform: uppercase;" required>
              </div>
              <div class="form-group">
                <label>Pigeon Name</label>
                <input type="text" name="pigeon_name" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Color</label>
                <input type="text" name="pigeon_color" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Bloodline</label>
                <textarea name="bloodline" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <label>Age</label>
                <input type="text" name="age" class="form-control" placeholder="e.g., 2 years and 3 months" required>
              </div>
              <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control" required>
                  <option value="Hen">Hen</option>
                  <option value="Cock">Cock</option>
                </select>
              </div>
              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                  <option value="Alive">Alive</option>
                  <option value="Dead">Dead</option>
                  <option value="Sold">Sold</option>
                  <option value="Breeder">Breeder</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="saveBtn">Add Pigeon</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="card mt-4">
      <div class="card-header d-flex justify-content-between">
        <span>Pigeon Inventory</span>
        <button class="btn btn-primary" id="addNew" data-toggle="modal" data-target="#addPigeonModal">Add Pigeon</button>
      </div>

      <div class="card-body">
        <div class="input-group py-md-2">
          <div class="form-outline">
            <input type="search" id="searchInput" class="form-control" placeholder="Search" />
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Ring Number</th>
                <th>Name</th>
                <th>Color</th>
                <th>Bloodline</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="pigeonTableBody">
              <?php
              $limit = 10;
              $page = isset($_GET['page']) ? $_GET['page'] : 1;
              $offset = ($page - 1) * $limit;
              $total_records_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM pigeons");
              $total_records = mysqli_fetch_assoc($total_records_query)['total'];
              $total_pages = ceil($total_records / $limit);
              $result = mysqli_query($conn, "SELECT * FROM pigeons LIMIT $offset, $limit");
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td data-label='ID'>{$row['id']}</td>";
                echo "<td data-label='Ring Number'>{$row['ring_number']}</td>";
                echo "<td data-label='Name'>{$row['pigeon_name']}</td>";
                echo "<td data-label='Color'>{$row['pigeon_color']}</td>";
                echo "<td data-label='Bloodline'>{$row['bloodline']}</td>";
                echo "<td data-label='Age'>{$row['age']}</td>";
                echo "<td data-label='Gender'>{$row['gender']}</td>";
                echo "<td data-label='Status'>{$row['status']}</td>";
                echo "<td data-label='Actions'>
                        <button class='btn btn-warning btn-sm editBtn' data-id='{$row['id']}' data-ring='{$row['ring_number']}' data-name='{$row['pigeon_name']}' data-color='{$row['pigeon_color']}' data-bloodline='{$row['bloodline']}' data-age='{$row['age']}' data-gender='{$row['gender']}' data-status='{$row['status']}' data-toggle='modal' data-target='#addPigeonModal'>Edit</button>
                        <button class='btn btn-danger btn-sm deleteBtn' data-id='{$row['id']}'>Delete</button>
                      </td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-end">
            <?php if ($page > 1): ?>
              <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
              <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <script>
    $(document).ready(function() {
      // Add New Pigeon
      $('#addNew').click(function() {
        $('#pigeonForm')[0].reset();
        $('#pigeon_id').val('');
        $('#modalTitle').text('Add New Pigeon');
        $('#saveBtn').text('Add Pigeon');
      });

      // Edit Pigeon
      $('.editBtn').click(function() {
        const data = $(this).data();
        $('#pigeon_id').val(data.id);
        $('input[name="ring_number"]').val(data.ring);
        $('input[name="pigeon_name"]').val(data.name);
        $('input[name="pigeon_color"]').val(data.color);
        $('textarea[name="bloodline"]').val(data.bloodline);
        $('input[name="age"]').val(data.age);
        $('select[name="gender"]').val(data.gender);
        $('select[name="status"]').val(data.status);

        $('#modalTitle').text('Edit Pigeon');
        $('#saveBtn').text('Save Changes');
      });

      //Delete
      $(document).on('click', '.deleteBtn', function() {
        const pigeonId = $(this).data('id');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: `delete.php?id=${pigeonId}`,
              method: 'GET',
              success: function(response) {
                if (response.trim() === 'success') {
                  Swal.fire('Deleted!', 'Pigeon has been deleted.', 'success').then(() => location.reload());
                } else {
                  Swal.fire('Error!', 'Failed to delete the pigeon.', 'error');
                }
              },
              error: function() {
                Swal.fire('Error!', 'Something went wrong.', 'error');
              }
            });
          }
        });
      });

      $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
          var value = $(this).val().toLowerCase();
          $('#pigeonTableBody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
      });


      // Submit Form with AJAX
      $(document).ready(function() {
        $('#pigeonForm').submit(function(e) {
          e.preventDefault();
          $.ajax({
            url: $('#pigeon_id').val() ? 'edit.php' : 'add.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
              if (response.includes('Duplicate entry')) {
                Swal.fire({
                  icon: 'error',
                  title: 'Duplicate Entry',
                  text: 'A pigeon with this ring number already exists!'
                });
              } else {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: response
                }).then(() => location.reload());
              }
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong!'
              });
            }
          });
        });
      });
    });
  </script>
</body>

</html>