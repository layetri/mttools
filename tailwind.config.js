const colors = require('tailwindcss/colors')

module.exports = {
  darkMode: 'class',
  purge: false,
  theme: {
    extend: {
      colors: {
        emerald: colors.emerald,
        teal: colors.teal,
        orange: colors.orange,
        lime: colors.lime,
        lightBlue: colors.lightBlue,
        white: {
          DEFAULT: '#ffffff'
        },
        black: {
          DEFAULT: '#000000'
        }
      },
      textColor: theme => theme('colors'),
      borderColor: theme => theme('colors')
    },
  },
  variants: {},
  plugins: [],
}
