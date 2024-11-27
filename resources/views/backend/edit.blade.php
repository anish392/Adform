<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link rel="icon" href="{{ asset('images/5.ico') }}" type="image/x-icon">
</head>

<body>
  <h1 class="text-center"> Edit Details</h1>
  <div class="container-fluid mt-4">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="container my-md-auto my-md-0">

          <div class="container my-md-auto my-md-0">
            @if(session('success'))
            <div class="alert alert-success mb-4" role="alert">
              {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger mb-4" role="alert">
              {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('studentupdate', $student->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" value="{{$student->email}}" class="form-control form-control-sm" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="email" name="email">
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" value="{{$student->name}}" class="form-control form-control-sm" required="required" id="name" name="name">
              </div>
              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" value="{{$student->address}}" class="form-control form-control-sm" required="required" id="address" name="address">
              </div>

              <div class="form-outline mb-4">
                <label for="phone" class="form-label">Mobile no.</label>
                <input type="text" value="{{$student->phone}}" pattern="^[9]\d{9,9}$" id="user_contact" class="form-control" placeholder="Enter your Mobile no." autocomplete="off" required="required" name="phone">
              </div>

              <button type="submit" value="update" class="btn btn-danger">Update</button>

            </form>
          </div>
        </div>
      </div>
    </div>

</body>

</html>