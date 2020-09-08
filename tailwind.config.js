const { colors } = require('tailwindcss/defaultTheme')
const plugin = require('tailwindcss/plugin')

module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {
      fontFamily: {
        exo: ['"Exo 2"', 'Verdana', 'serif']
      },
      colors: {
        gray: {
          ...colors.gray,
          50: '#00000008',
          150: '#f8fafc',
        },
        't-white': {
          50: 'rgba(255, 255, 255, 0.5)',
          70: 'rgba(255, 255, 255, 0.7)',
          80: 'rgba(255, 255, 255, 0.8)',
          90: 'rgba(255, 255, 255, 0.9)',
        }
      },
      boxShadow: {
        invalid: '0 0 0 0.2rem rgba(220,53,69,.25)'
      }
    }
  },
  variants: {
    textColor: ['responsive', 'hover', 'focus', 'important'],
    margin: ['responsive', 'important'],
    padding: ['responsive', 'important'],
  },
  plugins: [
    plugin(function({ addVariant }) {
      addVariant('important', ({ container }) => {
        container.walkRules(rule => {
          rule.selector = `.${rule.selector.slice(1)}-imp`
          rule.walkDecls(decl => {
            decl.important = true
          })
        })
      })
    })
  ],
}
