<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-body p-4">

                <h5 class="text-center fw-bold mb-4" style="color:#1b2a41;">
                    Daftar Akun
                </h5>

                <form method="POST" action="/register">
                    @csrf

                    <div class="mb-3">
                        <input type="text" name="name"
                               class="form-control rounded-3"
                               placeholder="Nama">
                    </div>

                    <div class="mb-3">
                        <input type="email" name="email"
                               class="form-control rounded-3"
                               placeholder="Email">
                    </div>

                    <div class="mb-3">
                        <input type="text" name="phone"
                               class="form-control rounded-3"
                               placeholder="No HP">
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="password" name="password" id="regPass"
                               class="form-control rounded-3"
                               placeholder="Password">
                        <i class="bi bi-eye position-absolute"
                           style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer;"
                           onclick="togglePassword('regPass', this)"></i>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="password" name="password_confirmation" id="regPass2"
                               class="form-control rounded-3"
                               placeholder="Konfirmasi Password">
                        <i class="bi bi-eye position-absolute"
                           onclick="togglePassword('regPass2', this)"
                           style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
                    </div>

                    <button class="btn w-100 rounded-pill text-white mb-3"
                            style="background:#1b2a41;">
                        Daftar
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
                        Sudah punya akun?
                        <a href="#" data-bs-toggle="modal"
                           data-bs-target="#loginModal"
                           data-bs-dismiss="modal"
                           style="color:#1b2a41;">
                            Masuk
                        </a>
                    </p>

                </form>
            </div>
        </div>
    </div>
</div>