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
            background: '#0F0F0F',
            title: "#D8D8D8",
            text: "#7F8487",
            hover: "#232D3F"
        },
        boxShadow: {
            'custom-primary': '0 4px 6px -1px rgba(255, 255, 255, 0.5)',
          },
    },
  },
  plugins: [],
}
