/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./index.php', './dashboard.php', './koneksi.php'], 
  theme: {
    extend: {  
      borderWidth: {
      '3': '3px',
    }
  },
  },
  plugins: ["prettier-plugin-tailwindcss"],
}

