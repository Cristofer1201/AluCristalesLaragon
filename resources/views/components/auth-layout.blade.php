<!doctype html>
<html lang="es">

<head>
	<title>{{ $title ?? 'AluCristales' }} - AluCristales Palermo</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Inter Font - Professional Typography -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

	<!-- Font Awesome 6 -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

	<!-- Base Styles -->
	<link rel="stylesheet" href="{{ asset('css/loginStyle.css') }}">

	<style>
		:root {
			--alu-primary: #dc2626;
			--alu-primary-hover: #b91c1c;
			--alu-primary-light: #fef2f2;
			--alu-gray-50: #f9fafb;
			--alu-gray-100: #f3f4f6;
			--alu-gray-600: #4b5563;
			--alu-gray-800: #1f2937;
			--alu-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
		}

		body {
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
			-webkit-font-smoothing: antialiased;
		}

		.auth-card {
			background: rgba(255, 255, 255, 0.98);
			border-radius: 1rem;
			box-shadow: var(--alu-shadow);
			backdrop-filter: blur(10px);
			padding: 2.5rem;
		}

		.auth-title {
			font-weight: 700;
			color: var(--alu-gray-800);
			margin-bottom: 0.5rem;
		}

		.auth-subtitle {
			color: var(--alu-gray-600);
			font-size: 0.875rem;
		}

		.form-control,
		.auth-card .form-control,
		.signin-form .form-control {
			border: 1px solid #e5e7eb !important;
			border-radius: 0.5rem !important;
			padding: 0.75rem 1rem !important;
			font-size: 0.9375rem !important;
			transition: all 0.15s ease !important;
			background-color: #ffffff !important;
			color: #1f2937 !important;
		}

		.form-control::placeholder,
		.auth-card .form-control::placeholder,
		.signin-form .form-control::placeholder {
			color: #9ca3af !important;
		}

		.form-control:focus,
		.auth-card .form-control:focus,
		.signin-form .form-control:focus {
			border-color: var(--alu-primary) !important;
			box-shadow: 0 0 0 3px var(--alu-primary-light) !important;
			outline: none !important;
			background-color: #ffffff !important;
			color: #1f2937 !important;
		}

		.form-label {
			font-weight: 500;
			color: var(--alu-gray-800);
			font-size: 0.875rem;
			margin-bottom: 0.5rem;
		}

		.btn-primary {
			background: linear-gradient(135deg, var(--alu-primary) 0%, var(--alu-primary-hover) 100%);
			border: none;
			border-radius: 0.5rem;
			padding: 0.75rem 1.5rem;
			font-weight: 600;
			font-size: 0.9375rem;
			transition: all 0.2s ease;
		}

		.btn-primary:hover {
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
			background: linear-gradient(135deg, var(--alu-primary-hover) 0%, #991b1b 100%);
		}

		.btn-primary:active {
			transform: translateY(0);
		}

		.alert {
			border-radius: 0.5rem;
			border: none;
			padding: 1rem;
		}

		.alert-danger {
			background: var(--alu-primary-light);
			color: var(--alu-primary);
		}

		.password-toggle {
			position: absolute;
			right: 1rem;
			top: 50%;
			transform: translateY(-50%);
			color: var(--alu-gray-600);
			cursor: pointer;
			transition: color 0.15s ease;
		}

		.password-toggle:hover {
			color: var(--alu-primary);
		}

		.link-muted {
			color: var(--alu-gray-600);
			text-decoration: none;
			font-size: 0.875rem;
			transition: color 0.15s ease;
		}

		.link-muted:hover {
			color: var(--alu-primary);
		}

		.brand-logo {
			width: 120px;
			height: auto;
			margin-bottom: 1rem;
		}

		.overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: linear-gradient(135deg, rgba(17, 24, 39, 0.8) 0%, rgba(31, 41, 55, 0.9) 100%);
			z-index: -1;
		}
	</style>
</head>

<body class="img js-fullheight" style="background-image: url({{asset('img/bg.jpg')}}); height: 100%; background-size: cover; background-position: center;">
	<div class="overlay"></div>

	<section class="ftco-section" style="padding-top: 3rem; padding-bottom: 3rem;">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-5 col-lg-4">

					<!-- Auth Card -->
					<div class="auth-card">

						<!-- Brand Section -->
						<div class="text-center mb-4">
							<img src="{{ asset('img/Logo Alucristales.png') }}"
								 alt="Alucristales Palermo"
								 class="brand-logo">
							<h1 class="auth-title h4">{{ $title ?? 'Bienvenido' }}</h1>
							<p class="auth-subtitle">AluCristales Palermo</p>
						</div>

						<!-- Error Messages -->
						@if ($errors->any())
							<div class="alert alert-danger mb-4" role="alert">
								<div class="d-flex align-items-start">
									<i class="fa-solid fa-circle-exclamation mt-1 mr-2"></i>
									<div>
										@foreach ($errors->all() as $error)
											<div>{{ $error }}</div>
										@endforeach
									</div>
								</div>
							</div>
						@endif

						@if (session('status'))
							<div class="alert alert-success mb-4" role="alert">
								<div class="d-flex align-items-start">
									<i class="fa-solid fa-check-circle mt-1 mr-2"></i>
									<div>{{ session('status') }}</div>
								</div>
							</div>
						@endif

						<!-- Form Slot -->
						{{$slot}}

					</div>

					<!-- Footer -->
					<div class="text-center mt-4">
						<p class="text-white-50 small mb-0">
							&copy; {{ date('Y') }} AluCristales Palermo. Todos los derechos reservados.
						</p>
					</div>

				</div>
			</div>
		</div>
	</section>

	<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('js/popper.js')}}"></script>
	<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('js/main.js')}}"></script>
</body>

</html>
