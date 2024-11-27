<?php

use App\Models\Student;
// Define the array_flatten function if it doesn't already exist
if (!function_exists('array_flatten')) {
  function array_flatten($array)
  {
    $result = [];

    foreach ($array as $item) {
      if (is_array($item)) {
        $result = array_merge($result, array_flatten($item));
      } else {
        $result[] = $item;
      }
    }

    return $result;
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View History</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
  <nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand text-light" href="{{route('home')}}">Home</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#"></a>
          </li>
        </ul>

      </div>
    </div>
  </nav>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header bg-info text-light">
            <h5 class="mb-0">Form Data</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Form Data</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($students->reverse() as $student)
                  <tr>
                    <td>{{ $student->id }}</td>
                    <td>
                      @php
                      $formData = json_decode($student->form_data, true);
                      @endphp
                      @if(!empty($formData))
                      <ul class="list-unstyled">
                        @foreach($formData as $label => $value)
                        @if ($label !== '_token')
                        <li><strong>{{ $label }}:</strong>
                          @if (is_array($value))
                          {{ implode(', ', array_flatten($value)) }}
                          @else
                          {{ $value }}
                          @endif
                        </li>
                        @endif
                        @endforeach
                      </ul>
                      @else
                      No form data available
                      @endif
                    </td>
                    <td>{{ $student->created_at }}</td>
                    <td>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $student->id }}">
                        <i class="fas fa-trash"></i> Delete
                      </button>
                    </td>
                  </tr>
                  <!-- Delete Modal -->
                  <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $student->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header bg-danger text-light">
                          <h5 class="modal-title" id="deleteModalLabel{{ $student->id }}">Confirm Deletion</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to delete this record?
                        </div>
                        <div class="modal-footer">
                          <form action="{{ route('studentdelete', ['id' => $student->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                          </form>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap JS -->
  <!-- /.content-wrapper -->
  <footer class="main-footer mb-4 mt-4 mx-4 text-center">
    <strong>Copyright &copy;<a href="">ADforms</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>AD</b>
    </div>
  </footer>
</body>

</html>