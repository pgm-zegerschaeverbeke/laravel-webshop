export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['DM Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        serif: ['Playfair Display', 'serif'],
      },
      colors: {
        primary: '#433c35',
        textSecondary: '#fff7e9',
        background: '#e8e0d2',
        accent: '#8c4630',
        border: '#c3af9f',
        accentDark: '#7f3e2c',  
        subtle: '#c3af9f',
        card: '#ffffff',
      },
    },
  },
  plugins: [],
}
