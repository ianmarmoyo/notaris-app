<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Page Not Found</title>
    <style type="text/css">
        body {
            margin-top: 150px;
            background-color: #C4CCD9;
        }

        .error-main {
            background-color: #fff;
            box-shadow: 0px 10px 10px -10px #5D6572;
        }

        .error-main h1 {
            font-weight: bold;
            color: #444444;
            font-size: 150px;
            text-shadow: 2px 4px 5px #6E6E6E;
        }

        .error-main h6 {
            color: #42494F;
            font-size: 20px;
        }

        .error-main p {
            color: #9897A0;
            font-size: 15px;
        }

        a.back-to-dashboard {
            font-weight: 700
        }

        a:link {
            text-decoration: none;
        }

        a:visited {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        a:active {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row text-center">
            <div class="col-lg-6 offset-lg-3 col-sm-6 offset-sm-3 col-12 p-3 error-main">
                <div class="row">
                    <div class="col-lg-8 col-12 col-sm-10 offset-lg-2 offset-sm-1">
                        <h1 class="m-0">404</h1>
                        <h6>Halaman Tidak Ditemukan</h6>
                            <p>Silahkan kembali ke <span class="text-info text-uppercase">
                                    <a href="{{ route('admin-dashboard-analytics') }}"
                                        class="back-to-dashboard">dahsboard</a>.
                                </span>
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
