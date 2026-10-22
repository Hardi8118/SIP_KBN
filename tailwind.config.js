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
        primary: '#0066ff', // Match the blue from the PDF mockups
        secondary: '#e5f0ff', // Match the light blue background for cards
      }
    },
  },
  plugins: [],
}
