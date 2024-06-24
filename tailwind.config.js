/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: ['./index.php', './dashboard.php', './register.php', './lupaPassword.php'], 
  theme: {
    extend: {  
      borderWidth: {
      '3': '3px',
    }
  },
  },
  plugins: ["prettier-plugin-tailwindcss"],
}

