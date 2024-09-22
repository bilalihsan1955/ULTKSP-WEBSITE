<?= $this->extend('layout/auth/header'); ?>

<?= $this->section('content'); ?>

<body class="bg-gradient-purple" style="padding-top: 2em; padding-bottom: 2em; font-family: Poppins, sans-serif;">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-flex justify-content-center align-items-center text-center">
                                <div class="m-5">
                                    <img src="<?= base_url('assets/images/logo vokasi UB vertikal-01.png') ?>" alt="Logo Universitas Brawijaya" style="max-width: 100%;">
                                </div>
                            </div>
                            <div class=" col-lg-6">
                                <div class="p-5">
                                    <?php if (session()->getFlashdata('success')) : ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                                            <symbol id="check-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                            </symbol>
                                        </svg>
                                        <div id="autoCloseAlert" class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                                            <svg class="bi flex-shrink-0 me-1" role="img" aria-label="Success:" width="20" height="20">
                                                <use xlink:href="#check-circle-fill" />
                                            </svg>
                                            <div class="mx-2">
                                                <?= session()->getFlashdata('success') ?>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>
    
                                    <?php if (session()->getFlashdata('errors')) : ?>
                                        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                        </symbol>
                                        <div id="autoCloseAlert" class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                                            <svg class="bi flex-shrink-0 me-1" role="img" aria-label="Danger:" width="20" height="20">
                                                <use xlink:href="#check-circle-fill" />
                                            </svg>
                                            <div class="mx-2">
                                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                                    <li><?= esc($error) ?></li>
                                                <?php endforeach; ?>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Let's Get Started!</h1>
                                    </div>
                                    <!-- frorm -->
                                    <form class="user" action="<?= base_url('proses_register_user') ?>" method="post">
                                        <div class="form-group">
                                            <label for="inputname" class="form-label">Name</label>
                                            <input required name="nama" type="text" class="form-control form-control-sm <?php if (session()->getFlashdata('error-name')) : ?>border-danger<?php endif; ?>" id="exampleInputname" aria-describedby="nameHelp" placeholder="Your Name" onclick="removeErrorname()">
                                            <?php if (session()->getFlashdata('error-name')) : ?><label for="inputPassword5" id="error-label-name" class="form-label text-danger"><?= session()->getFlashdata('error-name') ?></label><?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword5" class="form-label">Username</label>
                                            <input required name="username" type="text" class="form-control form-control-sm" id="exampleInputusername" aria-describedby="usernameHelp" placeholder="Your Username">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword5" class="form-label ">Email</label>
                                            <input required name="email" type="email" class="form-control form-control-sm <?php if (session()->getFlashdata('error-mail')) : ?>border-danger<?php endif; ?>" id="exampleInputemail" placeholder="Example@student.ub.ac.id" onclick="removeError()">
                                            <?php if (session()->getFlashdata('error-mail')) : ?><label for="inputPassword5" id="error-label" class="form-label text-danger"> <?= session()->getFlashdata('error-mail') ?></label><?php endif; ?>
                                        </div>
                                        <div onclick="removeErrorPass()">
                                            <div class="form-group">
                                                <label for="inputPassword5" class="form-label">Password</label>
                                                <input required name="password" type="password" class="form-control form-control-sm <?php if (session()->getFlashdata('error-pass')) : ?>border-danger<?php endif; ?>" id="exampleInputPassword" placeholder="Your Password" oninput="checkPasswordRules()" onclick="removeErrorPass()">
                                            </div>
                                            <div class="form-group" onclick="removeErrorPass()">
                                                <label for="inputPassword5" class="form-label">Confirm Password</label>
                                                <input required name="confirm_password" type="password" class="form-control form-control-sm <?php if (session()->getFlashdata('error-pass')) : ?>border-danger<?php endif; ?>" id="Inputconfirm_password" placeholder="Repeat Your Password" oninput="removeErrorPass()" onclick="removeErrorPass()">
                                                <?php if (session()->getFlashdata('error-pass')) : ?><label for="inputPassword5" id="error-label-pass" class="form-label text-danger"> <?= session()->getFlashdata('error-pass') ?></label><?php endif; ?>
                                            </div>
                                        </div>
                                        <p id="password-rules" style="color: red; font-size: 0.8em;">
                                            Password rules:
                                        </p>
                                          <ul id="password-rules-list" style="color: red; font-size: 0.8em;">
                                            <li id="rule-required">Password is required.</li>
                                            <li id="rule-min-length">Minimum length: 8 characters.</li>
                                            <li id="rule-contain-header">Password must contain:
                                              <ul id="rule-contain-list" style="color: red; font-size: 0.8em;">
                                                <li id="rule-uppercase">At least one uppercase letter (A-Z).</li>
                                                <li id="rule-digit">At least one digit (0-9).</li>
                                                <li id="rule-special-char">At least one special character (!, @, #, $, etc.).</li>
                                              </ul>
                                            </li>
                                          </ul>
                                        <div class="mb-3">
                                            <button tyoe="submit" class="btn btn-primary btn-sm btn-block">
                                                Sign Up
                                            </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <span>
                                            Have An Account? <a class="small" href="<?= base_url('/SignIn') ?>">Sign In</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <script>
        const passwordInput = document.getElementById('exampleInputPassword');
        const passwordRulesList = document.getElementById('password-rules-list');
        const rules = [{
                id: 'rule-required',
                condition: () => passwordInput.value.length > 0
            },
            {
                id: 'rule-min-length',
                condition: () => passwordInput.value.length >= 8
            },
            {
                id: 'rule-uppercase',
                condition: () => /[A-Z]/.test(passwordInput.value)
            },
            {
                id: 'rule-digit',
                condition: () => /\d/.test(passwordInput.value)
            },
            {
                id: 'rule-special-char',
                condition: () => /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(passwordInput.value)
            }
        ];

        function checkPasswordRules() {
            let allRulesMet = true;
            rules.forEach(rule => {
                if (!rule.condition()) {
                    allRulesMet = false;
                } else {
                    document.getElementById(rule.id).style.display = 'none';
                }
            });
            if (allRulesMet) {
                document.getElementById('rule-contain-header').style.display = 'none';
                document.getElementById('password-rules').style.display = 'none';
            }
        }
    </script>
    <?= $this->endsection(); ?>