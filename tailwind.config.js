/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#990011',
        purpolis : '#925fe2',
        secondary: '#FCF6F5',
      }
    },
  },
  plugins: [],
}

