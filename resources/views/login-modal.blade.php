<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-body p-4">

                <h5 class="text-center fw-bold mb-4" style="color:#1b2a41;">
                    Masuk ke Akun
                </h5>

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <input type="email" name="email"
                               class="form-control rounded-3"
                               placeholder="Email" required>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="password" name="password" id="loginPass"
                               class="form-control rounded-3"
                               placeholder="Password" required>
                        <i class="bi bi-eye position-absolute"
                           style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer;"
                           onclick="togglePassword('loginPass', this)"></i>
                    </div>

                    <button class="btn w-100 rounded-pill text-white mb-3"
                            style="background:#1b2a41;">
                        Masuk
                    </button>

                    <div class="text-center my-3 position-relative">
                        <hr>
                        <span class="position-absolute top-50 start-50 translate-middle px-2 bg-white text-muted small">
                            atau
                        </span>
                    </div>

                    <div class="text-center my-3">
                        <div class="d-flex justify-content-center gap-3">

                            <a href="{{ url('/auth/google') }}"
                               class="rounded-circle border d-flex align-items-center justify-content-center"
                               style="width:45px; height:45px;">
                                <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png" width="20">
                            </a>

                            <a href="{{ url('/auth/facebook') }}"
                               class="rounded-circle d-flex align-items-center justify-content-center text-white"
                               style="width:45px; height:45px; background:#1877f2;">
                                <i class="bi bi-facebook"></i>
                            </a>

                        </div>
                    </div>

                    <p class="text-center small mt-3">
                        Belum punya akun?
                        <a href="#" data-bs-toggle="modal"
                           data-bs-target="#registerModal"
                           data-bs-dismiss="modal"
                           style="color:#1b2a41;">
                            Daftar
                        </a>
                    </p>

                </form>

            </div>
        </div>
    </div>
</div>