<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('template/ogani-master/css/bootstrap.min.css'); }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('template/ogani-master/css/font-awesome.min.css'); }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('template/ogani-master/css/elegant-icons.css'); }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('template/ogani-master/css/nice-select.css'); }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('template/ogani-master/css/jquery-ui.min.css'); }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('template/ogani-master/css/owl.carousel.min.css'); }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('template/ogani-master/css/slicknav.min.css'); }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('template/ogani-master/css/style.css'); }}" type="text/css">

    {{-- jquery cdn --}}
    <script  src="http://code.jquery.com/jquery-latest.min.js"></script>
    <style>
        .hero__categories__all {
            padding: 10px 20px 10px 20px;
            width: 80px;
        }
        .hero__categories__all, .site-btn{
            background: red;
        }
        .search_btn {
            right: auto !important; 
            width : 110px;
        }

        .section-title h4:after
        {
            position: absolute;
            left: 0;
            bottom: 30px;
            right: 0;
            height: 4px;
            width: 80px;
            background: red;
            content: "";
            margin: 0 auto;
        }
        .fa-won:before {
            color : red;
        }
        .categories__slider.owl-carousel .owl-nav button, .latest-product__slider.owl-carousel .owl-nav button {
            border:none;
            background: white;
        }
        .latest-product__slider.owl-carousel.owl-loaded.owl-drag .owl-nav .owl-prev {
            display: none;
        }

        .sel_li {
            padding : 10px 17px;
        }
        .sel_li:hover {
            background : rgb(238, 238, 238);
        }

        .arrow_carrot-up:before {
            content: "\32";
        }

        .hero__search__form form input {
            width: 54%;
        }

        .h_cate, .h_cate_de, .h_cate_de_de {
            padding : 8px;
            padding-left : 25px;
            cursor: pointer;
            width: 249px;
            border: none;
            text-align: left;
            background:#fff;
        }

        .h_cate:hover, .h_cate_de:hover, .h_cate_de_de:hover {
            background :rgb(243, 243, 243);
        }

        .hero__categories ul {
            padding-left: 0px;
        }

        .h_selected, .h_selected:hover {
            background :rgb(255, 162, 56);
            color : rgb(255, 255, 255);
        }

        #h_category, #h_category_de, #h_category_de_de {
            position:absolute; 
            background : #fff; 
            width : 250px;  
            list-style-type: none;
            border: 1px solid #ebebeb;    
            padding-top: 10px;
            padding-bottom: 12px;
            height: 600px;
            overflow-y:auto; 
            overflow-x:hidden; 
            z-index: 5; 
        }
        #h_category {
            display: none;
        }

        #h_category_de {
            margin-left: 249px;
        }

        #h_category_de_de {
            margin-left: 498px; 
        }

        .hero__categories__all:after {
            display: none;
        }
        .hero__categories__all {
            width: 55px;
        }

        #sel_ul {
            position:absolute; 
            z-index: 2; 
            background : #fff; 
            width: 21%; 
            left: 15px; 
            display : none; 
            top : 49px; 
            list-style-type: none; 
            border : 1px solid rgb(231, 231, 231);
            cursor: pointer;
        }

        .header__logo {
            padding:0px 0px;
        }

        .hero__search__form {
            position: inherit;
        }

        .my_sear_g_a {
            cursor : pointer;
            height: 48px;
        }
        #selected_search_type {
            right: 116px;
        }

        .hero__search__phone__icon {
            margin-right : 8px;
        }
        .hero__search__phone__text {
            padding-top : 15px;
        }
        #footer_site_info {
            width : 300px;
        }

        .type_selected {
            color :rgb(255, 150, 29);
        }
    </style>
