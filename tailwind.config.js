const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')
const plugin = require('tailwindcss/plugin')
const flattenColorPalette = require('tailwindcss/lib/util/flattenColorPalette').default

module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
    './resources/js/**/*.js',
    './resources/sass/**/*.scss',
  ],
  darkMode: false,
  theme: {
    extend: {
      screens: {
        ...defaultTheme.screens,
        'max-sm': {'max': '639px'},
        'max-md': {'max': '767px'},
        'max-lg': {'max': '1023px'},
        'max-xl': {'max': '1279px'},
      },
      fontFamily: {
        exo: ['"Exo 2"', 'Verdana', 'serif'],
        lato: ['Lato', 'Verdana', 'serif'],
        roboto: ['Roboto', 'Verdana', 'serif'],
        muli: ['Muli', 'Verdana', 'serif'],
        glacial: ['GlacialIndifference', 'Verdana', 'serif']
      },
      spacing: {
        ...defaultTheme.spacing,
        4.05: '1.05rem',
        18: '4.5rem',
      },
      colors: {
        ...defaultTheme.colors,
        maincolor: '#03989e',
        gray: {
          50: '#00000008',
          150: '#f8fafc',
        },
        blue: {
          550: '#006266',
        },
        orange: {
          ...colors.orange,
          350: '#ffede0',
        },
        yellow: {
          350: '#f5bf1b'
        },
        teal: colors.teal,
        't-white': {
          50: 'rgba(255, 255, 255, 0.5)',
          70: 'rgba(255, 255, 255, 0.7)',
          80: 'rgba(255, 255, 255, 0.8)',
          90: 'rgba(255, 255, 255, 0.9)',
        }
      },
      fontSize: {
        ...defaultTheme.fontSize,
        '7.5xl': ['5.25rem', { lineHeight: '1' }],
      },
      height: {
        ...defaultTheme.height,
        '1/2vh': '50vh',
        '1/3vh': '33.333333vh',
        '2/3vh': '66.666667vh',
        '1/4vh': '25vh',
        '2/4vh': '50vh',
        '3/4vh': '75vh',
        '5/6vh': '83.333333vh',
        '9/10vh': '90vh'
      },
      width: {
        ...defaultTheme.width,
        fit: 'fit-content',
        '1/8': '12.5%',
        '2/8': '25%',
        '3/8': '37.5%',
        '4/8': '50%',
        '5/8': '62.5%',
        '6/8': '75%',
        '7/8': '87.5%',
      },
      maxHeight: {
        ...defaultTheme.maxHeight,
        '50vh': '50vh',
      },
      maxWidth: {
        ...defaultTheme.maxWidth,
        '50vw': '50vw',
      },
      minHeight: (theme) => ({
        ...defaultTheme.minHeight,
        ...theme('spacing'),
        '50vh': '50vh',
      }),
      minWidth: (theme) => ({
        ...defaultTheme.minWidth,
        ...theme('spacing'),
        '50vw': '50vw',
      }),
      margin: (theme, { negative }) => ({
        ...defaultTheme.margin,
        ...negative({
          '1/3': '33.333333%',
          '1/2': '50%',
        })
      }),
      padding: (theme) => ({
        ...defaultTheme.padding,
        ...theme('width'),
      }),
      borderRadius: {
        ...defaultTheme.borderRadius,
        '50p': '50%',
        '100p': '100%',
      },
      boxShadow: {
        ...defaultTheme.boxShadow,
        invalid: '0 0 0 0.2rem rgba(220, 53, 69, .25)'
      },
    }
  },
  variants: {
    textColor: ['responsive', 'hover', 'focus', 'important'],
    backgroundColor: ['responsive', 'hover', 'focus', 'important'],
    borderWidth: ['responsive', 'important'],
    borderColor: ['responsive', 'hover', 'focus', 'important'],
    margin: ['responsive', 'important'],
    padding: ['responsive', 'important'],
    lineHeight: ['responsive', 'important'],
  },
  plugins: [
    plugin(function ({ addVariant }) {
      addVariant('important', ({ container }) => {
        container.walkRules(rule => {
          rule.selector = `.${rule.selector.slice(1)}-imp`
          rule.walkDecls(decl => {
            decl.important = true
          })
        })
      })
    }),
    plugin(function ({ addUtilities, theme, variants }) {
      const colors = flattenColorPalette(theme('borderColor'))
      delete colors['default']

      const colorMap = Object.keys(colors)
        .map(color => ({
          [`.border-t-${color}`]: {borderTopColor: colors[color]},
          [`.border-r-${color}`]: {borderRightColor: colors[color]},
          [`.border-b-${color}`]: {borderBottomColor: colors[color]},
          [`.border-l-${color}`]: {borderLeftColor: colors[color]},
        }))
      const utilities = Object.assign({}, ...colorMap)

      addUtilities(utilities, variants('borderColor'))
    }),
    plugin(function ({ addUtilities, variants }) {
      const utilities = {
        '.items-normal': {
          'align-items': 'normal'
        }
      }

      addUtilities(utilities, variants('alignItems'))
    }),
  ],
}
