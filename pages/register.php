<!-- HTML Document -->
<html>
 <head>
  <!-- Document Title -->
  <title class="brand-color">
   Daftar Sekarang
  </title>
  
  <!-- External CSS Links -->
  <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="assets/css/brand.css" rel="stylesheet"/>
  
  <!-- Custom Styles -->
  <style>
   /* Body Styles */
        body {
            background-color: #02396f;
            font-family: 'Arial', sans-serif;
        }

        /* Container Styles */
        .container {
            background-color: white;
            padding: 30px;
            max-width: 85%;
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Form Element Styles */
        .form-control {
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 12px 15px;
        }
        .form-check-label {
            font-size: 14px;
        }

        /* Button Styles */
        .btn-primary {
            background-color: #cccccc;
            border: none;
            color: #666666;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #bbbbbb;
        }

        /* Footer Styles */
        .footer-links {
            text-align: center;
            margin-top: 20px;
        }
        .footer-links a {
            color: #666666;
            margin: 0 10px;
            text-decoration: none;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }

        /* Logo Styles */
        .logo {
            text-align: center;
            margin-top: 20px;
        }
        .logo img {
            max-width: 100px;
        }

        /* Input Group Styles */
        .input-group .input-group-text {
            border-radius: 8px 0 0 8px;
            padding: 12px 15px;
        }
        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }
  </style>
 </head>
 <body>
  <!-- Registration Form Container -->
  <div class="container rounded-4">
    <!-- Row start -->

    <div class="row">
      <!-- Bagian Form -->
      <div class="col-md-6">
        <h2 class="brand-color">
          Daftar Sekarang
         </h2>
         <form>
          <!-- Name Fields Section -->
          <div class="row">
           <div class="col-md-6">
            <label for="firstname" class="form-label brand-color">First name</label>
            <input class="form-control" id="firstname" type="text"/>
           </div>
           <div class="col-md-6">
            <label for="lastname" class="form-label brand-color">Last name</label>
            <input class="form-control" id="lastname" type="text"/>
           </div>
          </div>
      
          <!-- Contact Information Section -->
          <label for="email" class="form-label brand-color">Alamat Email</label>
          <input class="form-control" id="email" type="email"/>

          <!-- Nomor hp -->
          <label for="phone" class="form-label brand-color">Nomor Telepon</label>
          <input class="form-control" id="phone" type="number"/>
      
          <!-- Password Section -->
          <label for="password" class="form-label brand-color">Password</label>
          <input class="form-control" id="password" type="password"/>
          <small class="brand-color">
           Gunakan 8 karakter atau lebih dengan campuran huruf, angka & simbol
          </small>
      
          <!-- Role Selection Section -->
          <div class="form-check">
           <input class="form-check-input" id="peserta" name="role" type="radio" value="peserta"/>
           <label class="form-check-label brand-color" for="peserta">
            Peserta
           </label>
          </div>
          <div class="form-check">
           <input class="form-check-input" id="mitra" name="role" type="radio" value="mitra"/>
           <label class="form-check-label brand-color" for="mitra">
            Mitra
           </label>
          </div>
      
          <!-- Terms and Conditions Section -->
          <div class="form-check">
           <input class="form-check-input" id="shareData" type="checkbox"/>
           <label class="form-check-label brand-color" for="shareData">
            Share my registration data with our content providers for marketing purposes.
           </label>
          </div>
      
          <!-- Form Submission Section -->
          <button class="btn btn-primary rounded-pill btn-lg" type="submit">
           Sign up
          </button>
          <p class="brand-color">
           Already have an account?
           <a href="#" class="brand-color">
            Log in
           </a>
          </p>
         </form>      </div>
      <!-- bagian Image -->
      <div class="col-md-6">
        <div class="d-flex align-items-center justify-content-center h-100">
          <img src="assets/img/logo-worksmart.png" class="img-fluid">
        </div>
      </div>
    </div>
    <!-- Row End -->
  </div>
 </body>
 
</html>