</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="{{ asset('template/ogani-master/img/logo.png'); }}" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__language">
                <img src="{{ asset('template/ogani-master/img/language.png'); }}" alt="">
                <div>English</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <li><a href="#">Spanis</a></li>
                    <li><a href="#">English</a></li>
                </ul>
            </div>
            <div class="header__top__right__auth">
                <a href="#"><i class="fa fa-user"></i> Login</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="./index.html">Home</a></li>
                <li><a href="./shop-grid.html">Shop</a></li>
                <li><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="./shop-details.html">Shop Details</a></li>
                        <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                        <li><a href="./checkout.html">Check Out</a></li>
                        <li><a href="./blog-details.html">Blog Details</a></li>
                    </ul>
                </li>
                <li><a href="./blog.html">Blog</a></li>
                <li><a href="./contact.html">Contact</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Free Shipping for all Order of $99</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            
                            <div class="header__top__right__language">
                                <div>내 상점</div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="#">내 상품</a></li>
                                    <li><a href="#">찜한 상품</a></li>
                                    <li><a href="#">계정 설정</a></li>
                                    <li><a href="#">고객센터</a></li>
                                </ul>
                            </div>
                            <div class="header__top__right__auth">
                                <a href="#"><i class="fa fa-user"></i> Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
    <br><br>
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-1">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span></span>
                        </div>
                    </div>
                    <div id="category_layer">
                        <div id="h_category_area">
                            <ul id="h_category">
                                @if (isset($categorys))
                                    @foreach ($categorys as $category)
                                        <li><button class="h_cate" value="{{ $category->id }}">{{ $category->name }}</button></li>
                                    @endforeach
                                @endif
                            </ul>
                            <input type="hidden" name="h_category_id" id="h_category_id" value="0" />
                        </div>
                        <div id="h_category_de_area">
                        </div>
                        <input type="hidden" name="h_category_de_id" id="h_category_de_id" value="0" /> 
                        <div id="h_category_de_de_area">
                        </div>
                        <input type="hidden" name="h_category_de_de_id" id="h_category_de_de_id" value="0" />
                    </div>
                </div> 
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="/"><img src="{{ asset('template/ogani-master/img/logo.png'); }}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form"> 
                            <form action="/goods" action="get" name="search_form" onsubmit="return false">
                                <div class="hero__search__categories my_sear_g_a">
                                    <span id="selected_search_type">{{ isset($selected_num) && $selected_num == 1 ? '상점명' : '상품명' }}</span>
                                    <span id="sel_arrow" class="arrow_carrot-down"></span>
                                </div> 
                                <ul id="sel_ul">
                                    <li class="sel_li {{ isset($selected_num) && $selected_num == 1 ? '' : 'type_selected' }}">상품명</li>
                                    <li class="sel_li {{ isset($selected_num) && $selected_num == 1 ? 'type_selected' : '' }}">상점명</li>
                                </ul>
                                <input type="hidden" id="selected_num" name="selected_num" value="{{ isset($selected_num) ? $selected_num : '0' }}" />
                                <input type="text" name="search" placeholder="상품명 입력" id="search_text" value="{{ isset($search) ? $search : '' }}"/>
                                <button type="button" class="site-btn search_btn">검&nbsp;색</button>
                            </form>
                        </div>
                        <a href="/goods/create">
                            <div class="hero__search__phone">
                                <div class="hero__search__phone__icon">
                                    <i class="fa fa-won"></i>
                                </div>
                                <div class="hero__search__phone__text">
                                    <h5>판매하기</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            @yield('big_advertisement')

        </div>
    </section>
    <!-- Hero Section End -->

    @yield('content')
    
    <!-- Latest Product Section End -->

    
    <br><br><br><br><br><br>
    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="./index.html"><img src="{{ asset('template/ogani-master/img/logo.png'); }}" alt=""></a>
                        </div>
                        <ul id="footer_site_info">
                            <li>주소 : 서울특별시 서초구 서초대로38길 12</li>
                            <li>사업자등록번호 : 111-59-45536</li>
                            <li>FAX : 02-598-8241</li>
                            <li>Email : bungae@usedsite.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">
                        <h6>Links</h6>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">공지사항</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Who We Are</a></li>
                            <li><a href="#">Our Services</a></li>
                            <li><a href="#">Projects</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Innovation</a></li>
                            <li><a href="#">Testimonials</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__widget">
                        <h6>고객센터</h6>
                        <p>1670-2910<br>운영시간 9시 - 18시<br>(주말/공휴일 휴무, 점심시간 12시 - 13시)</p>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text"><p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="{{ asset('template/ogani-master/js/jquery-3.3.1.min.js'); }}"></script>
    <script src="{{ asset('template/ogani-master/js/bootstrap.min.js'); }}"></script>
    <script src="{{ asset('template/ogani-master/js/jquery.nice-select.min.js'); }}"></script>
    <script src="{{ asset('template/ogani-master/js/jquery-ui.min.js'); }}"></script>
    <script src="{{ asset('template/ogani-master/js/jquery.slicknav.js'); }}"></script>
    <script src="{{ asset('template/ogani-master/js/mixitup.min.js'); }}"></script>
    <script src="{{ asset('template/ogani-master/js/owl.carousel.min.js'); }}"></script>
    <script src="{{ asset('template/ogani-master/js/main.js'); }}"></script>
    
    <script>
        var category_des = <?php echo json_encode($category_des)?>;
        var category_de_des = <?php echo json_encode($category_de_des)?>;


        $('.sel_li').click (function (e) {
            let target_text = $(e.target).text();
            $('#selected_search_type').text(target_text);
            if (target_text == '상품명')
                $('#search_text').attr("placeholder", "상품명 입력");
            else
                $('#search_text').attr("placeholder", "상점명 입력");
            $('#selected_num').val($('.sel_li').index(this));
            $('#sel_ul').slideToggle(300);
            $('#sel_arrow').removeClass('arrow_carrot-up'); 
            $('#sel_arrow').addClass('arrow_carrot-down'); // 아래화살표

            // 글자 색 변경
            $('.sel_li').removeClass("type_selected");
            $(e.target).addClass("type_selected");
        });

        $('.my_sear_g_a').click (function (e) {
            if($("#sel_ul").css('display') == 'none') { 
                $('#sel_ul').slideToggle(300);
                $('#sel_arrow').removeClass('arrow_carrot-down'); 
                $('#sel_arrow').addClass('arrow_carrot-up'); // 위 화살표
            }
            else {
                $('#sel_ul').slideToggle(300);
                $('#sel_arrow').removeClass('arrow_carrot-up'); 
                $('#sel_arrow').addClass('arrow_carrot-down'); // 아래화살표
            }
        });

        // ksy \ site.js 에사 복사해온 함수
        function text_filter(text) { 
            _text = text.trim(); // 앞 뒤 공백 자르기
            _text = _text.replace(/\s{2,}/gi, ' '); // 두 칸 이상 공백을 한 칸 공백으로 치환
            return _text;
        }

        function check_search_text() {
            let search_text = $('#search_text').val();
            search_text = text_filter(search_text);
            if (search_text == '') {
                alert('검색어를 입력하세요');
                return;
            }
            else {
                document.search_form.submit(); 
            }
        }

        $('#search_text').keyup(function (e) {
            // 엔터키 누르면 실행
            if (e.keyCode == 13 || e.which == 13) {
                check_search_text();
            }
        })

        $('.search_btn').click (function () {
            check_search_text();
        });

        $(".h_cate").hover (function (e){
            
            // 값 변경
            $("#h_category_id").val(e.target.value);
            $('#h_category_de_id').val('0');
            $('#h_category_de_de_id').val('0');

            // 배경 색 변경
            $('.h_cate').removeClass("h_selected");
            $(e.target).addClass("h_selected");

            selCategory(e.target.value);

            $('#h_category_de_de').css('display', 'none');
        });
        $(document).on('mouseover', ".h_cate_de", function(e){
        
            // 값 변경
            $('#h_category_de_id').val(e.target.value);
            $('#h_category_de_de_id').val('0');

            // 배경 색 변경
            $('.h_cate_de').removeClass("h_selected");
            $(e.target).addClass("h_selected");

            selCategoryDe(e.target.value);
        });
        $(document).on('mouseover', ".h_cate_de_de", function(e){
        
            // 값 변경
            $('#h_category_de_de_id').val(e.target.value);

            // 배경 색 변경
            $('.h_cate_de_de').removeClass("h_selected");
            $(e.target).addClass("h_selected");
        });

        function selCategory(category_id) {
            let isNothing = true;

            let str = '<ul id="h_category_de">\n';
            if (category_id != 0 && category_des != '') {

                category_des.forEach((element, index, array) => {
                    if (category_id == element.category_id) {
                        isNothing = false;
                        str += '<li><button class="h_cate_de" value="' + element.id + '">' + element.name  + '</button></li>\n';
                    }
                });
            }
            str += '</ul>\n';
            $("#h_category_de_area").empty();
            $("#h_category_de_de_area").empty();
            if(!isNothing) $("#h_category_de_area").html(str);
        }

        function selCategoryDe(category_de_id) {
            let isNothing = true;

            let str = '<ul id="h_category_de_de">\n';
            if (category_de_id != 0 && category_de_des != '') {

                category_de_des.forEach((element, index, array) => {
                    if (category_de_id == element.category_de_id) {
                        isNothing = false;
                        str += '<li><button class="h_cate_de_de" value="' + element.id + '">' + element.name  + '</button></li>\n';
                    }
                });
            }
            str += '</ul>\n';
            $("#h_category_de_de_area").empty();
            if(!isNothing) $("#h_category_de_de_area").html(str);
        }

        $(".h_cate").click (function (e){
            // 값 변경
            $("#h_category_id").val(e.target.value);
            $('#h_category_de_id').val('0');
            $('#h_category_de_de_id').val('0');

            // 배경 색 변경
            $('.h_cate').removeClass("h_selected");
            $(e.target).addClass("h_selected");

            location.href="/goods?category="+e.target.value;
        });
        $(document).on('click', ".h_cate_de", function(e){
            // 값 변경
            $('#h_category_de_id').val(e.target.value);
            $('#h_category_de_de_id').val('0');

            // 배경 색 변경
            $('.h_cate_de').removeClass("h_selected");
            $(e.target).addClass("h_selected");

            location.href="/goods?category=" + $('#h_category_id').val() + "&category_de=" + e.target.value;
        });
        $(document).on('click', ".h_cate_de_de", function(e){
            // 값 변경
            $('#h_category_de_de_id').val(e.target.value);

            // 배경 색 변경
            $('.h_cate_de_de').removeClass("h_selected");
            $(e.target).addClass("h_selected");

            location.href="/goods?category=" + $('#h_category_id').val() + "&category_de=" + $('#h_category_de_id').val() + "&category_de_de=" + e.target.value;
        });
    </script>
</body>
</html>