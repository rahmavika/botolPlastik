<div class="modal fade" id="detailPelangganModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 overflow-hidden">
            <div class="modal-header">
                <h5 class="modal-title">Profil Saya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-4 bg-light d-flex flex-column align-items-center justify-content-center p-4">
                        <i class="bi bi-person-circle mb-3" style="font-size: 80px; color: #1e3f66;"></i>
                        <h5 class="fw-bold">{{ session('name') }}</h5>
                        <button class="btn mt-2"
                                style="background:#075080; color:white; border-radius:50px;"
                                data-bs-toggle="modal"
                                data-bs-target="#editProfileModal">
                            <i class="bi bi-pencil"></i> Edit Profil
                        </button>
                    </div>
                    <div class="col-md-8 p-4">
                        <h5 class="fw-bold mb-3" style="color:#1e3f66;">Informasi Akun</h5>
                        <div class="mb-3">
                            <small class="text-muted">Username</small>
                            <p>{{ session('name') }}</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted">Email</small>
                            <p>{{ session('email') }}</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted">No HP</small>
                            <p>{{ session('phone') }}</p>
                        </div>
                        <hr>
                        <form action="/logout" method="POST">
                            @csrf
                            <button class="btn btn-danger w-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>