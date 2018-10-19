<footer data-background="{{ Theme::asset()->url('images/page-intro-01.png') }}" class="page-footer bg-dark pt-50 bg-parallax">
    <div class="bg-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <aside class="widget widget--transparent widget__footer widget__about">
                    <div class="widget__content">
                        <header class="person-info">
                            <div class="person-info__thumbnail"><a href="https://botble.com"><img src="{{ url(theme_option('logo')) }}" alt="{{ setting('site_title') }}"></a></div>
                            <div class="person-info__content">
                                <h3 class="person-info__title">{{ __('BỆNH VIỆN ĐA KHOA HÒA BÌNH') }}</h3>
                                <p class="person-info__description"></p>
                            </div>
                        </header>
                        <div class="person-detail">
                            <p><i class="ion-home"></i>{{ __('Phố Phạm Xuân Huân, Khu đô thị mới phía Đông, P.Hải Tân, TP.Hải Dương.') }}</p>
                            <p><i class="ion-earth"></i><a href="/">https://benhvienhoabinh.vn</a></p>
                            <p><i class="ion-android-call"></i><a href="tel:02202470424">02202.470.424</a> - <a href="tel:02203553115">02203.553.115</a></p>
                            <p><i class="ion-email"></i><a href="mailto:{{ setting('admin_email') }}">{{ setting('admin_email') }}</a></p>
                        </div>
                    </div>
                </aside>
            </div>
            {!! dynamic_sidebar('footer_sidebar') !!}
        </div>
    </div>
    <div class="page-footer__bottom">
        <div class="container">
            <div class="row">
                {!! __(theme_option('banquyen')) !!}
                <!-- <div class="col-md-8 col-sm-6 col-xs-12">
                    <div class="page-copyright">
                        <p>{!! __(theme_option('banquyen')) !!}</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="page-footer__social">
                        <ul class="social social--simple">
                            <li><a href="{{ setting('facebook') }}" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{ setting('twitter') }}" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{ setting('google_plus') }}" title="Google"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</footer>
<div id="back2top"><i class="fa fa-angle-up"></i></div>
</div>

<!-- JS Library-->
{!! Theme::footer() !!}

@if (session()->has('success_msg'))
    <script type="text/javascript">
        swal('{{ __('Success') }}', "{{ session('success_msg', '') }}", 'success');
    </script>
@endif

@if (session()->has('error_msg'))
    <script type="text/javascript">
        swal('{{ __('Success') }}', "{{ session('error_msg', '') }}", 'error');
    </script>
@endif

<script>
    'use strict';
    window.fbAsyncInit = function() {
        FB.init({
            appId            : '1752152358341085',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v2.11'
        });
    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<div class="fb-customerchat" page_id="157007981299897" minimized="0"></div>

</body>
</html>
