// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    "./**/*.{php,html,js}",
    "./src/**/*.{php,html,js}",
    "./public/**/*.{php,html,js}",
  ],
  theme: {
    container: { center: true, padding: '1rem', screens: { lg:'1024px', xl:'1200px', '2xl':'1320px' } },
    extend: {
      fontFamily: { sans: ['Figtree', ...defaultTheme.fontFamily.sans] },
      colors: {
        brand: { 50:'#eefaf3',100:'#d7f2e3',200:'#afe5c8',300:'#85d7ac',400:'#59c88f',500:'#34b66f',600:'#2b985c',700:'#237a4a',800:'#1b5d39',900:'#134229' },
        inorganico:'#2a7de1',
        peligroso:'#d3455b',
      },
      boxShadow: { soft:'0 8px 24px rgba(0,0,0,.06)' },
      borderRadius: { '2xl':'1rem' },
    },
  },
  plugins: [forms],
}
