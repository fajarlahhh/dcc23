<div>

    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin #header -->
        <div id="header" class="header navbar navbar-transparent navbar-fixed-top navbar-expand-lg">
            <!-- begin container -->
            <div class="container">
                <!-- begin navbar-brand -->
                <a href="index.html" class="navbar-brand">
                    <img src="/dist/images/logo.png" alt="">
                </a>
                <!-- end navbar-brand -->
                <!-- begin navbar-toggle -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#header-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- end navbar-header -->
                <!-- begin navbar-collapse -->
                <div class="collapse navbar-collapse" id="header-navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item"><a class="nav-link" href="#home" data-click="scroll-to-target">HOME</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#about" data-click="scroll-to-target">ABOUT</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#service" data-click="scroll-to-target">BUSINESS
                                PLAN</a></li>
                        <li class="nav-item"><a class="nav-link" href="#pricing"
                                data-click="scroll-to-target">PACKAGE</a></li>
                    </ul>
                </div>
                <!-- end navbar-collapse -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #header -->

        <!-- begin #home -->
        <div id="home" class="content has-bg home">
            <!-- begin content-bg -->
            <div class="content-bg" style="background-image: url(/frontend/assets/img/bg/bg-home.jpg);"
                data-paroller="true" data-paroller-factor="0.5" data-paroller-factor-xs="0.25">
            </div>
            <!-- end content-bg -->
            <!-- begin container -->
            <div class="container home-content">
                <h1>Welcome to DCC23</h1>
                <h3>Digital Cattle Center</h3>
                <p>
                    We use USDT BEP20 for every transaction. Let's join and livestock usdt with us. good luck and
                    move
                    forward with us
                </p>
                <a href="/login" class="btn btn-theme btn-primary">Sign In</a>
                <a href="/registration/{{ $sponsor }}/{{ $team }}"
                    class="btn btn-theme btn-outline-white">Sign Up Now</a><br />
                <br />
                Join our telegram <a href="https://t.me/+EsITMCltRzVkMjc1">here</a>.
            </div>
            <!-- end container -->
        </div>
        <!-- end #home -->

        <!-- begin #about -->
        <div id="about" class="content" data-scrollview="true">
            <!-- begin container -->
            <div class="container" data-animation="true" data-animation-type="fadeInDown">
                <h2 class="content-title">About Us</h2>
                <p class="content-desc">
                    Hy, we are dcc23. Let's join with us
                </p>
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-4 -->
                    <div class="col-md-8 col-sm-12">
                        <!-- begin about -->
                        <div class="about">
                            <h3 class="mb-3">Our Story</h3>
                            <p>
                                Departing from the philosophy of a place to eat, we build a system that helps you
                                develop an usdt like a place to eat philosophy. We` exist to help members manage
                                cryptocurrency, especially USDT BEP 20 so that it can be useful in the future
                            </p>
                            <p>
                                Yes, here we are. let's join us and create a bright future together.
                            </p>
                        </div>
                        <!-- end about -->
                    </div>
                    <!-- end col-4 -->
                    <!-- begin col-4 -->
                    <div class="col-md-4 col-sm-12">
                        <h3 class="mb-3">Our Philosophy</h3>
                        <!-- begin about-author -->
                        <div class="about-author">
                            <div class="quote">
                                <i class="fa fa-quote-left"></i>
                                <h3>Crypto <br /><span>was made to grow</span></h3>
                                <i class="fa fa-quote-right"></i>
                            </div>
                            <div class="author">
                                <div class="image">
                                    <img src="/frontend/assets/img/user/user-1.jpg" alt="Sean Ngu" />
                                </div>
                                <div class="info">
                                    <small>Founder</small>
                                </div>
                            </div>
                        </div>
                        <!-- end about-author -->
                    </div>
                    <!-- end col-4 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #about -->

        <!-- begin #milestone -->
        <div id="milestone" class="content bg-black-darker has-bg" data-scrollview="true">
            <!-- begin content-bg -->
            <div class="content-bg" style="background-image: url(/frontend/assets/img/bg/bg-milestone.jpg)"
                data-paroller="true" data-paroller-factor="0.5" data-paroller-factor-md="0.01"
                data-paroller-factor-xs="0.01"></div>
            <!-- end content-bg -->
            <!-- begin container -->
            <div class="container">
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-3 -->
                    <div class="col-md-3 milestone-col">
                        &nbsp;
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 milestone-col">
                        <div class="milestone">
                            <div class="number" data-animation="true" data-animation-type="number"
                                data-final-number="{{ \App\Models\User::whereNotNull('activated_at')->count() }}">
                                {{ \App\Models\User::whereNotNull('activated_at')->count() }}</div>
                            <div class="title">Active Members</div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 milestone-col">
                        <div class="milestone">
                            <div class="number" data-animation="true" data-animation-type="number"
                                data-final-number="9039">
                                {{ \App\Models\Withdrawal::whereNotNull('processed_at')->sum('amount') }}</div>
                            <div class="title">Total Withdrawal (in USDT)</div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 milestone-col">
                        &nbsp;
                    </div>
                    <!-- end col-3 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #milestone -->

        <!-- beign #service -->
        <div id="service" class="content" data-scrollview="true">
            <!-- begin container -->
            <div class="container">
                <h2 class="content-title">Business Plan</h2>
                <p class="content-desc">
                    Along the way we implemented a business plan.<br>
                    Enjoy it.
                </p>
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-4 -->
                    <div class="col-md-4 col-sm-12">
                        <div class="service">
                            <div class="icon" data-animation="true" data-animation-type="bounceIn"><i
                                    class="fa fa-star"></i></div>
                            <div class="info">
                                <h4 class="title">250 % Contract</h4>
                                <p class="desc">We give you a benefit of 250% of the package taken
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- end col-4 -->
                    <!-- begin col-4 -->
                    <div class="col-md-4 col-sm-12">
                        <div class="service">
                            <div class="icon" data-animation="true" data-animation-type="bounceIn"><i
                                    class="fa fa-paint-brush"></i></div>
                            <div class="info">
                                <h4 class="title">Daily Profit</h4>
                                <p class="desc">1% Up To Unlimited (Fluctuative)</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col-4 -->
                    <!-- begin col-4 -->
                    <div class="col-md-4 col-sm-12">
                        <div class="service">
                            <div class="icon" data-animation="true" data-animation-type="bounceIn"><i
                                    class="fa fa-file"></i></div>
                            <div class="info">
                                <h4 class="title">Recurring active reception</h4>
                                <ul>
                                    <li>Sponsor bonus 10%</li>
                                    <li>Pairing bonus 10%</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- end col-4 -->
                </div>
                <!-- end row -->
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-4 -->
                    <div class="col-md-4 col-sm-12">
                        <div class="service">
                            <div class="icon" data-animation="true" data-animation-type="bounceIn"><i
                                    class="fa fa-code"></i></div>
                            <div class="info">
                                <h4 class="title">Withdrawal</h4>
                                <ul>
                                    <li>Available on weekdays</li>
                                    <li>Min. 15 USDT</li>
                                    <li>Max. 50% of package</li>
                                    <li>Admin Fee 2 USDT</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- end col-4 -->
                    <!-- begin col-4 -->
                    <div class="col-md-4 col-sm-12">
                        <div class="service">
                            <div class="icon" data-animation="true" data-animation-type="bounceIn"><i
                                    class="fa fa-shopping-cart"></i></div>
                            <div class="info">
                                <h4 class="title">Reinvest</h4>
                                <p class="desc">Deduct 50% of the total bonus</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col-4 -->
                    <!-- begin col-4 -->
                    <div class="col-md-4 col-sm-12">
                        <div class="service">
                            <div class="icon" data-animation="true" data-animation-type="bounceIn"><i
                                    class="fa fa-gift"></i></div>
                            <div class="info">
                                <h4 class="title">Reward</h4>
                                <ul>
                                    <li>Sponsored 1 : 1 (Left and Right)</li>
                                    <li>Accumulated turnover of small legs
                                        <ul>
                                            <li>@ 10.000 = 200 usdt</li>
                                            <li>@50.000 = 1000 usdt</li>
                                            <li>@ 100.000 = 2000 usdt</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- end col-4 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #about -->

        <!-- beign #action-box -->
        <div id="action-box" class="content has-bg" data-scrollview="true">
            <!-- begin content-bg -->
            <div class="content-bg" style="background-image: url(/frontend/assets/img/bg/bg-action.jpg)"
                data-paroller-factor="0.5" data-paroller-factor-md="0.01" data-paroller-factor-xs="0.01">
            </div>
            <!-- end content-bg -->
        </div>
        <!-- end #action-box -->

        <!-- begin #pricing -->
        <div id="pricing" class="content text-center" data-scrollview="true">
            <!-- begin container -->
            <h2 class="content-title">Our Package</h2>
            <!-- begin pricing-table -->
            <div
                style="padding-right:55px;
            padding-left: 55px;
            margin-right: auto;
            margin-left: auto;">
                <ul class="pricing-table pricing-col-1">
                    @foreach (\App\Models\Package::all() as $row)
                        <li data-animation="true" data-animation-type="fadeInUp">
                            <div class="pricing-container">
                                <h3>{{ $row->name }}</h3>
                                <div class="price">
                                    <div class="price-figure">
                                        <span class="price-number">{{ number_format($row->value) }}</span>
                                    </div>
                                </div>
                                <ul class="features">
                                    <li>Contract {{ number_format($row->benefit) }}</li>
                                    <li>Max WD {{ number_format($row->maximum_withdrawal) }}</li>
                                    <li>Sponsorship {{ number_format($row->sponsorship_benefits) }}</li>
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <br>
            <a href="/registration/{{ $sponsor }}/{{ $team }}" class="btn btn-success"
                data-animation="true" data-animation-type="fadeInUp">Sign Up Now</a>
            <!-- end container -->
        </div>
        <!-- end #pricing -->

        <!-- begin #footer -->
        <div id="footer" class="footer">
            <div class="container">
                <div class="footer-brand">
                    <img src="/dist/images/logo.png" alt="" style="width: 60px"><br>
                    Color Admin
                </div>
                <p>
                    &copy; 2023 <br />
                    Digital Cattle Center
                </p>
                <p class="social-list">
                    <a href="https://t.me/+EsITMCltRzVkMjc1"><i class="fab fa-telegram fa-fw"></i></a>
                </p>
            </div>
        </div>
        <!-- end #footer -->

    </div>
    <!-- end #page-container -->
</div>
