<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link rel="icon" href="{{ asset('images/5.ico') }}" type="image/x-icon">
</head>

<body>
 
  <div class="container-fluid mt-4">
    <div class="row justify-content-center">
      <div class="col-md-4">
      
          <form class="w-100" action="" method="">
          
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control form-control-sm" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="email" name="email">
            </div>
            
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control form-control-sm" required="required" id="password" name="password">
            </div>
           
            <button type="submit" value="login" class="btn btn-danger">Login</button>
            <a href="{{ route('operation.welcome')}}" class="btn btn-danger">Create a account</a>
          </form>
        </div>
      </div>
    </div>
  </div>
 
</body>

</html>
