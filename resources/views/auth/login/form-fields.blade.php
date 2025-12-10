<!-- Email -->
@include('auth.partials.text-input', [
    'name' => 'email',
    'label' => 'Email Address',
    'type' => 'email',
    'placeholder' => 'you@example.com',
    'required' => true,
    'autofocus' => true,
])

<!-- Password -->
@include('auth.partials.password-input', [
    'name' => 'password',
    'label' => 'Password',
    'placeholder' => 'Enter your password',
    'required' => true,
    'showPasswordVar' => 'showPassword',
])

<!-- Remember Me -->
@include('auth.partials.remember-me')

