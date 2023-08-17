<style>
    .banner-section {
        padding: 174px 0 100px 0;
        background-image: url({{getFile(config('location.logo.path').'banner.jpg')}});
        background-position: center;
        background-size: cover;
    }
</style>
@if(!in_array(Request::route()->getName(),['home','category','tournament','match','login','register','register.sponsor','user.check','password.request']))
    <section class="banner-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-text text-center">
                        <h3>@yield('title')</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
