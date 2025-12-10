<!-- First Name -->
@include('auth.partials.text-input', [
    'name' => 'first_name',
    'label' => 'First Name',
    'type' => 'text',
    'placeholder' => 'John',
    'required' => true,
    'autofocus' => true,
])

<!-- Last Name -->
@include('auth.partials.text-input', [
    'name' => 'last_name',
    'label' => 'Last Name',
    'type' => 'text',
    'placeholder' => 'Doe',
    'required' => true,
])

<!-- Email -->
@include('auth.partials.text-input', [
    'name' => 'email',
    'label' => 'Email Address',
    'type' => 'email',
    'placeholder' => 'you@example.com',
    'required' => true,
])

<!-- Password -->
@include('auth.partials.password-input', [
    'name' => 'password',
    'label' => 'Password',
    'placeholder' => 'Enter your password',
    'required' => true,
    'showPasswordVar' => 'showPassword',
])

<!-- Password Confirmation -->
@include('auth.partials.password-input', [
    'name' => 'password_confirmation',
    'label' => 'Confirm Password',
    'placeholder' => 'Confirm your password',
    'required' => true,
    'showPasswordVar' => 'showPasswordConfirmation',
])

