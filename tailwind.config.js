module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors : {
        'siadi-blue-900' : '#1e2836',
        'siadi-blue-700' : '#283953',
        'siadi-blue-500' : '#006ba6',
        'siadi-blue-300' : '#38a4f5',
        'siadi-blue-100' : '#d7edfd',
        'siadi-red'      : '#ff1d25',
        'siadi-green-500': '#7ac943',
        'siadi-green-100': '#d8efc7',
        'siadi-yellow'   : '#efc20f',
        'siadi-gray'     : '#999999'
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
