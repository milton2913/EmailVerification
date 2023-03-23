<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Validation & Verification</title>

    <link rel="shortcut icon" href="images/fav.png')}}" type="image/x-icon">

    <!-- ----------------------- Google Font start ----------------------- -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- ----------------------- Google Font end ----------------------- -->

    <!-- ----------------------- css start ----------------------- -->
    <link rel="stylesheet" href="{{ url('theme/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{ url('theme/css/style.css')}}">
    <link rel="stylesheet" href="{{ url('theme/css/responsive.css')}}">
    <!-- ----------------------- css end ----------------------- -->
</head>
<body>
<!-- ----------------------- preloader start ----------------------- -->
<div id="preloader"></div>
<!-- ----------------------- preloader end ----------------------- -->

<!-- ----------------------- Navbar start ----------------------- -->
<nav class="navbar navbar-expand-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ url('theme/images//diu_logo.png')}}" alt="DIU Logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="btn regular_btn" href="#">Login with Metamask</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- ----------------------- Navbar end ----------------------- -->

<!-- ----------------------- main section start ----------------------- -->
<section id="main">
    <div class="container">
        <h2 class="heading_24">Email Validation & Verification</h2>

        <div class="row">
            <div class="offset-xxl-1 col-xxl-10 offset-xl-1 col-xl-10 offset-lg-1 col-lg-10 col-md-12 col-sm-12">
                <div class="main_box">
                    <div class="content_box">

                        <form data-action="{{ route('email-verify') }}" method="POST" enctype="multipart/form-data" id="add-user-form">

                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                                <p class="verification_text text_14 text_light mt_10">* Check whether the email address is valid or not</p>
                            </div>
                            <button type="submit" class="btn regular_btn mt_35">Verify</button>

                        </form>

                    </div>

                    <div class="student_details text_light_2" id="message">
                        <h6 class="sub_heading mt_10">Email Address: support@emailvalidation.com</h6>

                        <p class="text_14 mb_15">Valid Format: <span class="text_white text_semibold"></span></p>
                        <p class="text_14 student_name mb_15"><span>SMTP: </span><span class="text_white text_semibold"></span></p>
                        <p class="text_14 mb_15">MX-Records: <span class="text_white text_semibold"></span></p>
                        <p class="text_14 mb_15">Catch-All: <span class="text_white text_semibold"></span></p>
                        <p class="text_14 mb_15">Role: <span class="text_white text_semibold"></span></p>
                        <p class="text_14 mb_15">Disposable: <span class="text_white text_semibold"></span></p>
                        <p class="text_14 mb_15">Free: <span class="text_white text_semibold"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ----------------------- main section end ----------------------- -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<!-- ----------------------- script start ----------------------- -->
<script src="{{ url('theme/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('theme/js/script.js') }}"></script>
<!-- ----------------------- script end ----------------------- -->

<script type="text/javascript">

    $(document).ready(function(){
        var form = '#add-user-form';
        $(form).on('submit', function(event){
            event.preventDefault();
            var url = $(this).attr('data-action');
            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(response)
                {
                    // alert(response.success)
                    $('#message').html(response.success);
                },
                error: function(response) {
                }
            });
        });

    });

</script>
</body>
</html>
