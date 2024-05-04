<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-main-structure.css">
    <link rel="stylesheet" href="styles/style-trip-finding.css">
    <link rel="stylesheet" href="styles/style-trip-selection.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_POST["departure"], $_POST["arrival"], $_POST["date"], $_POST["passengers"])) {
        $depart = $_POST["departure"];
        $arrivee = $_POST["arrival"];
        $date = $_POST["date"];
        $nbPassagers = $_POST["passengers"];
    } else {
        // echo "poute";
        $depart = "Lyon";
        $arrivee = "Paris";
    }
    ?>
    <header>
        <div class="title title-grid">
            <a href="trip-form.php">
                <div class="retour">&lt;</div>
            </a>
            <div>
                <h2><?php echo $depart . " --&gt; " . $arrivee ?></h2>
            </div>
        </div>
    </header>
    <main>
        <div class="trip-container">
            <div>
                <img src="../images/utilisateur.png" class="img-user">
            </div>
            <div>
                <span>Nom</span>
                <div>
                    <div class="avis-container">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" viewBox="0 0 1208.000000 1280.000000" preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                                <path d="M6036 12519 c-20 -58 -954 -3088 -1237 -4011 l-73 -238 -2123 0
                                    c-1168 0 -2123 -3 -2122 -7 0 -5 23 -25 50 -46 28 -21 571 -438 1207 -926 636
                                    -488 1380 -1057 1652 -1265 272 -208 501 -384 508 -390 10 -9 -123 -450 -643
                                    -2140 -360 -1171 -654 -2130 -652 -2132 1 -1 36 23 77 54 99 74 2006 1534
                                    2763 2115 l598 459 37 -28 c20 -15 237 -181 482 -369 363 -278 2650 -2030
                                    2864 -2193 l59 -46 -7 30 c-4 16 -297 973 -652 2127 -355 1154 -643 2104 -641
                                    2112 3 7 140 115 304 241 224 171 2139 1640 3036 2328 42 32 77 63 77 68 0 4
                                    -954 8 -2120 8 l-2119 0 -45 143 c-25 78 -210 678 -411 1332 -606 1969 -857
                                    2780 -861 2784 -2 2 -6 -2 -8 -10z" />
                            </g>
                        </svg>
                        <span>5</span>
                    </div>
                </div>
            </div>
            <div class="price">0,--€</div>
            <div class="trip-info">
                <div class="col" id="col1">
                    <div class="dep center-item-col">
                        départure
                    </div>
                    <!-- espace -->
                    <div class="point center-item-col">
                        <div class="circle-bg">
                            <div class="circle-upper"></div>
                        </div>
                    </div>
                    <!-- espace -->
                    <div class="hour center-item-col">
                        10h
                    </div>
                </div>
                <div class="col-flex" id="col2">

                    <div class="trait-horizontal"></div>
                </div>
                <div class="col" id="col3">
                    <div class="arr center-item-col">
                        arrivée
                    </div>
                    <div class="point center-item-col">
                        <div class="circle-bg">
                            <div class="circle-upper"></div>
                        </div>
                    </div>
                    <div class="hour center-item-col">
                        10h
                    </div>
                </div>
            </div>
        </div>
        <div class="trip-container">
            <div>
                <img src="../images/utilisateur.png" class="img-user">
            </div>
            <div>
                <span>Nom</span>
                <div>
                    <div class="avis-container">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" viewBox="0 0 1208.000000 1280.000000" preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                                <path d="M6036 12519 c-20 -58 -954 -3088 -1237 -4011 l-73 -238 -2123 0
                                    c-1168 0 -2123 -3 -2122 -7 0 -5 23 -25 50 -46 28 -21 571 -438 1207 -926 636
                                    -488 1380 -1057 1652 -1265 272 -208 501 -384 508 -390 10 -9 -123 -450 -643
                                    -2140 -360 -1171 -654 -2130 -652 -2132 1 -1 36 23 77 54 99 74 2006 1534
                                    2763 2115 l598 459 37 -28 c20 -15 237 -181 482 -369 363 -278 2650 -2030
                                    2864 -2193 l59 -46 -7 30 c-4 16 -297 973 -652 2127 -355 1154 -643 2104 -641
                                    2112 3 7 140 115 304 241 224 171 2139 1640 3036 2328 42 32 77 63 77 68 0 4
                                    -954 8 -2120 8 l-2119 0 -45 143 c-25 78 -210 678 -411 1332 -606 1969 -857
                                    2780 -861 2784 -2 2 -6 -2 -8 -10z" />
                            </g>
                        </svg>
                        <span>5</span>
                    </div>
                </div>
            </div>
            <div class="price">0,--€</div>
            <div class="trip-info">
                <div class="col" id="col1">
                    <div class="dep center-item-col">
                        départure
                    </div>
                    <!-- espace -->
                    <div class="point center-item-col">
                        <div class="circle-bg">
                            <div class="circle-upper"></div>
                        </div>
                    </div>
                    <!-- espace -->
                    <div class="hour center-item-col">
                        10h
                    </div>
                </div>
                <div class="col-flex" id="col2">

                    <div class="trait-horizontal"></div>
                </div>
                <div class="col" id="col3">
                    <div class="arr center-item-col">
                        arrivée
                    </div>
                    <div class="point center-item-col">
                        <div class="circle-bg">
                            <div class="circle-upper"></div>
                        </div>
                    </div>
                    <div class="hour center-item-col">
                        10h
                    </div>
                </div>
            </div>
        </div>
        <div class="trip-container">
            <div>
                <img src="../images/utilisateur.png" class="img-user">
            </div>
            <div>
                <span>Nom</span>
                <div>
                    <div class="avis-container">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" viewBox="0 0 1208.000000 1280.000000" preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                                <path d="M6036 12519 c-20 -58 -954 -3088 -1237 -4011 l-73 -238 -2123 0
                                    c-1168 0 -2123 -3 -2122 -7 0 -5 23 -25 50 -46 28 -21 571 -438 1207 -926 636
                                    -488 1380 -1057 1652 -1265 272 -208 501 -384 508 -390 10 -9 -123 -450 -643
                                    -2140 -360 -1171 -654 -2130 -652 -2132 1 -1 36 23 77 54 99 74 2006 1534
                                    2763 2115 l598 459 37 -28 c20 -15 237 -181 482 -369 363 -278 2650 -2030
                                    2864 -2193 l59 -46 -7 30 c-4 16 -297 973 -652 2127 -355 1154 -643 2104 -641
                                    2112 3 7 140 115 304 241 224 171 2139 1640 3036 2328 42 32 77 63 77 68 0 4
                                    -954 8 -2120 8 l-2119 0 -45 143 c-25 78 -210 678 -411 1332 -606 1969 -857
                                    2780 -861 2784 -2 2 -6 -2 -8 -10z" />
                            </g>
                        </svg>
                        <span>5</span>
                    </div>
                </div>
            </div>
            <div class="price">0,--€</div>
            <div class="trip-info">
                <div class="col" id="col1">
                    <div class="dep center-item-col">
                        départure
                    </div>
                    <!-- espace -->
                    <div class="point center-item-col">
                        <div class="circle-bg">
                            <div class="circle-upper"></div>
                        </div>
                    </div>
                    <!-- espace -->
                    <div class="hour center-item-col">
                        10h
                    </div>
                </div>
                <div class="col-flex" id="col2">

                    <div class="trait-horizontal"></div>
                </div>
                <div class="col" id="col3">
                    <div class="arr center-item-col">
                        arrivée
                    </div>
                    <div class="point center-item-col">
                        <div class="circle-bg">
                            <div class="circle-upper"></div>
                        </div>
                    </div>
                    <div class="hour center-item-col">
                        10h
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>