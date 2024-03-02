    <!DOCTYPE html>
    <html lang="en">

    <head>


        <link rel='stylesheet'
            href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Arvo'>

        <style>
            .page_404 {
                padding: 40px 0;
                background: #fff;
                font-family: 'Arvo', serif;
            }

            .page_404 img {
                width: 100%;
            }

            .four_zero_four_bg {

                /* background-image: url({!! asset('error-images/404.gif') !!});     */
                background-image: url('http://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif');
                height: 400px;
                background-position: center;
            }


            .four_zero_four_bg h1 {
                font-size: 80px;
            }

            .four_zero_four_bg h3 {
                font-size: 80px;
            }

            .link_404 {
                color: #fff !important;
                padding: 10px 20px;
                background: linear-gradient(135deg, rgb(21, 153, 21),
                        rgb(15, 186, 15), rgb(54, 227, 54));
                border-radius: 8px;
                margin: 10px 0;
                display: inline-block;
                text-decoration: none;
            }

            .link_404:hover {
                text-decoration: none;
                box-shadow: 3px 3px 10px 0px #635f5f;
                animation: shake 500ms;
                background: linear-gradient(100deg, rgb(21, 153, 21),
                        rgb(15, 186, 15), rgb(54, 227, 54));
            }

            @keyframes shake {
                0% {
                    transform: translate(1px, 1px) rotate(0deg);
                }

                10% {
                    transform: translate(-1px, -2px) rotate(-1deg);
                }

                20% {
                    transform: translate(-3px, 0px) rotate(1deg);
                }

                30% {
                    transform: translate(3px, 2px) rotate(0deg);
                }

                40% {
                    transform: translate(1px, -1px) rotate(1deg);
                }

                50% {
                    transform: translate(-1px, 2px) rotate(-1deg);
                }

                60% {
                    transform: translate(-3px, 1px) rotate(0deg);
                }

                70% {
                    transform: translate(3px, 1px) rotate(-1deg);
                }

                80% {
                    transform: translate(-1px, -1px) rotate(1deg);
                }

                90% {
                    transform: translate(1px, 2px) rotate(0deg);
                }

                100% {
                    transform: translate(1px, -2px) rotate(-1deg);
                }
            }

            .contant_box_404 {
                margin-top: -50px;
            }
        </style>
    </head>

    <body>

        <section class="page_404">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="col-sm-10 col-sm-offset-1 text-center">
                            <div class="four_zero_four_bg">
                                <h1 class="text-center ">404</h1>
                            </div>

                            <div class="contant_box_404">
                                <h3 class="h2">
                                    Look like you're lost
                                </h3>

                                <p>the page you are looking for not avaible!</p>

                                <a href="
                                {{ $redirectUrl ? $redirectUrl : route('user.dashboard') }}
                                "
                                    class="link_404">Go to Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </body>

    </html>
