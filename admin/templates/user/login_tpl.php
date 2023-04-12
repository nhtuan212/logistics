<div class="login-view-website text-sm"><a href="../" target="_blank" title="Xem website"><i class="fas fa-reply mr-2"></i>Xem website</a></div>

<div class="login-box">
    <form class="form-login" method="post" action="index.php?com=user&act=login">
        <section class="loginBox">
            <header class="mb-3 text-center">
                <label class="d-block">Đăng nhập hệ thống</label>
            </header>
            <section class="loginFrm">
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <input type="text" class="form-control text-sm username" name="username" placeholder="Tên đăng nhập *">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <input type="password" class="form-control text-sm password" name="password" placeholder="Mật khẩu *">
                    <div class="input-group-append" style="margin-left: -1px;margin-right: 0">
                        <div class="input-group-text bg-light show-password">
                            <span class="far fa-eye"></span>
                        </div>
                    </div>
                </div>
                <div id="loginError" class="font-weight-bold text-danger mb-2"></div>
            </section>
            <button class="btn btn-danger loginBtn">
                <i class="fas fa-chart-line mr-2"></i>
                Vào hệ thống
            </button>
        </section>
    </form>
</div>

<div class="login-copyright text-sm">Powered by <a href="//nina.vn" target="_blank" title="Thiết Kế Website Nina">Thiết Kế Website Nina</a></div>