const defaultTheme = require('tailwindcss/defaultTheme')
const plugin = require('tailwindcss/plugin')

module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {
      spacing: {
        px: '1px',
        0: '0',
        0.5: '0.125rem',
        1: '0.25rem',
        1.5: '0.375rem',
        2: '0.5rem',
        2.5: '0.625rem',
        3: '0.75rem',
        3.5: '0.875rem',
        4: '1rem',
        5: '1.25rem',
        6: '1.5rem',
        7: '1.75rem',
        8: '2rem',
        9: '2.25rem',
        10: '2.5rem',
        12: '3rem',
        14: '3.5rem',
        16: '4rem',
        20: '5rem',
        24: '6rem',
        28: '7rem',
        32: '8rem',
        36: '9rem',
        40: '10rem',
        44: '11rem',
        48: '12rem',
        52: '13rem',
        56: '14rem',
        60: '15rem',
        64: '16rem',
        72: '18rem',
        80: '20rem',
        96: '24rem',
      },
      fontFamily: {
        exo: ['"Exo 2"', 'Verdana', 'serif']
      },
      colors: {
        maincolor: '#03989e',
        gray: {
          ...defaultTheme.colors.gray,
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
      fontSize: {
        ...defaultTheme.fontSize,
        '2lg': ['1.5rem', { lineHeight: '1.75rem' }],
        '3lg': ['2rem', { lineHeight: '1.75rem' }],
      },
      height: (theme) => ({
        ...defaultTheme.height,
        '3k': '300px',
      }),
      maxHeight: (theme) => ({
        ...theme('spacing'),
        full: '100%',
        '50vh': '50vh',
        screen: '100vh',
      }),
      maxWidth: (theme, { breakpoints }) => ({
        none: 'none',
        0: '0rem',
        xs: '20rem',
        sm: '24rem',
        md: '28rem',
        lg: '32rem',
        xl: '36rem',
        '2xl': '42rem',
        '3xl': '48rem',
        '4xl': '56rem',
        '5xl': '64rem',
        '6xl': '72rem',
        '7xl': '80rem',
        '50vw': '50vw',
        full: '100%',
        min: 'min-content',
        max: 'max-content',
        prose: '65ch',
        ...breakpoints(theme('screens')),
      }),
      minHeight: (theme) => ({
        ...defaultTheme.minHeight,
        ...theme('spacing'),
        '50vh': '50vh',
      }),
      minWidth: {
        ...defaultTheme.minWidth,
        '40': '10rem',
        '50vw': '50vw',
      },
      boxShadow: {
        invalid: '0 0 0 0.2rem rgba(220,53,69,.25)'
      },
      inset: (theme, { negative }) => ({
        auto: 'auto',
        ...theme('spacing'),
        ...negative(theme('spacing')),
        '1/2': '50%',
        '1/3': '33.333333%',
        '2/3': '66.666667%',
        '1/4': '25%',
        '2/4': '50%',
        '3/4': '75%',
        full: '100%',
        '-1/2': '-50%',
        '-1/3': '-33.333333%',
        '-2/3': '-66.666667%',
        '-1/4': '-25%',
        '-2/4': '-50%',
        '-3/4': '-75%',
        '-full': '-100%',
      }),
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
